<?php

use Iono\Lom\Access;
use Iono\Lom\Meta\AllArgsConstructor;

/**
 * Class DataAnnotation
 * @AllArgsConstructor(access=Access::LEVEL_PUBLIC)
 */
class AllArgsConstructorExistsAnnotation
{
    /** @var string $message */
    protected $message;

    public function __construct()
    {

    }
}
