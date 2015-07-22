<?php

namespace Iono\Lom\Exception;

/**
 * Class InconsistencyException
 * @package Iono\Lom\Exception
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
final class InconsistencyException extends \LogicException
{

    /** @var string  */
    protected $message = "Inconsistency Annotations";

}
