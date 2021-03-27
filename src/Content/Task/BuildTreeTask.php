<?php
declare(strict_types=1);

namespace App\Content\Task;

use App\Content\Config;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Replicates content tree based on given root content directory
 */
class BuildTreeTask implements Task
{
    public function run(Config $config): void
    {
        $fileSystem = new Filesystem();
        $fileSystem->mkdir($config->processDir, 0755);

        $this->createContentDirectories($config, $fileSystem);
        $this->createAssetsDirectories($config, $fileSystem);
    }

    private function createContentDirectories(Config $config, Filesystem $fileSystem): void
    {
        foreach ((new Finder())->in($config->contentDir)->name('*.md') as $file) {
            $fileSystem->mkdir($config->processDir . $file->getRelativePath(), 0755);
        }
    }

    private function createAssetsDirectories(Config $config, Filesystem $fileSystem): void
    {
        $fileSystem->mkdir($config->processAssetsDir, 0755);

        foreach ((new Finder())->in($config->contentDir)->directories()->name('assets') as $directory) {
            $finalAssetDir = $config->processAssetsDir . $directory->getRelativePath();
            $fileSystem->mkdir($finalAssetDir, 0755);
        }
    }
}
