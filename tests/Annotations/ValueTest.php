<?php

class ValueTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Ytake\Lom\Lom */
    protected $lom;

    protected function setUp()
    {
        $this->lom = new \Ytake\Lom\Lom(
            new \Ytake\Lom\CodeParser(
                new \PhpParser\Parser\Php7(new PhpParser\Lexer(array(
                    'usedAttributes' => array(
                        'comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos'
                    )
                )))
            )
        );
        $this->printer = new \Ytake\Lom\Printer(
            new \PhpParser\PrettyPrinter\Standard()
        );
    }

    public function testGenerateCode()
    {
        $code = $this->lom->register(new \Ytake\Lom\AnnotationRegister())
            ->target('ValueAnnotation')
            ->parseCode();
        $code = $this->printer->setStatement($code)
            ->display();
        $this->assertContains('getMessage', $code);
        $this->assertContains('getTesting', $code);
        $this->assertContains('__toString()', $code);
    }
}
