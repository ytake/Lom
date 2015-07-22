<?php

use Iono\Lom\CodeParser;
use Iono\Lom\AnnotationRegister;

/**
 * Class GeneratorTest
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var AnnotationRegister */
    protected $register;
    /** @var CodeParser */
    protected $codeParser;
    /** @var \Iono\Lom\Lom */
    protected $lom;

    protected function setUp()
    {
        $this->lom = new \Iono\Lom\Lom(
            new \Iono\Lom\CodeParser(
                new \PhpParser\Parser(new \PhpParser\Lexer)
            )
        );
    }

    public function testRegister()
    {
        $this->lom->register(new AnnotationRegister())
            ->target('DataAnnotation')
            ->generateCode();
    }

}
