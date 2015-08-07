<?php

use Ytake\Lom\Access;
use Ytake\Lom\Meta\AllArgsConstructor;
use Ytake\Lom\Meta\NoArgsConstructor;

/**
 * Class InconsistencyConstructorAnnotation
 *
 * @AllArgsConstructor(access=Access::LEVEL_PROTECTED)
 * @NoArgsConstructor
 */
class InconsistencyConstructorAnnotation
{
    /** @var string $message */
    protected $message;
}
