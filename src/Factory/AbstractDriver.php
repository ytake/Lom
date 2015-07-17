<?php

namespace Iono\Lom\Factory;

use ReflectionClass;
use PhpParser\BuilderFactory;

/**
 * Class AbstractDriver
 * @package Iono\Lom\Factory
 */
abstract class AbstractDriver
{

    /** @var ReflectionClass */
    protected $reflector;

    /** @var array */
    protected $parsed;

    /** @var BuilderFactory */
    protected $builder;

    /**
     * @param array         $parsed
     * @param BuilderFactory $builder
     */
    public function __construct(array $parsed, BuilderFactory $builder)
    {
        $this->parsed = $parsed;
        $this->builder = $builder;
    }

    /**
     * set ReflectionClass
     * @param ReflectionClass $reflection
     * @return $this
     */
    public function setReflector(ReflectionClass $reflection)
    {
        $this->reflector = $reflection;
        return $this;
    }

}
