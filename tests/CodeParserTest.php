<?php

class CodeParserTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Iono\Lom\CodeParser */
    protected $parser;

    protected function setUp()
    {
        $this->parser = new \Iono\Lom\CodeParser(
            new \PhpParser\Parser(
                new \PhpParser\Lexer()
            )
        );
    }

    public function testClassParser()
    {
        $this->assertInternalType(
            'array', $this->parser->parser(new \ReflectionClass(Code::class))
        );
    }

    /**
     * @expectedException \ReflectionException
     */
    public function testNoClassParser()
    {
        $this->parser->parser(new \ReflectionClass('CodeTesting'));
    }
}

final class Code
{
    public function test()
    {

    }
}