<?php

namespace Iono\Lom\Meta;

use Iono\Lom\Access;

/**
 * @Annotation
 * @Target("CLASS")
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
final class AllArgsConstructor
{

    /** @var int */
    public $access = Access::LEVEL_PUBLIC; // constructor access level

}
