<?php

namespace App\CommonMark\Extension;

use App\Document\FrontMatterDocument;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use Twig\Environment;

final class Upto11BlockRender implements BlockRendererInterface
{
    /**
     * @var FrontMatterDocument[]
     */
    private array $articles;
    private ?Environment $twig;

    public function __construct(array $articles = [], ?Environment $twig = null)
    {
        $this->articles = $articles;
        $this->twig = $twig;
    }

    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return new HtmlElement(
            'div',
            [],
            $this->twig->render('_articles.html.twig', ['articles' => $this->articles]),
            true
        );
    }
}
