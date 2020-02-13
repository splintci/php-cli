<?php

namespace CynoBit\PHPCLI;

trait Printer
{
    public function println(string $string): void
    {
        echo $string . PHP_EOL;
    }
}
