<?php

namespace Iono\Lom;

use ReflectionClass;
use PhpParser\Parser;

/**
 * Class CodeParser
 * @package Iono\Lom
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class CodeParser
{

    /** @var Parser  */
    protected $parser;

    /**
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return null|\PhpParser\Node[]
     */
    public function parser(ReflectionClass $reflectionClass)
    {
        return $this->parser->parse(
            file_get_contents($reflectionClass->getFileName())
        );
    }

}
