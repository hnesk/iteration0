<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 03.01.15
 * Time: 00:07
 */

namespace CmsBundle\Service;

use Civilized\Type\Url;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Knp\Bundle\MarkdownBundle\Parser\MarkdownParser;
use Symfony\Component\Routing\RequestContext;

class ContextMarkdownParser extends MarkdownParser implements MarkdownParserInterface
{
    /** @var RequestContext|null */
    protected $context = null;

    public function setRequestContext(RequestContext $context)
    {
        $this->context = $context;
    }

    /**
     * @param  string $text
     * @return string
     */
    public function transformMarkdown($text)
    {
        $text = parent::transformMarkdown($text);
        $this->context = null;

        return $text;
    }

    protected function _doImages_inline_callback($matches)
    {
        $alt_text        = $matches[2];
        $url            = $matches[3] == '' ? $matches[4] : $matches[3];
        $title            = & $matches[7];
        $attr  = $this->doExtraAttributes("img", $dummy = & $matches[8]);

        $alt_text = $this->encodeAttribute($alt_text);
        $url = $this->encodeAttribute($this->processResource($url));
        $result = "<img src=\"$url\" alt=\"$alt_text\"";
        if (isset($title)) {
            $title = $this->encodeAttribute($title);
            $result .=  " title=\"$title\""; # $title already quoted
        }
        $result .= $attr;
        $result .= $this->empty_element_suffix;

        return $this->hashPart($result);
    }

    protected function _doAnchors_inline_callback($matches)
    {
        $whole_match    =  $matches[1];
        $link_text        =  $this->runSpanGamut($matches[2]);
        $url            =  $matches[3] == '' ? $matches[4] : $matches[3];
        $title            = & $matches[7];
        $attr  = $this->doExtraAttributes("a", $dummy = & $matches[8]);

        $url = $this->encodeAttribute($this->processLink($url));

        $result = "<a href=\"$url\"";
        if (isset($title)) {
            $title = $this->encodeAttribute($title);
            $result .=  " title=\"$title\"";
        }
        $result .= $attr;

        $link_text = $this->runSpanGamut($link_text);
        $result .= ">$link_text</a>";

        return $this->hashPart($result);
    }

    protected function setup()
    {
        parent::setup();
        foreach ($this->urls as $k => $url) {
            $this->urls[$k] = $this->processLink($url);
        }
    }

    /**
     * @param  string $url
     * @return string
     */
    protected function processResource($url)
    {
        $url = Url::cast($url);
        if ($url->getHost()->is()) {
            return $url;
        } else {
            $baseUrl = new Url($this->getWebRoot().'/resources'.$this->context->getPathInfo().'/');

            return new Url($baseUrl, $url);
        }
    }

    /**
     * @param  string $url
     * @return string
     */
    protected function processLink($url)
    {
        $url = Url::cast($url);
        if ($url->getHost()->is()) {
            return $url;
        } else {
            $baseUrl = new Url($this->getLinkRoot().$this->context->getPathInfo().'/');

            return new Url($baseUrl, $url);
        }
    }

    /**
     * @return string
     */
    protected function getWebRoot()
    {
        $parts = pathinfo($this->context->getBaseUrl());
        if (isset($parts['extension']) && $parts['extension'] === 'php') {
            return $parts['dirname'];
        } else {
            return $parts['dirname'].'/'.$parts['filename'];
        }
    }

    /**
     * @return string
     */
    protected function getLinkRoot()
    {
        return $this->context->getBaseUrl();
    }
}
