<?php

namespace App\Modules\DummyName\Http\Controllers\Admin;

use App\Modules\Admin\Http\Controllers\Admin;
use App\Modules\DummyName\Models\DummyName;

class IndexController extends Admin
{
    /**
     * Возвращает модель. Функция используется в родительском контроллере
     *
     * @return DummyName
     */
    public function getModel()
    {
        return new DummyName;
    }

    public function getRules($request, $id = false)
    {
        return [];
    }
}
