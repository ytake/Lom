<?php

/**
 * Class ValueAnnotation
 * @\Iono\Lom\Meta\Value
 */
class ValueAnnotation
{
    /**
     * @var string $message
     */
    protected $message;

    /**
     * @var string $testing
     */
    protected $testing;

    /** @var string $hello */
    protected $hello;

    protected function getHello()
    {
        return $this->hello;
    }

    public function getTesting()
    {
        return $this->testing;
    }
}
