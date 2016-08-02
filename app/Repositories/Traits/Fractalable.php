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
            ->serializeWith(new \League\Fractal\Serializer\JsonApiSerializer())
            ->paginateWith(new \League\Fractal\Pagination\IlluminatePaginatorAdapter($paginator));
    }

    public function responsePagination(\Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator)
    {
        return $this->pagination($paginator)->toArray();
    }
}