<?php

namespace Iono\Lom\Factory;

use Iono\Lom\Constants;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Expr\PropertyFetch;

/**
 * Class DataDriver
 * @package Iono\Lom\Factory
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class DataDriver extends AbstractDriver implements FactoryInterface
{

    use GetterTrait, SetterTrait;

    /**
     * @return array|mixed
     */
    public function generator()
    {
        foreach ($this->reflector->getProperties() as $property) {
            $name = $property->getName();
            $this->createGetter($name);
            $this->createSetter($name);
        }
        foreach ($this->parsed as $part) {
            if ($part instanceof Class_) {
                foreach ($this->getGetters() as $getter) {
                    if ($this->reflector->hasMethod($getter['method'])) {
                        continue;
                    }
                    $part->stmts[] = $this->createGetterMethod($getter);
                }
                foreach ($this->getSetters() as $setter) {
                    if ($this->reflector->hasMethod($setter['method'])) {
                        continue;
                    }
                    $part->stmts[] = $this->createSetterMethod($setter);
                }
                $part->stmts[] = $this->createToString($this->getGetters());
            }
        }
        return $this->parsed;
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

    /**
     * @param array $setter
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function createSetterMethod(array $setter)
    {
        return $this->builder->method($setter['method'])
            ->setDocComment("")
            ->addParam($this->builder->param($setter['property']))
            ->addStmt(
                new Name(
                    sprintf(Constants::SETTER_FORMAT, $setter['property'], $setter['property'])
                )
            )->makePublic()->getNode();
    }

    /**
     * @param \string[] $getters
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function createToString(array $getters)
    {
        $class = $this->reflector->getName();
        $classMethods = [];
        foreach ($getters as $getter) {
            $classMethods[] = "\$this->{$getter['method']}()";
        }
        $stringBuilder = implode(" . ', ' . ", $classMethods);
        $build = "return '{$class}(' . $stringBuilder . ')';";
        return $this->builder->method('__toString')
            ->setDocComment("")
            ->addStmt(
                new Name($build)
            )->makePublic()->getNode();
    }

}
