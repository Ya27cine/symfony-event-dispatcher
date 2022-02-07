<?php

namespace App;

class Logger
{
    public function log(string $loginfo)
    {
        dump("LOGGING FICTIF : " . $loginfo);
    }
}
