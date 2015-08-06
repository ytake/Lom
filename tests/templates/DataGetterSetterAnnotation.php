<?php

use Iono\Lom\Access;
use Iono\Lom\Meta\Data;
use Iono\Lom\Meta\Getter;
use Iono\Lom\Meta\Setter;

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
}
