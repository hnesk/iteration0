<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 02.01.15
 * Time: 23:05
 */

namespace CmsBundle\Entity;

class Page
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var \DateTimeImmutable
     */
    protected $lastModified;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $content;

    public function __construct($path, \DateTimeImmutable $lastModified, $title, $content)
    {
        $this->path = $path;
        $this->lastModified = $lastModified;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

}