<?php
declare(strict_types=1);

namespace App\Content;

use App\Content\Task\AssetCollectionTask;
use App\Content\Task\BuildTreeTask;
use App\Content\Task\ParseContentTask;
use App\Content\Task\ContentCacheTask;
use App\Content\Task\SwitchContentDirectoryTask;
use Symfony\Component\HttpKernel\KernelInterface;

class ContentProcessor
{
    private KernelInterface $kernel;
    private ParseContentTask $parseContentTask;
    private AssetCollectionTask $assetCollectionTask;
    private SwitchContentDirectoryTask $switchContentDirectoryTask;
    private BuildTreeTask $buildTreeTask;
    /**
     * @var ContentCacheTask
     */
    private ContentCacheTask $slugMappingCacheTask;

    public function __construct(
        KernelInterface $kernel,
        BuildTreeTask $buildTreeTask,
        ParseContentTask $parseContentTask,
        AssetCollectionTask $assetCollectionTask,
        ContentCacheTask $slugMappingCacheTask,
        SwitchContentDirectoryTask $switchContentDirectoryTask
    ) {
        $this->kernel = $kernel;
        $this->parseContentTask = $parseContentTask;
        $this->assetCollectionTask = $assetCollectionTask;
        $this->switchContentDirectoryTask = $switchContentDirectoryTask;
        $this->buildTreeTask = $buildTreeTask;
        $this->slugMappingCacheTask = $slugMappingCacheTask;
    }

    public function process(): void
    {
        $config = new Config($this->kernel->getProjectDir());

        $this->buildTreeTask->run($config);
        $this->parseContentTask->run($config);
        $this->assetCollectionTask->run($config);
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->slugMappingCacheTask->run($config);
        $this->switchContentDirectoryTask->run($config);
    }
}
