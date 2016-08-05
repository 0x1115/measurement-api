<?php

namespace App\Http\Middleware;

use Closure;

class ParseQueries
{
    protected function parseCreatedAt($request)
    {
        $config = config('app.api.queries.created_at', ['default' => 'today']);
        $created_at = null;
        if ($request->has('created_at')) {
            $created_at = $request->input('created_at');
            try {
                $timestamp = new \Carbon\Carbon($created_at);
                $request->merge([
                    'created_at' => $timestamp,
                    '_created_at' => $created_at
                ]);
            } catch (\Exception $e) {
                $created_at = null;
            }
        }

        /**
         * Created at default value
         */
        if (!$created_at) {
            $request->merge([
                'created_at' => new \Carbon\Carbon($config['default']),
                '_created_at' => $created_at
            ]);
        }
    }

    protected function parseLimit($request)
    {
        $config = config('app.api.queries.limit', ['default' => 250, 'min' => 0, 'max' => 500]);
        $limit = null;
        if ($request->has('limit')) {
            $limit = $request->input('limit');
            $limitParsed = (int) $limit;
            if ($limitParsed < $config['min']) {
                $limitParsed = null;
            }
            if ($limitParsed > $config['max']) {
                $limitParsed = $config['max'];
            }

            if ($limitParsed) {
                $request->merge([
                    'limit' => $limitParsed,
                    '_limit' => $limit
                ]);
            } else {
                $limit = null;
            }
        }

        /**
         * Limit default value
         */
        if (!$limit) {
            $request->merge([
                'limit' => $config['default'],
                '_limit' => $limit
            ]);
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->parseCreatedAt($request);

        $this->parseLimit($request);

        return $next($request);
    }
}
