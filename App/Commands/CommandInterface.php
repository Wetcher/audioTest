<?php

namespace App\Commands;

interface CommandInterface
{
    public function execute(array $args): void;
}
