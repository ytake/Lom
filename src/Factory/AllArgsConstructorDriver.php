<?php

namespace Iono\Lom\Factory;

use Iono\Lom\Constants;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;

/**
 * Class AllArgsConstructorDriver
 * @package Iono\Lom\Factory
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class AllArgsConstructorDriver extends AbstractDriver implements FactoryInterface
{

    /**
     * @return mixed
     */
    public function generator()
    {
        foreach ($this->parsed as $part) {
            // remove constructor
            if (!is_null($this->reflector->getConstructor())) {
                foreach ($part->stmts as $key => $statement) {
                    if ($statement instanceof ClassMethod) {
                        if ($statement->name === '__construct') {
                            unset($part->stmts[$key]);
                        }
                    }
                }
            }
            // auto generate for constructor
            if ($part instanceof Class_) {
                $part->stmts[] = $this->createConstructor();
                foreach ($part->stmts as $key => $statement) {
                    if ($statement instanceof ClassMethod) {
                        if ($statement->name !== '__construct') {
                            unset($part->stmts[$key]);
                            $part->stmts[] = $statement;
                        }
                    }
                }
            }
        }
        return $this->parsed;
    }

    /**
     * @return ClassMethod
     */
    protected function createConstructor()
    {
        $properties = [];
        $sets = [];
        foreach ($this->reflector->getProperties() as $property) {
            $properties[] = $this->builder->param($property->getName());
            $sets[] = new Name(
                sprintf(Constants::SETTER_FORMAT, $property->getName(), $property->getName())
            );
        }
        return $this->builder->method('__construct')
            ->setDocComment("")
            ->addParams($properties)->makePublic()
            ->addStmts($sets)
            ->getNode();
    }

}
