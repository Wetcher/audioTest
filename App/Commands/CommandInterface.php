<?php

namespace App\Commands;

use Exception;

interface CommandInterface
{
    /**
     * @throws Exception;
     */
    public function execute(): void;
}
