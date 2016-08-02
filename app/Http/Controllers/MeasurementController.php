<?php

namespace App\Http\Controllers;

use App\Device;
use App\Measurement;
use App\Transformers\MeasurementTransformer;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\MeasurementRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->responsePagination(Measurement::paginate());
    }

    public function show($id)
    {
        try {
            $item = Device::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Device not found');
        }

        return $this->repository->responseItem($item);
    }

    public function device($id)
    {
        try {
            $item = Device::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Device not found');
        }
        return $this->repository->responseItem($item, ['device']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'humidity' => 'required|numeric',
            'temperature' => 'required|numeric',
            'device_id' => 'required|exists:devices,id'
        ]);

        $device = Device::findOrFail($request->input('device_id'));
        if (\Gate::denies('store-device-measurements', $device)) {
            abort(403, 'Permission insufficient');
        }

        $item = $device->measurements()->create($request->all());

        return response()->json($this->repository->responseItem($item), 201, [
            'Location' => route('measurement.show', ['id' => $item->id])
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $item = Measurement::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Device not found');
        }

        $this->validate($request, [
            'name' => 'required|max:255',
            'humidity' => 'required|numeric',
            'temperature' => 'required|numeric',
            'device_id' => 'required|exists:devices,id'
        ]);

        $device = Device::findOrFail($request->input('device_id'));
        if (\Gate::denies('update-device-measurements', $device)) {
            abort(403, 'Permission insufficient');
        }

        $item->fill($request->all());
        $item->save();

        return $this->repository->responseItem($item);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $item = Measurement::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Measurement not found'
                ]
            ], 404);
        }

        $item->delete();

        return $this->repository->responseItem($item);
    }
}
