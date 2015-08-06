<?php

namespace Iono\Lom;

use Doctrine\Common\Annotations\IndexedReader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Class AnnotationRegister
 *
 * @package Iono\Lom
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class AnnotationRegister
{
    /**
     * annotations register
     *
     * @return $this
     */
    public function register()
    {
        $iterator = new \DirectoryIterator(__DIR__ . '/Meta');
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $name = $file->getPathInfo()->getPathname() . '/' . $file->getFilename();
                AnnotationRegistry::registerFile($name);
            }
        }

        return $this;
    }

    /**
     * @return IndexedReader
     */
    public function getReader()
    {
        return new IndexedReader(new AnnotationReader());
    }
}
