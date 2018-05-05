<?php

class GeneratorFactoryTest extends \PHPUnit\Framework\TestCase
{
    /** @var \Ytake\Lom\Factory\GeneratorFactory */
    protected $factory;

    protected function setUp()
    {
        $this->factory = new \Ytake\Lom\Factory\GeneratorFactory(
            new \ReflectionClass(TestGenerator::class),
            []
        );
    }

    public function testDetectDriverFactory()
    {
        $this->assertInstanceOf(
            \Ytake\Lom\Factory\DataDriver::class,
            $this->factory->driver(new \Ytake\Lom\Meta\Data)
        );
        $this->assertInstanceOf(
            \Ytake\Lom\Factory\AllArgsConstructorDriver::class,
            $this->factory->driver(new \Ytake\Lom\Meta\AllArgsConstructor)
        );
        $this->assertInstanceOf(
            \Ytake\Lom\Factory\NoArgsConstructorDriver::class,
            $this->factory->driver(new \Ytake\Lom\Meta\NoArgsConstructor)
        );
        $this->assertInstanceOf(
            \Ytake\Lom\Factory\GetterDriver::class,
            $this->factory->driver(new \Ytake\Lom\Meta\Getter)
        );
        $this->assertInstanceOf(
            \Ytake\Lom\Factory\SetterDriver::class,
            $this->factory->driver(new \Ytake\Lom\Meta\Setter)
        );
    }

}

class TestGenerator
{

}