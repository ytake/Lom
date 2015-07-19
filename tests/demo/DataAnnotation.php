<?php

use Iono\Lom\Meta\Data;
use Iono\Lom\Access;
use Iono\Lom\Meta\Setter;

/**
 * Class DataAnnotation
 * @Data
 */
class DataAnnotation
{

    /**
     * @var string $message
     * @\Iono\Lom\Meta\Getter(fluent=true,access=Access::LEVEL_PROTECTED)
     *@\Iono\Lom\Meta\Setter(fluent=false,access=Access::LEVEL_PROTECTED)
     */
    protected $message;

    /**
     * @var string $testing
     *
     * */
    protected $testing;

}
