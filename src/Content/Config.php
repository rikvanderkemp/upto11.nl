<?php


namespace App\Content;

class Config
{
    /**
     * Directory to read content from
     *
     * @var string
     */
    public string $contentDir;

    /**
     * The directory parsed content is stored in
     *
     * @var string
     */
    public string $finalDir = '';

    /**
     * Temporary directory for processing all content
     *
     * @var string
     */
    public string $processDir = '';

    public string $processAssetsDir;

    public function __construct(string $rootDir)
    {
        $this->contentDir = $rootDir . '/content/';
        $this->processDir = $rootDir . '/content-' . time() . '/';
        $this->finalDir = $rootDir . '/content-parsed/';
        $this->processAssetsDir = $this->processDir . 'assets/';
    }
}
