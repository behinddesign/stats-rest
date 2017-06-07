<?php

namespace App\Services\Stats\Handlers;

use App\Services\Stats\Contracts\Handler;

class Disks implements Handler
{
    public function config(array $config = null)
    {
        //
    }

    public function read()
    {
        $df = shell_exec('df -h');

        return $this->parseDf($df);
    }

    private function parseDf($df)
    {
        $pattern = '/\/dev\/(.*?)\s+([0-9]+(?:G|M|K)i?)\s+([0-9]+(?:G|M|K)i?)\s+([0-9]+(?:G|M|K)i?)\s+([0-9]{1,3})/';

        $matches = [];
        preg_match_all($pattern, $df, $matches, PREG_SET_ORDER);

        if (empty($matches)) {
            return false;
        }

        return $this->restructureDf($matches);
    }

    private function restructureDf($matches)
    {
        $newStructure = [];

        foreach ($matches as $match) {
            $newStructure[] = [
                'filesystem' => $match[1],
                'size' => $this->removeMacSpecificDenomination($match[2]),
                'used' => $this->removeMacSpecificDenomination($match[3]),
                'available' => $this->removeMacSpecificDenomination($match[4]),
                'used_pc' => $match[5]
            ];
        }

        return $newStructure;
    }

    private function removeMacSpecificDenomination($str)
    {
        return str_replace('i', '', $str);
    }
}
