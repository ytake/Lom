<?php

class DataGetterSetterTest extends \PHPUnit_Framework_TestCase
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
            ->target('DataGetterSetterAnnotation')
            ->generateCode(true);
        $this->assertContains('private function getMessage', $code);
        $this->assertContains('protected function setMessage($message)', $code);
        $this->assertContains('__toString()', $code);
    }
}
