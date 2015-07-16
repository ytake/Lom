<?php

namespace Iono\Lom;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\IndexedReader;

/**
 * Class Register
 * @package Iono\Lom\Annotations
 */
class AnnotationRegister
{

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

    public function getReader()
    {
        return new IndexedReader(new AnnotationReader());
    }

}
