<?php

use Ytake\Lom\Access;
use Ytake\Lom\Meta\Data;
use Ytake\Lom\Meta\Getter;
use Ytake\Lom\Meta\Setter;
/**
 * Class DataGetterSetterAnnotation
 *
 * @Data
 */
class DataGetterSetterAnnotation
{
    /**
     * @var string $message
     * @Getter(access=Access::LEVEL_PRIVATE)
     * @Setter(access=Access::LEVEL_PROTECTED)
     */
    protected $message;
    /**
     * @return string
     */
    public function __toString()
    {
        return '';
    }
    
    private function getMessage($message)
    {
        $this->message = $message;
    }
    
    protected function setMessage($message)
    {
        $this->message = $message;
    }
}