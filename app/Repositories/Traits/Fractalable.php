<?php

namespace App\Repositories\Traits;

trait Fractalable
{
    public function responseCollection(\Illuminate\Support\Collection $collection)
    {
        return fractal()->collection($collection, $this->getTransformer())->toArray();
    }

    public function responseItem(\Illuminate\Database\Eloquent\Model $item, $with = null)
    {
        return fractal()->item($item, $this->getTransformer())->parseIncludes($with)->toArray();
    }

    public function pagination(\Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator)
    {
        return fractal()
            ->collection($paginator->getCollection(), $this->getTransformer())
            ->serializeWith(new \League\Fractal\Serializer\DataArraySerializer())
            ->paginateWith(new \League\Fractal\Pagination\IlluminatePaginatorAdapter($paginator));
    }

    public function responsePagination(\Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator)
    {
        return $this->pagination($paginator)->toArray();
    }

    protected function formatQuery($query)
    {
        $limit = null;
        $created_at = null;

        if ($this->request->has('limit')) {
            $limit = (int) $this->request->input('limit');
        }
        if ($this->request->has('created_at')) {
            $created_at = $this->request->input('created_at');
            if (!$created_at instanceof \Carbon\Carbon) {
                $created_at = null;
            }
        }

        if ($created_at) {
            $query = $query->where('created_at', '>=', $created_at);
        }
        return $query->paginate($limit ?: null);
    }

    public function responseFilteredPagination($query)
    {
        return $this->filteredPagination($query)->toArray();
    }

    public function filteredPagination($query)
    {
        return $this->pagination($this->formatQuery($query));
    }
}