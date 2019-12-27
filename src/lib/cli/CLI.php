<?php

namespace CynoBit\PHPCLI;

use CynoBit\PHPCLI\Options;

abstract class CLI
{
    abstract protected function setup(Options $options): void;
}
