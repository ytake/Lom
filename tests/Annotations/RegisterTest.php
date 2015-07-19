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
    /** @var \Iono\Lom\Lom  */
    protected $lom;

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

        $annotations = $reader->getClassAnnotations($reflectionClass);
        $parsedArray = $this->codeParser->parser($reflectionClass);
        foreach ($annotations as $annotation) {
            $parsed = (new GeneratorFactory($reflectionClass, $parsedArray))
                ->driver($annotation)
                ->generator();
        }

        foreach($reflectionClass->getProperties() as $property) {
            foreach($reader->getPropertyAnnotations($property) as $propertyAnnotation) {
                $parsed = (new GeneratorFactory($reflectionClass, $parsedArray))
                    ->driver($propertyAnnotation)
                    ->setProperty($property)
                    ->generator();
            }
        }

        // var_dump($properties, $parsedArray);

        $prettyPrinter = new \PhpParser\PrettyPrinter\Standard();
        // file_put_contents($reflectionClass->getFileName(), $prettyPrinter->prettyPrintFile($parsed));
        echo ($prettyPrinter->prettyPrintFile($parsed));
    }

}
