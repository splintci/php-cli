<?php

namespace CynoBit\PHPCLI;

class Option
{
    protected $app;
    private function getArgV(): array
    {
        global $argv;
        if (!is_array($argv)) {
            if (!@is_array($_SERVER['argv'])) {
                if (!@is_array($GLOBALS['HTTP_SERVER_VARS']['argv'])) {
                    throw new Exception(
                        "Could not read cmd args (register_argc_argv=Off?)",
                        Exception::E_ARG_READ
                    );
                }
                return $GLOBALS['HTTP_SERVER_VARS']['argv'];
            }
            return $_SERVER['argv'];
        }
        return $argv;
    }
}
