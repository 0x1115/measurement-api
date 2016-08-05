<?php

namespace App\Repositories;

use App\Transformers\MeasurementTransformer;

class MeasurementRepositoryFractal implements MeasurementRepository, Traits\FractalableContract
{
    use Traits\Fractalable;

    protected $request;

    public function setRequest(\Illuminate\Http\Request $request) {
        $this->request = $request;
    }

    public function getTransformer()
    {
        return new MeasurementTransformer;
    }
}