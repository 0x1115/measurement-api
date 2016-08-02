<?php

namespace App\Http\Controllers;

use App\Device;
use App\Transformers\DeviceTransformer;
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

    public function index()
    {
        return $this->repository->responsePagination(Device::paginate(20));
    }

    public function show($id)
    {
        return $this->repository->responseItem(Device::findOrFail($id));
    }

    public function measurements($id)
    {
        return $this->repository->responseItem(Device::findOrFail($id), ['measurements']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $item = Device::create($request->all());

        return response()->json($this->repository->responseItem($item), 201, [
            'Location' => route('device.show', ['id' => $item->id])
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $item = Device::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Device not found'
                ]
            ], 404);
        }

        $this->validate($request, [
            'name' => 'required|max:255',
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
            return response()->json([
                'error' => [
                    'message' => 'Device not found'
                ]
            ], 404);
        }

        $item->delete();

        return $this->repository->responseItem($item);
    }
}
