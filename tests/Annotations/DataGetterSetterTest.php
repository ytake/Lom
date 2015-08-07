<?php

class DataGetterSetterTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Ytake\Lom\Lom */
    protected $lom;

    protected function setUp()
    {
        $this->lom = new \Ytake\Lom\Lom(
            new \Ytake\Lom\CodeParser(
                new \PhpParser\Parser(new \PhpParser\Lexer)
            )
        );
        $this->printer = new \Ytake\Lom\Printer(
            new \PhpParser\PrettyPrinter\Standard()
        );
    }

    public function testGenerateCode()
    {
        $code = $this->lom->register(new \Ytake\Lom\AnnotationRegister())
            ->target('DataGetterSetterAnnotation')
            ->parseCode();
        $code = $this->printer->setStatement($code)
            ->display();
        $this->assertContains('private function getMessage', $code);
        $this->assertContains('protected function setMessage($message)', $code);
        $this->assertContains('__toString()', $code);
    }
}
