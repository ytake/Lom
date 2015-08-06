<?php

class InconsistencyConstructorTest extends \PHPUnit_Framework_TestCase
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

    /**
     * @expectedException \Iono\Lom\Exception\InconsistencyException
     */
    public function testGenerateCode()
    {
        $this->lom->register(new \Iono\Lom\AnnotationRegister())
            ->target('InconsistencyConstructorAnnotation')
            ->generateCode(true);
    }
}
