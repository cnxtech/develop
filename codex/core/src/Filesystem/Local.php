<?php

namespace Codex\Filesystem;

use FilesystemIterator;
use League\Flysystem\Adapter\Local as BaseLocal;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * This is the class Local.
 *
 * @author         Robin Radic
 * @copyright      Copyright (c) 2015, Robin Radic. All rights reserved
 */
class Local extends BaseLocal
{
    /**
     * @param string $path
     * @param int    $mode
     *
     * @return RecursiveIteratorIterator
     */
    protected function getRecursiveDirectoryIterator($path, $mode = RecursiveIteratorIterator::SELF_FIRST)
    {
        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS | FilesystemIterator::FOLLOW_SYMLINKS),
            $mode
        );
    }

    /**
     * @param SplFileInfo $file
     *
     * @return array
     */
    protected function mapFileInfo(SplFileInfo $file)
    {
        $normalized = parent::mapFileInfo($file);
        if ('link' === $normalized['type']) {
            $normalized['type'] = 'dir';
        }

        return $normalized;
    }

    protected function normalizeFileInfo(SplFileInfo $file)
    {
        return $this->mapFileInfo($file);
    }
}
