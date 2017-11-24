<?php

namespace Akhan\Modules\Middleware;

use Akhan\Modules\Modules;
use Closure;

class IdentifyModule
{
    /**
     * @var Akhan\Modules
     */
    protected $module;

    /**
     * Create a new IdentifyModule instance.
     *
     * @param Akhan\Modules $module
     */
    public function __construct(Modules $module)
    {
        $this->module = $module;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $slug = null)
    {
        $request->session()->flash('module', $this->module->where('slug', $slug));

        return $next($request);
    }
}
