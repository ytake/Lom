<?php

namespace Iono\Lom\Factory;

use PhpParser\Parser;
use PhpParser\Lexer\Emulative;

/**
 * Class GeneratorFactory
 * @package Iono\Lom\Factory
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class GeneratorFactory
{

    /**
     * @param $name
     * @return FactoryInterface
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
        return new DataDriver(new Parser(new Emulative), new \PhpParser\BuilderFactory);
    }
}
