<?php

class DataTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Ytake\Lom\Lom */
    protected $lom;

    protected function setUp()
    {
        $this->lom = new \Ytake\Lom\Lom(
            new \Ytake\Lom\CodeParser(
                new \PhpParser\Parser\Php7(new \PhpParser\Lexer)
            )
        );
        $this->printer = new \Ytake\Lom\Printer(
            new \PhpParser\PrettyPrinter\Standard()
        );
    }

    public function testGenerateCode()
    {
        $code = $this->lom->register(new \Ytake\Lom\AnnotationRegister())
            ->target('DataAnnotation')
            ->parseCode();
        $code = $this->printer->setStatement($code)
            ->display();
        $this->assertContains('getMessage', $code);
        $this->assertContains('getTesting', $code);
        $this->assertContains('setMessage', $code);
        $this->assertContains('setTesting', $code);
        $this->assertContains('__toString()', $code);
    }
}
