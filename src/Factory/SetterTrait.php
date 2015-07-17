<?php

namespace Iono\Lom\Factory;

/**
 * Class SetterTrait
 * @package Iono\Lom\Factory
 */
trait SetterTrait
{

    /** @var string[]  */
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
