<?php

namespace App\Repositories;

use App\Transformers\DeviceTransformer;

class DeviceRepositoryFractal implements DeviceRepository, Traits\FractalableContract
{
    use Traits\Fractalable;

    protected $request;

    public function setRequest(\Illuminate\Http\Request $request) {
        $this->request = $request;
    }

    public function getTransformer()
    {
        return new DeviceTransformer;
    }
}