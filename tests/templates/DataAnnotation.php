<?php

use Ytake\Lom\Meta\Data;

/**
 * @Data
 */
class DataAnnotation
{
    /**
     * @var string $message
     */
    protected $message;
    /**
     * @var string $testing
     */
    protected $testing;
    
    public function __toString()
    {
        return 'DataAnnotation(' . $this->getMessage() . ', ' . $this->getTesting() . ')';
    }
}