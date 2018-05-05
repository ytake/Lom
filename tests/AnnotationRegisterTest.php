<?php

class AnnotationRegisterTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Ytake\Lom\AnnotationRegister */
    protected $register;

    protected function setUp()
    {
        $this->register = new \Ytake\Lom\AnnotationRegister();
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
