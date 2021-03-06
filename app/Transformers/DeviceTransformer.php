<?php
namespace App\Transformers;

use App\Device;
use League\Fractal;
use \Illuminate\Support\Facades\Request;
class DeviceTransformer extends Fractal\TransformerAbstract
{
    protected $availableIncludes = [
        'measurements'
    ];

    public function transform(Device $item)
    {
        return [
            'id' => (int) $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'mac_address' => $item->mac_address,
            'created_at' => $item->created_at->toIso8601String(),
            'updated_at' => $item->updated_at->toIso8601String(),
        ];
    }

    public function includeMeasurements(Device $item)
    {
        $repository = app(\App\Repositories\MeasurementRepository::class);
        $repository->setRequest(app('request'));
        return $repository->filteredPagination(
            $item->measurements()
        )->getResource();
    }
}