<?php

use Ytake\Lom\Access;
use Ytake\Lom\Meta\AllArgsConstructor;

/**
 * @AllArgsConstructor(access=Access::LEVEL_PUBLIC)
 */
class AllArgsConstructorExistsAnnotation
{
    /** @var string $message */
    protected $message;

}