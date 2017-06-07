<?php

namespace App\Services\Stats;

use App\Services\Stats\Contracts\Handler;
use App\Services\Stats\Exceptions\InvalidHandlerException;

class Stats
{
    protected $handler;

    /**
     * Sets the handler to be used for the incoming request
     *
     * @param $handler
     * @return Handler
     * @throws InvalidHandlerException
     */
    public function useHandler($handler)
    {
        if (empty($handler)) {
            throw new InvalidHandlerException('handler was not supplied');
        }

        $handler = $this->normaliseClassName($handler);

        $class = '\\App\\Services\\Stats\\Handlers\\' . $handler;

        if (!class_exists($class)) {
            throw new InvalidHandlerException('handler could not be found ' . $class);
        }

        return new $class;
    }

    private function normaliseClassName($handler)
    {
        $handler = str_replace('_', ' ', $handler);
        $handler = str_replace('-', ' ', $handler);
        $handler = ucwords($handler);
        $handler = str_replace(' ', '', $handler);

        return $handler;
    }
}
