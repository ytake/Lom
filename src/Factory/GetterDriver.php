<?php

namespace Iono\Lom\Factory;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Expr\PropertyFetch;

/**
 * Class GetterDriver
 * @package Iono\Lom\Factory
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class GetterDriver extends AbstractDriver implements FactoryInterface
{

    /**
     * @return array|mixed
     */
    public function generator()
    {
        foreach ($this->parsed as $part) {
            if ($part instanceof Class_) {
                if(! $this->detectMethod($part)) {
                    return $this->parsed;
                }
                $part->stmts[] = $this->createGetterMethod([
                    'method' => $this->resolveMethodName(),
                    'property' => $this->property->getName()
                ]);
            }
        }
        return $this->parsed;
    }

    /**
     * @param Class_ $part
     * @return bool
     */
    protected function detectMethod(Class_ $part)
    {
        foreach ($part->getMethods() as $key => $method) {
            if ($method->name === $this->resolveMethodName()) {
                unset($part->getMethods()[$key]);
                return false;
            }
            if(strpos($this->resolveMethodName(), 'get', true) === 0) {
                if ($method->name === strtolower(str_replace('get', '', $this->resolveMethodName()))) {
                    $method->name = $this->resolveMethodName();
                    return false;
                }
            }
            if(!strpos($this->resolveMethodName(), 'get')) {
                if ($method->name === 'get' . ucfirst($this->resolveMethodName())) {
                    $method->name = $this->resolveMethodName();
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @param bool|false $reverse
     * @return string
     */
    protected function resolveMethodName($reverse = false)
    {
        $fluent = (!$reverse) ? $this->annotation->fluent : $reverse;
        if (!$fluent) {
            return "get" . ucfirst($this->property->getName());
        }
        return strtolower($this->property->getName());
    }

    /**
     * @param array $getter
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function createGetterMethod(array $getter)
    {
        $detectAccessLevel = $this->setAccessLevel();
        return $this->builder->method($getter['method'])
            ->setDocComment("")
            ->addStmt(
                new Return_(
                    new PropertyFetch(
                        new Variable('this'), $getter['property']
                    )
                )
            )->$detectAccessLevel()->getNode();
    }
}
