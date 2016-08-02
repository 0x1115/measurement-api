<?php

namespace App\Repositories;

use App\Transformers\DeviceTransformer;

class DeviceRepositoryFractal implements DeviceRepository, Traits\FractalableContract
{
    use Traits\Fractalable;

    public function getTransformer()
    {
        return new DeviceTransformer;
    }
}