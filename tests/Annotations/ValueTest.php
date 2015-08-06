<?php

class ValueTest extends \PHPUnit_Framework_TestCase
{
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

    public function testGenerateCode()
    {
        $code = $this->lom->register(new \Iono\Lom\AnnotationRegister())
            ->target('ValueAnnotation')
            ->generateCode(true);
        $this->assertContains('getMessage', $code);
        $this->assertContains('getTesting', $code);
        $this->assertContains('__toString()', $code);
    }
}
