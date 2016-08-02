<?php
namespace App\Transformers;

use App\Measurement;
use League\Fractal;

class MeasurementTransformer extends Fractal\TransformerAbstract
{
    protected $availableIncludes = [
        'device'
    ];

    public function transform(Measurement $item)
    {
        return [
            'id'      => (int) $item->id,
            'humidity'   => (double) $item->humidity,
            'temperature' => (int) $item->temperature,
        ];
    }

    public function includeDevice(Measurement $item)
    {
        $repository = app(\App\Repositories\DeviceRepository::class);
        return $this->item($item->device, $repository->getTransformer());
    }

}