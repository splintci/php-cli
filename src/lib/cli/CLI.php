<?php

namespace CynoBit\PHPCLI;

use Exception;
use CynoBit\PHPCLI\Options;

abstract class CLI
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $options;

    /**
     * Undocumented function
     */
    function __construct()
    {
        $this->options = new Options();
    }

    /**
     * Override setup to set up your CLI application options.
     *
     * @param  Options $options Options object that describes the operations and 
     *                          parameters of your CLI application.
     * @return void
     */
    abstract protected function setup(Options $options): void;

    /**
     * Undocumented function
     *
     * @return void
     */
    public function run()
    {
        if ('cli' != php_sapi_name()) {
            throw new Exception('This has to be run from the command line');
        }
        exit(0);
    }
}
