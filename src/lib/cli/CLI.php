<?php

namespace CynoBit\PHPCLI;

use Exception;
use CynoBit\PHPCLI\Options;

abstract class CLI
{
    /**
     * Undocumented variable
     *
     * @var Options
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

    abstract public function main(Options $options): void;

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

        $this->setup($this->options);
        $this->registerDefaultOptions();
        $this->parseOptions();
        $this->handleDefaultOptions();
        //$this->checkArgments();
        $this->main($this->options);
        exit(0);
    }

    protected function registerDefaultOptions(): void
    {
        $this->options->registerOption(
            'help',
            'Display application help screen.',
            'h'
        );
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function handleDefaultOptions(): void
    {
        if ($this->options->getOption('help')) {
            echo $this->options->help();
            exit(0);
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function parseOptions(): void
    {
        $this->options->parseOptions();
    }
}
