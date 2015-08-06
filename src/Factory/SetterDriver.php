<?php

namespace Iono\Lom\Factory;

use Iono\Lom\Constants;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;

/**
 * Class GetterDriver
 *
 * @package Iono\Lom\Factory
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class SetterDriver extends AbstractDriver implements FactoryInterface
{
    /** @var bool */
    protected $exists = false;

    /**
     * @return array|mixed
     */
    public function generator()
    {
        foreach ($this->parsed as $part) {
            if ($part instanceof Class_) {
                if (!$this->detectMethod($part)) {
                    return $this->parsed;
                }
                $methodName = (!$this->exists) ?
                    $this->resolveMethodName() : 'set' . ucfirst($this->resolveMethodName());
                $this->removeMethod($part, $methodName);
                $part->stmts[] = $this->createSetterMethod([
                    'method' => $methodName,
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
            // exists method name
            if (!$this->exists) {
                if ($method->name === $this->resolveMethodName()) {
                    // exists getter method name
                    if (count($method->getParams()) === 0) {
                        $this->exists = true;

                        return $this->detectMethod($part);
                    }
                }
            }

            if (strpos($this->resolveMethodName(), 'set', true) === 0) {
                if ($method->name === strtolower(str_replace('set', '', $this->resolveMethodName()))) {
                    $method->name = $this->resolveMethodName();

                    return false;
                }
            }
            if (!strpos($this->resolveMethodName(), 'set')) {
                if (!$this->exists) {
                    if ($method->name === 'set' . ucfirst($this->resolveMethodName())) {
                        $part->stmts[$key] = $this->createSetterMethod([
                            'method' => 'set' . ucfirst($this->resolveMethodName()),
                            'property' => $this->property->getName()
                        ]);

                        return false;
                    }
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
            return "set" . ucfirst($this->property->getName());
        }

        return strtolower($this->property->getName());
    }

    /**
     * @param array $setter
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function createSetterMethod(array $setter)
    {
        $detectAccessLevel = $this->setAccessLevel();

        return $this->builder->method($setter['method'])
            ->setDocComment("")
            ->addParam($this->builder->param($setter['property']))
            ->addStmt(
                new Name(
                    sprintf(Constants::SETTER_FORMAT, $setter['property'], $setter['property'])
                )
            )->$detectAccessLevel()->getNode();
    }
}
