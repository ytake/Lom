<?php

class InconsistencyConstructorTest extends \PHPUnit\Framework\TestCase
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

    /**
     * @expectedException \Ytake\Lom\Exception\InconsistencyException
     */
    public function testGenerateCode()
    {
        $this->lom->register(new \Ytake\Lom\AnnotationRegister())
            ->target('InconsistencyConstructorAnnotation')
            ->parseCode();
        $code = $this->printer->setStatement($code)
            ->display();
    }
}
