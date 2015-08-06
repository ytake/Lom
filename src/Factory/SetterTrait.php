<?php

namespace Iono\Lom\Factory;

/**
 * Class SetterTrait
 *
 * @package Iono\Lom\Factory
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
trait SetterTrait
{

    /** @var string[] */
    protected $setters = [];

    /**
     * @param $name
     * @return void
     */
    protected function createSetter($name)
    {
        $this->setters[] = [
            'method' => "set" . ucfirst($name),
            'property' => $name
        ];
    }

    /**
     * @return \string[]
     */
    protected function getSetters()
    {
        return $this->setters;
    }

}
