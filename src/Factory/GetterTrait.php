<?php

namespace Iono\Lom\Factory;

use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Expr\PropertyFetch;

/**
 * Class GetterTrait
 * @package Iono\Lom\Factory
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
trait GetterTrait
{

    /** @var string[]  */
    protected $getters = [];

    /**
     * @param $name
     * @return void
     */
    protected function createGetter($name)
    {
        $this->getters[] = [
            'method' => "get" . ucfirst($name),
            'property' => $name
        ];
    }

    /**
     * @return \string[]
     */
    protected function getGetters()
    {
        return $this->getters;
    }

    /**
     * @param array $getter
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function createGetterMethod(array $getter)
    {
        return $this->builder->method($getter['method'])
            ->setDocComment("")
            ->addStmt(
                new Return_(
                    new PropertyFetch(
                        new Variable('this'), $getter['property']
                    )
                )
            )->makePublic()->getNode();
    }

}
