<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author Robin Radic
 * @license https://codex-project.mit-license.org MIT License
 */

namespace Codex\Documents\Processors\Toc;

class HeaderValue
{
    public $size;
    public $slug;
    public $text;
    /** @var Header|null */
    protected $header;

    /**
     * HeaderValue constructor.
     *
     * @param $size
     * @param $text
     * @param $header
     */
    public function __construct($size, $text, Header $header = null)
    {
        $this->size = $size;
        $this->text = $text;
        $this->header = $header;

        $this->slug = str_slug($text);
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     *
     * @return HeaderValue
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return HeaderValue
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     *
     * @return HeaderValue
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * getHeader method.
     *
     * @return \Codex\Documents\Processors\Toc\Header|null
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param null $header
     *
     * @return HeaderValue
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }
}
