<?php

use Iono\Lom\Access;
use Iono\Lom\Meta\AllArgsConstructor;
use Iono\Lom\Meta\NoArgsConstructor;

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
