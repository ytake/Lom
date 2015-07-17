<?php

namespace Iono\Lom\Factory;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;

/**
 * Class NoArgsConstructorDriver
 * @package Iono\Lom\Factory
 */
class NoArgsConstructorDriver extends AbstractDriver implements FactoryInterface
{

    /**
     * @return mixed
     */
    public function generator()
    {
        foreach ($this->parsed as $part) {
            if ($part instanceof Class_) {
                if(!is_null($this->reflector->getConstructor())) {
                    foreach($part->stmts as $key => $statement) {
                        if ($statement instanceof ClassMethod) {
                            if ($statement->name === '__construct') {
                                unset($part->stmts[$key]);
                            }
                        }
                    }
                }
            }
        }
        return $this->parsed;
    }

}
