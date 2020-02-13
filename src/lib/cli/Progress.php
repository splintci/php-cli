<?php

namespace CynoBit\PHPCLI;

class Progress
{
    protected $length;

    use Printer;

    /**
     * Undocumented function
     *
     * @param integer $length
     */
    public function __construct(int $length = 30)
    {
        $this->length = $length;
    }

    /**
     * Undocumented function
     *
     * @param integer $progress
     * @return void
     */
    public function render(int $progress): void
    {
    }
}
