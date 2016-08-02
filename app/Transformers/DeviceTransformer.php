<?php
namespace App\Transformers;

use App\Device;
use League\Fractal;

class DeviceTransformer extends Fractal\TransformerAbstract
{
    protected $availableIncludes = [
        'measurements'
    ];

    public function transform(Device $item)
    {
        return [
            'id'      => (int) $item->id,
            'name'   => $item->name,
            'description' => $item->description,
        ];
    }

    public function includeMeasurements(Device $item)
    {
        $repository = app(\App\Repositories\MeasurementRepository::class);
        return $repository->pagination(
            $item->measurements()->paginate()
        )->getResource();
    }
}