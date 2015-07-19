<?php

namespace Iono\Lom;

use ReflectionClass;
use Doctrine\Common\Annotations\Reader;
use Iono\Lom\Exception\InconsistencyException;

/**
 * Class Lom
 * @package Iono\Lom
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Lom
{

    /** @var  ReflectionClass */
    protected $reflection;

    /** @var Reader */
    protected $register;

    protected $class;

    protected $properties;

    /**
     * @param $className
     * @return $this
     */
    public function target($className)
    {
        $this->reflection = new ReflectionClass($className);
        return $this;
    }

    /**
     * @param AnnotationRegister $register
     * @return $this
     */
    public function register(AnnotationRegister $register)
    {
        $this->register = $register->register()->getReader();
        return $this;
    }

    /**
     * @return $this
     */
    public function parseClassAnnotations()
    {
        $this->class = $this->register->getClassAnnotations($this->reflection);
        return $this;
    }

    /**
     * @return $this
     */
    public function parsePropertyAnnotations()
    {
        foreach($this->reflection->getProperties() as $property) {
            $this->properties[$property->getName()] = $this->register->getPropertyAnnotations($property);
        }
        return $this;
    }

    /**
     * @param $annotations
     */
    protected function detectException($annotations)
    {
        $diff = array_diff_key([
            \Iono\Lom\Meta\NoArgsConstructor::class,
            \Iono\Lom\Meta\AllArgsConstructor::class
        ], $annotations);
        if (count($diff) === 2) {
            throw new InconsistencyException;
        }
    }

    public function getClassAnnotations()
    {
        return $this->class;
    }

    public function getPropertiesAnnotation()
    {
        return $this->properties;
    }
}
