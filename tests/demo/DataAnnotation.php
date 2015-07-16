<?php

use Iono\Lom\Meta\Data;
/**
 * Class DataAnnotation
 * @Data
 */
class DataAnnotation
{
    /** @var string $message */
    protected $message;
    public function getMessage()
    {
        return $this->message;
    }
}