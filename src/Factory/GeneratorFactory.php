<?php

namespace Iono\Lom\Factory;

use ReflectionClass;
use PhpParser\Parser;
use PhpParser\BuilderFactory;
use PhpParser\Lexer\Emulative;

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
     * @param $name
     * @return FactoryInterface|mixed
     */
    public function driver($name)
    {
        $driverClass = 'create' . ucfirst($name) . 'Driver';
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
     * @return AllArgsConstructorDriver
     */
    protected function createAllArgsConstructorDriver()
    {
        return (new AllArgsConstructorDriver(
            $this->parsed,
            new BuilderFactory
        ))->setReflector($this->reflectionClass);
    }
}
