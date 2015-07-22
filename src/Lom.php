<?php

namespace Iono\Lom;

use ReflectionClass;
use Iono\Lom\Factory\GeneratorFactory;
use Doctrine\Common\Annotations\Reader;
use Iono\Lom\Exception\InconsistencyException;

/**
 * Class Lom
 * @package Iono\Lom
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Lom
{

    /** @var  ReflectionClass */
    protected $reflection;

    /** @var Reader */
    protected $register;

    /** @var */
    protected $property;

    /** @var */
    protected $parsed;

    /**
     * @param CodeParser $parser
     */
    public function __construct(CodeParser $parser)
    {
        $this->parser = $parser;
    }

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
    public function generateCode()
    {
        $parsed = $this->parser->parser($this->reflection);
        $this->parseClassAnnotations($parsed);
        $this->parsePropertyAnnotations($parsed);

        $prettyPrinter = new \PhpParser\PrettyPrinter\Standard();
        // file_put_contents($reflectionClass->getFileName(), $prettyPrinter->prettyPrintFile($parsed));
        echo ($prettyPrinter->prettyPrintFile($this->parsed));
        return $this;
    }

    /**
     * @param array $parsed
     * @return mixed
     */
    protected function parseClassAnnotations(array $parsed)
    {
        $annotations = $this->register->getClassAnnotations($this->reflection);
        foreach ($annotations as $annotation) {
            $this->parsed = $this->generator($parsed, $annotation);
        }
    }

    /**
     * @param array $parsed
     */
    public function parsePropertyAnnotations(array $parsed)
    {
        foreach ($this->reflection->getProperties() as $property) {
            foreach ($this->register->getPropertyAnnotations($property) as $propertyAnnotation) {
                $this->setProperty($property);
                $this->parsed = $this->generator($parsed, $propertyAnnotation);
            }
        }
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


    /**
     * @param array $parsed
     * @param       $annotation
     * @return mixed
     */
    protected function generator(array $parsed, $annotation)
    {
        /** @var \Iono\Lom\Factory\FactoryInterface $factory */
        $factory = (new GeneratorFactory($this->reflection, $parsed))
            ->driver($annotation);
        if (!is_null($this->property)) {
            $factory->setProperty($this->property);
        }
        return $factory->generator();
    }

    /**
     * @param $property
     */
    protected function setProperty($property)
    {
        $this->property = $property;
    }

    /**
     * @return mixed
     */
    public function getParsed()
    {
        return $this->parsed;
    }

}
