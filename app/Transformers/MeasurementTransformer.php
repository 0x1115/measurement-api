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
            'temperature' => (double) $item->temperature,
            'created_at' => $item->created_at->toIso8601String(),
            'updated_at' => $item->updated_at->toIso8601String(),
        ];
    }

    public function includeDevice(Measurement $item)
    {
        $repository = app(\App\Repositories\DeviceRepository::class);
        return $this->item($item->device, $repository->getTransformer());
    }

}