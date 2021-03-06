<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 02.01.15
 * Time: 23:03
 */

namespace CmsBundle\Service;

use CmsBundle\Entity\Page;
use Doctrine\Common\Cache\Cache;
use Gaufrette\File;
use Gaufrette\Filesystem;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RequestContext;

class PageManager
{
    const BOM = "\xEF\xBB\xBF";

    /** @var Filesystem */
    protected $contentFs;

    /** @var Filesystem */
    protected $resourceFs;

    /** @var ContextMarkdownParser  */
    protected $markdown;

    /** @var Page[] */
    protected $pages = [];

    protected $resourceExtensions = [
        'gif' => true,
        'jpg' => true,
        'jpeg' => true,
        'png' => true,
        'pdf' => true,
        'txt' => true,
        'doc' => true,
        'docx' => true,
        'odt' => true,
    ];

    /**
     * @var RequestContext
     */
    private $requestContext;
    /**
     * @var Cache
     */
    private $cache;

    /**
     * @param Filesystem            $contentFs
     * @param Filesystem            $resourceFs
     * @param ContextMarkdownParser $markdown
     * @param RequestContext        $requestContext
     * @param Cache                 $cache
     */
    public function __construct(Filesystem $contentFs, Filesystem $resourceFs, ContextMarkdownParser $markdown, RequestContext $requestContext, Cache $cache)
    {
        $this->contentFs = $contentFs;
        $this->resourceFs = $resourceFs;
        $this->requestContext = $requestContext;
        $this->markdown = $markdown;
        $this->markdown->setRequestContext($this->requestContext);
        $this->cache = $cache;
    }

    public function update()
    {
        #$oldPages = $this->cache->fetch('pages');
        $allKeys = $this->contentFs->listKeys();
        if (isset($allKeys['keys'])) {
            foreach ($allKeys['keys'] as $key) {
                $this->updateFile($this->contentFs->get($key));
            }
        }
        $this->cache->delete('pages');
        $this->cache->save('pages', $this->pages);
    }

    protected function updateFile(File $file)
    {
        $pathParts = pathinfo($file->getKey());
        $filename = $pathParts['basename'];
        $extension = $pathParts['extension'];
        if ($filename == 'index.md') {
            $page = $this->buildPageByFile($file);
            $this->pages[$page->getPath()] = $page;
        } elseif (isset($this->resourceExtensions[strtolower($extension)])) {
            $this->publishResource($file);
        }
    }

    public function publishResource(File $file)
    {
        $oldModeMask = umask(0000);
        $this->resourceFs->write($file->getKey(), $file->getContent(), true);
        umask($oldModeMask);
    }

    public function get($path)
    {
        $path = rtrim($path, '/').'/';

        if (!isset($this->pages[$path])) {
            $filename = $path.'index.md';
            if (!$this->contentFs->has($filename)) {
                throw new NotFoundHttpException('Seite "'.$path.'" nicht gefunden!');
            }
            $file = $this->contentFs->get($filename);
            $this->pages[$path] = $this->buildPageByFile($file);
        }

        return $this->pages[$path];
    }

    protected function buildPageByFile(File $file)
    {
        $path = pathinfo($file->getKey(), PATHINFO_DIRNAME);
        $lastModified = new \DateTimeImmutable('@'.$file->getMtime());
        $content = $file->getContent();
        $data = self::parse($content);
        $data['text'] = $this->markdown->transformMarkdown($data['text']);

        return new Page($path, $lastModified, $data['title'], $data['text']);
    }

    /**
     * @param  string $content
     * @return array
     */
    protected static function parse($content)
    {
        $data = array();
        $content = str_replace(self::BOM, '', $content);
        $fields = preg_split('!\n----\s*\n*!', $content);
        foreach ($fields as $field) {
            $pos = strpos($field, ':');
            $key = str_replace(array('-', ' '), '_', strtolower(trim(substr($field, 0, $pos))));
            if (empty($key)) {
                continue;
            }
            $data[$key] = trim(substr($field, $pos+1));
        }

        return $data;
    }

    /**
     * @return Page
     */
    public function getHome()
    {
        return $this->get('aktuelles');
    }

    /**
     * @param  string       $menuName
     * @return \DOMDocument
     */
    public function getMenu($menuName = 'main')
    {
        $menuFilename = 'menu/'.$menuName.'.md';
        if (!$this->contentFs->has($menuFilename)) {
            throw new NotFoundHttpException('Menu "'.$menuName.'" nicht gefunden!');
        }
        $menuFile = $this->contentFs->get($menuFilename);
        $html = $this->markdown->transformMarkdown($menuFile->getContent());

        $menu = new \DOMDocument();
        $menu->loadXML($html);

        return $menu;
    }
}
