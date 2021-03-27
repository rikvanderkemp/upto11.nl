<?php
declare(strict_types=1);

namespace App\Content\Task;

use App\CommonMark\CommonMarkConverter;
use App\Content\Config;
use App\Parser\FrontMatterParser;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Twig\Environment;

/**
 * Parses all content files from markdown to HTML into our process directory.
 */
class ParseContentTask implements Task
{
    /**
     * @var Environment
     */
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function run(Config $config): void
    {
        if (!is_dir($config->processDir)) {
            throw new RuntimeException('Can not find our process directory, did you run BuildTree?');
        }

        $converter = new CommonMarkConverter([
            'articles' => $this->collectArticles($config),
            'twig' => $this->twig
        ]);

        $fileSystem = new Filesystem();

        foreach ((new Finder())->in($config->contentDir)->name('*.md') as $file) {
            $fileSystem->mkdir($config->contentDir . $file->getRelativePath(), 0755);

            $filePath = $file->getRelativePath() . '/' . $file->getFilenameWithoutExtension() . '.html';
            $targetFile = $config->processDir . $filePath;

            $frontMatterDocument = (new FrontMatterParser())->parse($file->getContents());
            $html = $converter->convertToHtml($frontMatterDocument->getBody());

            file_put_contents($targetFile, $html);
        }
    }

    private function collectArticles(Config $config):  array
    {
        $articles = [];

        foreach ((new Finder())->in($config->contentDir)->name('*.md') as $file) {
            $frontMatterDocument = (new FrontMatterParser())->parse($file->getContents());

            if ($frontMatterDocument->getProperties()->getType() !== 'article') {
                continue;
            }

            $frontMatterDocument->setUri(
                ltrim(
                    $file->getRelativePath() . '/' . $frontMatterDocument->getProperties()->getSlug(),
                    '/'
                )
            );

            $articles[] = $frontMatterDocument;
        }

        return $articles;
    }
}
