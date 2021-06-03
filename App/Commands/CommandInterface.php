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
    public function doExecute(array $arguments): void;
}
