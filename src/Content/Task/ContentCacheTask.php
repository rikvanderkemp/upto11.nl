<?php
declare(strict_types=1);

namespace App\Content\Task;

use App\Content\Config;
use App\Parser\FrontMatterParser;
use Symfony\Component\Finder\Finder;

class ContentCacheTask implements Task
{
    public function run(Config $config): void
    {
        $json = [];
        $frontMatterParser = new FrontMatterParser();

        foreach ((new Finder())->in($config->contentDir)->name('*.md') as $file) {
            $filePath = $file->getRelativePath() . '/' . $file->getFilenameWithoutExtension() . '.html';
            $finalTargetFile = $config->finalDir . $filePath;
            $frontMatterDocument = $frontMatterParser->parse($file->getContents());

            if (null === $frontMatterDocument->getProperties()->getSlug()) {
                continue;
            }

            $slug = ltrim($file->getRelativePath() . '/' . $frontMatterDocument->getProperties()->getSlug(), '/');

            $json[$slug] = [
                'file' => $finalTargetFile,
                'properties' => $frontMatterDocument->getProperties()->toArray()
            ];
        }

        file_put_contents($config->processDir . 'cache.json', json_encode($json, JSON_THROW_ON_ERROR));
    }
}
