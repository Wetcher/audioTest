<?php


namespace App\Service\ServiceInterface;


interface FileServiceInterface
{
    /**
     * @param string $path
     *
     * @return bool
     */
    public function checkIfExists(string $path): bool;

    /**
     * @param string $path
     *
     * @return string
     */
    public function filePath(string $path): string;
}
