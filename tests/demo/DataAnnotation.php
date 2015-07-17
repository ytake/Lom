<?php

use Iono\Lom\Meta\Data;
use Iono\Lom\Meta\NoArgsConstructor;

/**
 * Class DataAnnotation
 * @Data
 * @NoArgsConstructor
 */
class DataAnnotation
{

    /** @var string $message */
    protected $message;

    /** @var string $testing */
    protected $testing;

    public function __construct($name)
    {

    }

}
