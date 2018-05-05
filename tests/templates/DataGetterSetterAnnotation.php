<?php

use Ytake\Lom\Access;
use Ytake\Lom\Meta\Data;
use Ytake\Lom\Meta\Getter;
use Ytake\Lom\Meta\Setter;
/**
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
}