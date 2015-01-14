<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 03.01.15
 * Time: 00:07
 */

namespace CmsBundle\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Knp\Bundle\MarkdownBundle\Parser\MarkdownParser;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;

class ContextMarkdownParser extends MarkdownParser implements MarkdownParserInterface
{
    /** @var RequestContext|null */
    protected $context = null;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(array $features = array(), RequestContext $requestContext, RouterInterface $router)
    {
        parent::__construct($features);
        $this->context = $requestContext;
        $this->router = $router;
    }

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

    /**
     * @param  string $url
     * @return string
     */
    protected function processResource($url)
    {
        $urlParts = parse_url($url);
        if (isset($urlParts['host'])) {
            return $url;
        } else {
            return $this->getResourcesRoot().$this->context->getPathInfo().'/'.$urlParts['path'];
        }
    }

    /**
     * @param  string $url
     * @return string
     */
    protected function processLink($url)
    {
        $parameters = $this->router->match('/'.$url);

        return $this->router->generate(
            $parameters['_route'],
            array_diff_key($parameters, ['_route' => true, '_controller' => true])
        );
    }

    /**
     * @return string
     */
    protected function getResourcesRoot()
    {
        $parts = pathinfo($this->context->getBaseUrl());
        if (isset($parts['extension']) && $parts['extension'] === 'php') {
            return $parts['dirname'].'resources';
        } else {
            return $parts['dirname'].'resources';
        }
    }
}
