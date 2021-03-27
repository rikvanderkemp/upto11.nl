<?php
declare(strict_types=1);

namespace App\CommonMark\Extension;

use App\CommonMark\Parser\Upto11BlocksParser;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class Upto11BlocksExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
            ->addBlockParser(new Upto11BlocksParser(), 20)
            ->addBlockRenderer(
                Upto11Block::class,
                new Upto11BlockRender(
                    $environment->getConfig("articles", []),
                    $environment->getConfig("twig", null),
                ),
                0
            );
    }
}
