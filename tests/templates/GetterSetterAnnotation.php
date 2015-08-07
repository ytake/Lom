<?php

use Ytake\Lom\Access;
use Ytake\Lom\Meta\Data;
/**
 * Class DataAnnotation
 * @Data
 */
class GetterSetterAnnotation
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
        return 'GetterSetterAnnotation(' . $this->getMessage() . ', ' . $this->getTesting() . ')';
    }
}