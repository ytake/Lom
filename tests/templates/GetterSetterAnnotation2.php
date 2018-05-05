<?php

use Ytake\Lom\Meta\Getter;
use Ytake\Lom\Meta\Setter;

class GetterSetterAnnotation2
{
    /**
     * @Getter @Setter
     * @var string $message
     */
    private $message;
    /**
     * @Getter @Setter
     * @var string $testing
     */
    private $testing;

    public function __toString()
    {
        return 'GetterSetterAnnotation(' . $this->getMessage() . ', ' . $this->getTesting() . ')';
    }
}