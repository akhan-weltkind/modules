<?php

namespace Akhan\Modules\Console\Generators;

use Akhan\Modules\Modules;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Helper\ProgressBar;

class MakeModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module
        {slug : The slug of the module}
        {--Q|quick : Skip the make:module wizard and use default values}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Akhan module and bootstrap it';

    /**
     * The modules instance.
     *
     * @var Modules
     */
    protected $module;

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Array to store the configuration details.
     *
     * @var array
     */
    protected $container;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     * @param Modules    $module
     */
    public function __construct(Filesystem $files, Modules $module)
    {
        parent::__construct();

        $this->files = $files;
        $this->module = $module;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->container['slug'] = str_slug($this->argument('slug'));
        $this->container['name'] = studly_case($this->container['slug']);

        if ($this->option('quick')) {
            $this->container['basename']    = studly_case($this->container['slug']);
            $this->container['namespace']   = config('modules.namespace').$this->container['basename'];
            return $this->generate();
        }

        $this->stepOne();
    }

    /**
     * Step 1: Configure module manifest.
     *
     * @return mixed
     */
    protected function stepOne()
    {
        $this->container['name'] = $this->ask('Please enter the name of the module:', $this->container['name']);
        $this->container['slug'] = $this->ask('Please enter the slug for the module:', $this->container['slug']);
        $this->container['basename'] = studly_case($this->container['slug']);
        $this->container['namespace'] = config('modules.namespace').$this->container['basename'];

        $this->comment('You have provided the following manifest information:');
        $this->comment('Name:                       '.$this->container['name']);
        $this->comment('Slug:                       '.$this->container['slug']);
        $this->comment('Basename (auto-generated):  '.$this->container['basename']);
        $this->comment('Namespace (auto-generated): '.$this->container['namespace']);

        $this->generate();


        return true;
    }

    /**
     * Generate the module.
     */
    protected function generate()
    {

        $steps = [
            'Generating module...'       => 'generateModule',
            'Optimizing module cache...' => 'optimizeModules',
        ];

        $progress = new ProgressBar($this->output, count($steps));
        $progress->start();

        foreach ($steps as $message => $function) {
            $progress->setMessage($message);

            $this->$function();

            $progress->advance();
        }


        $this->callSilent('make:module:model',[ 'slug' => $this->container['slug'] ]);
        $this->callSilent('make:module:migration',['slug' => $this->container['slug']]);

        $progress->finish();

        event($this->container['slug'].'.module.made');

        $this->info("\nModule generated successfully.");
    }

    /**
     * Generate defined module folders.
     */
    protected function generateModule()
    {
        if (!$this->files->isDirectory(module_path())) {
            $this->files->makeDirectory(module_path());
        }

        $pathMap = config('modules.pathMap');
        $directory = module_path(null, $this->container['basename']);
        $source = __DIR__.'/../../../resources/stubs/module';

        $this->files->makeDirectory($directory);

        $sourceFiles = $this->files->allFiles($source, true);

        if (!empty($pathMap)) {
            $search = array_keys($pathMap);
            $replace = array_values($pathMap);
        }

        foreach ($sourceFiles as $file) {
            $contents = $this->replacePlaceholders($file->getContents());
            $subPath = $file->getRelativePathname();

            if (!empty($pathMap)) {
                $subPath = str_replace($search, $replace, $subPath);
            }

            $filePath = $directory.'/'.$subPath;
            $dir = dirname($filePath);

            if (!$this->files->isDirectory($dir)) {
                $this->files->makeDirectory($dir, 0755, true);
            }

            $this->files->put($filePath, $contents);
        }
    }

    /**
     * Reset module cache of enabled and disabled modules.
     */
    protected function optimizeModules()
    {
        return $this->callSilent('module:optimize');
    }

    /**
     * Pull the given stub file contents and display them on screen.
     *
     * @param string $file
     * @param string $level
     *
     * @return mixed
     */
    protected function displayHeader($file = '', $level = 'info')
    {
        $stub = $this->files->get(__DIR__.'/../../../resources/stubs/console/'.$file.'.stub');

        return $this->$level($stub);
    }

    protected function replacePlaceholders($contents)
    {
        $find = [
            'DummyBasename',
            'DummyNamespace',
            'DummyName',
            'DummySlug'
        ];

        $replace = [
            $this->container['basename'],
            $this->container['namespace'],
            $this->container['name'],
            $this->container['slug']
        ];

        return str_replace($find, $replace, $contents);
    }
}
