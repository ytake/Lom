<?php

namespace Iono\Lom\Factory;

use ReflectionClass;
use PhpParser\BuilderFactory;

/**
 * Class GeneratorFactory
 * @package Iono\Lom\Factory
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class GeneratorFactory
{

    /** @var array */
    protected $parsed;

    /** @var ReflectionClass  */
    protected $reflectionClass;

    /** @var   */
    protected $annotation;


    /**
     * @param ReflectionClass $reflectionClass
     * @param array           $parsed
     */
    public function __construct(ReflectionClass $reflectionClass, array $parsed)
    {
        $this->reflectionClass = $reflectionClass;
        $this->parsed = $parsed;
    }

    /**
     * @param ReflectionClass $annotation
     * @return \Iono\Lom\Factory\FactoryInterface
     */
    public function driver($annotation)
    {
        $className = explode('\\', get_class($annotation));
        $driverClass = 'create' . ucfirst(end($className)) . 'Driver';
        $this->annotation = $annotation;
        return $this->$driverClass();
    }

    /**
     * @return DataDriver
     */
    protected function createDataDriver()
    {
        return (new DataDriver(
            $this->parsed,
            new BuilderFactory
        ))->setReflector($this->reflectionClass);
    }

    /**
     * @return NoArgsConstructorDriver
     */
    protected function createNoArgsConstructorDriver()
    {
        return (new NoArgsConstructorDriver(
            $this->parsed,
            new BuilderFactory
        ))->setReflector($this->reflectionClass);
    }

    /**
     * for @AllArgsConstructor Annotation Driver
     * @return AllArgsConstructorDriver
     */
    protected function createAllArgsConstructorDriver()
    {
        return (new AllArgsConstructorDriver(
            $this->parsed,
            new BuilderFactory
        ))->setReflector($this->reflectionClass)
            ->setAnnotationInstance($this->annotation);
    }

    /**
     * for @NonNull Annotation Driver
     * @return AllArgsConstructorDriver
     */
    protected function createNonNullDriver()
    {
        return (new NonNullDriver(
            $this->parsed,
            new BuilderFactory
        ))->setReflector($this->reflectionClass);
    }

    /**
     * for @Getter Annotation Driver
     * @return GetterDriver
     */
    protected function createGetterDriver()
    {
        return (new GetterDriver(
            $this->parsed,
            new BuilderFactory
        ))->setReflector($this->reflectionClass)
            ->setAnnotationInstance($this->annotation);
    }
}
