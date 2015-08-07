<?php

use Ytake\Lom\CodeParser;
use Ytake\Lom\AnnotationRegister;

/**
 * Class GeneratorTest
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var AnnotationRegister */
    protected $register;
    /** @var CodeParser */
    protected $codeParser;
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

    public function testNoCodeGenerator()
    {
        $lom = $this->lom->register(new AnnotationRegister());
        $this->assertNull($lom->getParsed());

        $detect = $lom->target('Testing');
        $this->assertInstanceOf(\Ytake\Lom\Lom::class, $detect);
        $generated = $detect->parseCode();
        $generated = $this->printer->setStatement($generated)
            ->display();
        $code = "<?php

class Testing
{
    /** @var string \$message */
    protected \$message;
}
        ";
        $this->assertContains($generated, $code);
    }
}
