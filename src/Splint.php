<?php

namespace CynoBit;

require_once __DIR__ . '/../vendor/autoload.php';

use CynoBit\PHPCLI\CLI;
use CynoBit\PHPCLI\Options;
use CynoBit\Splint\Commands\Install;

class Splint extends CLI
{
    /**
     * Undocumented function
     *
     * @param Options $options
     * @return void
     */
    protected function setup(Options $options): void
    {
        $options->registerCommand('install', 'Install Splint Packages.');
        $options->registerCommand('run', 'Run a Job');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function main(Options $options): void
    {
        if ($options->getCommand() == 'install') {
            (new Install())->run(array_merge($options->getOption('install') ? $options->getOption('install') : [], $options->getArgs()));
        }
    }
}

$app = new Splint();

$app->run();
