<?php

namespace App\Service;

use App\Service\ServiceInterface\FileServiceInterface;

class FileService implements FileServiceInterface
{
    /**
     * @var string
     */
    private string $appBasePath;

    /**
     * FileService constructor.
     *
     * @param string $appBasePath
     */
    public function __construct(string $appBasePath)
    {
        $this->appBasePath = $appBasePath;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public function checkIfExists(string $path): bool
    {
        return file_exists($path);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function filePath(string $path): string
    {
        return sprintf('%s/%s', $this->appBasePath, $path);
    }
}
