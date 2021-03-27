<?php
declare(strict_types=1);

namespace App\Content\Task;

use App\Content\Config;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class AssetCollectionTask implements Task
{
    public function run(Config $config): void
    {
        $fileSystem = new Filesystem();

        foreach ((new Finder())->in($config->contentDir)->directories()->name('assets') as $directory) {
            $finalAssetDir = $config->processAssetsDir . $directory->getRelativePath();

            foreach ((new Finder())->in($directory->getRealPath())->files()->name('*') as $fileInfo) {
                $fileSystem->copy($fileInfo->getRealPath(), $finalAssetDir . '/' . $fileInfo->getFilename());
            }
        }
    }
}
