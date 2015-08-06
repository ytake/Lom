<?php

class AllArgsConstructorTest extends \PHPUnit_Framework_TestCase
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
            ->target('AllArgsConstructorAnnotation')
            ->generateCode(true);
        $constructor = "public function __construct(\$message)
    {
        \$this->message = \$message;
    }";
        $this->assertContains($constructor, $code);
    }
}
