<?php

namespace App\Config;

class Config implements ConfigInterface
{
    private $configValues;

    /**
     * Config constructor.
     * @param string $filePath
     * @param FileParserInterface $parser
     * @throws FileNotFoundException
     */
    public function __construct($filePath, FileParserInterface $parser)
    {
        try {
            $resource = file_get_contents($filePath);
        } catch (\Throwable $e) {
            throw new FileNotFoundException();
        }
        $this->configValues = $parser->parse($resource);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->configValues[$key] ?? '';
    }
}