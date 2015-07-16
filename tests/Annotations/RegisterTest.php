<?php

use Iono\Lom\AnnotationRegister;
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
            $annotation->classReflector($reflectionClass);
        }
        $c = function () {
            return (new DataAnnotation())->getMessage();
        };
        ($c());
    }

}

use Iono\Lom\Meta\Data;

/**
 * Class DataAnnotation
 * @Data
 */
class DataAnnotation
{

    /** @var string $message */
    protected $message;

}
