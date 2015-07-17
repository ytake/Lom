<?php

use Iono\Lom\CodeParser;
use Iono\Lom\AnnotationRegister;
use Iono\Lom\Factory\GeneratorFactory;

class RegisterTest extends \PHPUnit_Framework_TestCase
{
    /** @var AnnotationRegister */
    protected $register;
    /** @var CodeParser */
    protected $codeParser;

    protected function setUp()
    {
        $this->register = new AnnotationRegister();
        $this->codeParser = new \Iono\Lom\CodeParser(
            new \PhpParser\Parser(new \PhpParser\Lexer)
        );
    }

    public function testRegister()
    {
        $reader = $this->register->register()->getReader();
        $reflectionClass = new \ReflectionClass('DataAnnotation');
        $parsedArray = $this->codeParser->parser($reflectionClass);
        $annotations = $reader->getClassAnnotations($reflectionClass);
        foreach ($annotations as $annotation) {
            $annotationClass = new ReflectionClass($annotation);

            $parsed = (new GeneratorFactory(
                $reflectionClass, $parsedArray
                )
            )
                ->driver($annotationClass->getShortName())
                ->generator();
            $prettyPrinter = new \PhpParser\PrettyPrinter\Standard();
            file_put_contents($reflectionClass->getFileName(), $prettyPrinter->prettyPrintFile($parsed));
            // var_dump($prettyPrinter->prettyPrintFile($parsed));
        }

    }

}
