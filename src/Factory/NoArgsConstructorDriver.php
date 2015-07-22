<?php

namespace Iono\Lom\Factory;

use PhpParser\Node\Stmt\Class_;

/**
 * Class NoArgsConstructorDriver
 * @package Iono\Lom\Factory
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
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
                $this->removeConstructor($part);
            }
        }
        return $this->parsed;
    }

}
