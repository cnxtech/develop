<?php

namespace Codex\Documents\Processors\Parser\CodexMark;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Util\Configuration;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Util\Xml;

class FencedCodeRenderer extends \League\CommonMark\Block\Renderer\FencedCodeRenderer implements ConfigurationAwareInterface
{
    /** @var Configuration */
    protected $config;

    /**
     * @param FencedCode               $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool                     $inTightList
     *
     * @return HtmlElement
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        if ( ! ($block instanceof FencedCode)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        $attrs = [];
        foreach ($block->getData('attributes', []) as $key => $value) {
            $attrs[ $key ] = Xml::escape($value, true);
        }

        $infoWords           = $block->getInfoWords();
        $attrs[ 'language' ] = 'php';
        if (count($infoWords) !== 0 && strlen($infoWords[ 0 ]) !== 0) {
            $attrs[ 'language' ] = Xml::escape($infoWords[ 0 ], true);
        }

        $content  = Xml::escape($block->getStringContent()); //Asciimath
        $language = strtolower($attrs[ 'language' ]);
        if ($language === 'mermaid' || $language === 'chart' || $language === 'mathjax' || $language === 'katex' || $language === 'asciimath' || $language === 'nomnoml') {
            return new HtmlElement('c-code-renderer', $attrs, $content);
        }
        if ($language === 'hyper') {
            return new HtmlElement('c-hyper', $attrs, $content);
        }

//        $attrs['props'] = array_replace_recursive(
//            $this->config->getConfig('element_attributes/c-code-highlight', []),
//            ['language' => $attrs['language']]
//        );
        $attrs = array_replace_recursive($attrs, $this->config->getConfig('element_attributes/c-code-highlight', []));
//        $match = preg_match_all('/@var\s(.*?)\s\$(.*?)[\s\*]/m', $content, $matches);
//        if ($match && count($matches[ 0 ]) > 0) {
//            foreach ($matches[ 0 ] as $k => $v) {
//                $original     = $matches[ 0 ][ $k ];
//                $replacement= $matches[ 0 ][ $k ];
//                $type         = $matches[ 1 ][ $k ];
//                $variableName = $matches[ 2 ][ $k ];
//                $linkProps     = json_encode([
//                    'fqsen'     => $type,
//                    'action'    => 'drawer',
//                    'modifiers' => ['popover','!styling','!icon'],
//                ], JSON_UNESCAPED_SLASHES);
//
//                $replacement=str_replace($type, "<phpdoc-link props='{$linkProps}'>{$type}</phpdoc-link>", $replacement);
//                $content=str_replace_first($original, $replacement, $content);
//            }
//        }
        return new HtmlElement('c-code-highlight', $attrs, $content);
    }

    public function setConfiguration(Configuration $configuration)
    {
        $this->config = $configuration;
    }
}
