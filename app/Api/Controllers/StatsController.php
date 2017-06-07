<?php

namespace App\Api\Controllers;

use App\Services\Stats\Exceptions\InvalidHandlerException;
use App\Services\Stats\Stats;

class StatsController extends Controller
{
    protected $stats;

    public function __construct()
    {
        $this->stats = new Stats();
    }

    public function read($handler)
    {
        if (empty($handler)) {
            abort(400, 'handler was not supplied to controller');
        }

        try {
            $handler = $this->stats->useHandler($handler);
        } catch (InvalidHandlerException $e) {
            abort(400, $handler . ' handler was not found');
        }

        return response()->json($handler->read());
    }
}
