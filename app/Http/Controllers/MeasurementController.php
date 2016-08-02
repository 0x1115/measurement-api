<?php

namespace App\Http\Controllers;

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
        return $this->repository->responsePagination(Measurement::paginate(20));
    }

    public function show($id)
    {
        return $this->repository->responseItem(Measurement::findOrFail($id));
    }

    public function device($id)
    {
        return $this->repository->responseItem(Measurement::findOrFail($id), ['device']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $item = Measurement::create($request->all());

        return response()->json($this->repository->responseItem($item), 201, [
            'Location' => route('measurement.show', ['id' => $item->id])
        ]);
    }

    public function update(Request $request, $id)
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
