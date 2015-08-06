<?php

class AnnotationRegisterTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Iono\Lom\AnnotationRegister */
    protected $register;

    protected function setUp()
    {
        $this->register = new \Iono\Lom\AnnotationRegister();
    }

    public function testRegister()
    {
        $this->register->register();
        $reader = $this->register->getReader();
        $this->assertInstanceOf(
            \Doctrine\Common\Annotations\Reader::class,
            $reader
        );
    }
}
