<?php

namespace App\Commands;

use Exception;

interface CommandInterface
{
    /**
     * @param array $arguments
     *
     * @throws Exception
     */
    public function execute(array $arguments): void;
}
