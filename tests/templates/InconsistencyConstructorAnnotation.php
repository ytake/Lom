<?php

use Ytake\Lom\Access;
use Ytake\Lom\Meta\AllArgsConstructor;
use Ytake\Lom\Meta\NoArgsConstructor;

/**
 * @AllArgsConstructor(access=Access::LEVEL_PROTECTED)
 * @NoArgsConstructor
 */
class InconsistencyConstructorAnnotation
{
    /** @var string $message */
    protected $message;
}
