<?php

namespace CynoBit\PHPCLI;

use Exception;

class Options
{
    /**
     * [getArgV Safely gets the command line arguments]
     *
     * @throws Exception
     * 
     * @return array
     */
    private function getArgV(): array
    {
        global $argv;
        if (!is_array($argv)) {
            if (!@is_array($_SERVER['argv'])) {
                if (!@is_array($GLOBALS['HTTP_SERVER_VARS']['argv'])) {
                    throw new Exception("Could not read cmd args (register_argc_argv=Off?)");
                }
                return $GLOBALS['HTTP_SERVER_VARS']['argv'];
            }
            return $_SERVER['argv'];
        }
        return $argv;
    }
}
