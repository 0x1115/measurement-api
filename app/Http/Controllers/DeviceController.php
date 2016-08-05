<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Repositories\DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->repository->setRequest($request);
        return $this->repository->responseFilteredPagination((new Device)->newQuery());
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

    public function measurements(Request $request, $id)
    {
        try {
            $item = Device::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Device not found');
        }

        if (\Gate::denies('read-device-measurements', $item)) {
            abort(403, 'Permission insufficient');
        }

        return $this->repository->responseItem($item, ['measurements']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'mac_address' => 'required|unique:devices'
        ]);

        $item = $request->user()->devices()->create($request->all());

        return response()->json($this->repository->responseItem($item), 201, [
            'Location' => route('device.show', ['id' => $item->id])
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $item = Device::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Device not found');
        }

        if (\Gate::denies('update-device', $item)) {
            abort(403, 'Permission insufficient');
        }

        $this->validate($request, [
            'name' => 'sometimes|required|max:255',
            'mac_address' => 'sometimes|required|unique:devices,mac_address,' . $item->id
        ]);

        $item->fill($request->all());
        $item->save();

        return $this->repository->responseItem($item);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $item = Device::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Device not found');
        }

        if (\Gate::denies('destroy-device', $item)) {
            abort(403, 'Permission insufficient');
        }

        $item->delete();

        return $this->repository->responseItem($item);
    }
}
