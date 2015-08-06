<?php

class GeneratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Iono\Lom\Factory\GeneratorFactory */
    protected $factory;

    protected function setUp()
    {
        $this->factory = new \Iono\Lom\Factory\GeneratorFactory(
            new \ReflectionClass(TestGenerator::class),
            []
        );
    }

    public function testDetectDriverFactory()
    {
        $this->assertInstanceOf(
            \Iono\Lom\Factory\DataDriver::class,
            $this->factory->driver(new \Iono\Lom\Meta\Data)
        );
        $this->assertInstanceOf(
            \Iono\Lom\Factory\AllArgsConstructorDriver::class,
            $this->factory->driver(new \Iono\Lom\Meta\AllArgsConstructor)
        );
        $this->assertInstanceOf(
            \Iono\Lom\Factory\NoArgsConstructorDriver::class,
            $this->factory->driver(new \Iono\Lom\Meta\NoArgsConstructor)
        );
        $this->assertInstanceOf(
            \Iono\Lom\Factory\GetterDriver::class,
            $this->factory->driver(new \Iono\Lom\Meta\Getter)
        );
        $this->assertInstanceOf(
            \Iono\Lom\Factory\SetterDriver::class,
            $this->factory->driver(new \Iono\Lom\Meta\Setter)
        );
    }

}

class TestGenerator
{

}