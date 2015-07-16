<?php

use Iono\Lom\AnnotationRegister;
use Iono\Lom\Factory\GeneratorFactory;

class RegisterTest extends \PHPUnit_Framework_TestCase
{
    /** @var AnnotationRegister */
    protected $register;
    protected function setUp()
    {
        $this->register = new AnnotationRegister();
    }

    public function testRegister()
    {
        $reader = $this->register->register()->getReader();
        $reflectionClass = new \ReflectionClass(new DataAnnotation());
        $annotations = $reader->getClassAnnotations($reflectionClass);
        foreach($annotations as $annotation) {
            $annotationClass = new ReflectionClass($annotation);
            (new GeneratorFactory())->driver($annotationClass->getShortName())
                ->parser($reflectionClass);
        }

    }

}
