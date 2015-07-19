<?php
namespace Iono\Lom\Meta;

use Iono\Lom\Access;

/**
 * @Annotation
 * @Target("PROPERTY")
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Setter
{

    /** @var int  */
    public $access = Access::LEVEL_PUBLIC; // method access level

    /** @var bool  */
    public $fluent = false;

}
