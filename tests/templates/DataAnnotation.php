<?php

use Ytake\Lom\Meta\Data;

/**
 * Class DataAnnotation
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
    
    public function getMessage()
    {
        return $this->message;
    }
    
    public function getTesting()
    {
        return $this->testing;
    }
    
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    public function setTesting($testing)
    {
        $this->testing = $testing;
    }
    
    public function __toString()
    {
        return 'DataAnnotation(' . $this->getMessage() . ', ' . $this->getTesting() . ')';
    }
}