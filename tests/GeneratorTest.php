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

    public function testNoCodeGenerator()
    {
        $lom = $this->lom->register(new AnnotationRegister());
        $this->assertNull($lom->getParsed());

        $detect = $lom->target('Testing');
        $this->assertInstanceOf(\Iono\Lom\Lom::class, $detect);
        $generated = $detect->generateCode(true);
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
