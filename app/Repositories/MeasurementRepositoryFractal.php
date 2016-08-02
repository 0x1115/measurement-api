<?php

namespace App\Repositories;

use App\Transformers\MeasurementTransformer;

class MeasurementRepositoryFractal implements MeasurementRepository, Traits\FractalableContract
{
    use Traits\Fractalable;

    public function getTransformer()
    {
        return new MeasurementTransformer;
    }
}