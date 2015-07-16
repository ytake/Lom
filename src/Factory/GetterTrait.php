<?php

namespace Iono\Lom\Factory;

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

}
