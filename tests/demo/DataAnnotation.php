<?php

use Iono\Lom\Access;
use Iono\Lom\Meta\Data;
use Iono\Lom\Meta\NoArgsConstructor;
use Iono\Lom\Meta\AllArgsConstructor;

/**
 * Class DataAnnotation
 * @Data
 * @AllArgsConstructor(access=ACCESS::LEVEL_PROTECTED)
 */
class DataAnnotation
{

    /** @var string $message */
    protected $message;

    /** @var string $testing */
    protected $testing;

}
