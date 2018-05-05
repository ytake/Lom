<?php /** @noinspection PhpUnhandledExceptionInspection */

class DataGetterSetterTest extends \PHPUnit\Framework\TestCase
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
            ->target('DataGetterSetterAnnotation')
            ->parseCode();
        $code = $this->printer->setStatement($code)
            ->display();
        $this->assertContains('private function getMessage', $code);
        $this->assertContains('protected function setMessage($message)', $code);
        $this->assertContains('__toString()', $code);

        $code = $this->lom->register(new \Ytake\Lom\AnnotationRegister())
            ->target('GetterSetterAnnotation2')
            ->parseCode();
        $code = $this->printer->setStatement($code)
            ->display();
        $this->assertContains('public function getMessage', $code);
        $this->assertContains('public function setMessage($message)', $code);
        $this->assertContains('__toString()', $code);


    }
}
