<?php

namespace Iono\Lom\Exception;

/**
 * Class InconsistencyException
 * @package Iono\Lom\Exception
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
final class InconsistencyException extends \LogicException
{

    /** @var string  */
    protected $message = "Inconsistency Annotations";

}
