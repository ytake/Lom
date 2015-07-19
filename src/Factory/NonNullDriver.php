<?php

namespace Iono\Lom\Factory;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;

/**
 * Class NonNullDriver
 * @package Iono\Lom\Factory
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class NonNullDriver extends AbstractDriver implements FactoryInterface
{

    /**
     * @return array|mixed
     */
    public function generator()
    {
        foreach ($this->parsed as $part) {
            if ($part instanceof Class_) {
                foreach ($part->stmts as $key => $statement) {
                    if ($statement instanceof Property) {
                        // var_dump($statement);
                    }
                }
            }
        }
        return $this->parsed;
    }


}
