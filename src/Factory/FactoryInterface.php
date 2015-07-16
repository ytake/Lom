<?php

namespace Iono\Lom\Factory;

use ReflectionClass;

/**
 * Interface FactoryInterface
 * @package Iono\Lom\Factory
 */
interface FactoryInterface
{

    /**
     * @param ReflectionClass $reflectionClass
     * @return mixed
     */
    public function parser(ReflectionClass $reflectionClass);

}
