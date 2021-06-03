<?php


namespace App\Commands;

use Exception;

abstract class AbstractCommand implements CommandInterface
{
    /**
     * @var string[]
     */
    protected array $argumentOptions = [];

    /**
     * @var string[]
    */
    protected array $requiredOptions = [];

    /**
     * @var string[]
     */
    private array $arguments = [];

    /**
     * AbstractCommand constructor.
     */
    public function __construct()
    {
        $arguments = getopt('', $this->argumentOptions);
        $this->setArguments($arguments);
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $this->validateRequired();
    }

    /**
     * @throws Exception
     */
    private function validateRequired(): void {
        $requiredOptions = $this->requiredOptions;
        $arguments = $this->getArguments();
        $missingOptions = [];
        foreach ($requiredOptions as $requiredOption) {
            if(!isset($arguments[$requiredOption])) {
                $missingOptions[] = $requiredOption;
            }
        }

        if(count($missingOptions) > 0) {
            throw new Exception(sprintf('Options "%s" are required', implode(',', $missingOptions)));
        }
    }

    /**
     * @return array
     */
    protected function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param string[] $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }
}
