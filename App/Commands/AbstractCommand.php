<?php


namespace App\Commands;

use Exception;

abstract class AbstractCommand implements CommandInterface
{
    /**
     * @var string[]
     */
    protected array $requiredOptions = [];

    /**
     * @param array $arguments
     *
     * @throws Exception
     */
    abstract protected function doExecute(array $arguments);

    /**
     * @param array $arguments
     *
     * @throws Exception
     */
    public function execute(array $arguments): void
    {
        $this->validateRequired($arguments);
        $this->doExecute($arguments);
    }

    /**
     * @param array $arguments
     *
     * @throws Exception
     */
    private function validateRequired(array $arguments): void
    {
        $requiredOptions = $this->requiredOptions;
        $missingOptions = [];
        foreach ($requiredOptions as $requiredOption) {
            if (!isset($arguments[$requiredOption])) {
                $missingOptions[] = $requiredOption;
            }
        }

        if (count($missingOptions) > 0) {
            throw new Exception(sprintf('Options "%s" are required', implode(',', $missingOptions)));
        }
    }
}
