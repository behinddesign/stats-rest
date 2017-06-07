<?php

namespace App\Services\Stats\Contracts;

interface Handler
{
    public function config(array $config = null);

    /**
     * Output the results of the stats handler, returned as an array which can be parsed by json encoder
     *
     * @return array
     */
    public function read();
}
