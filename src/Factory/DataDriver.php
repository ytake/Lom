<?php

namespace Iono\Lom\Factory;

use PhpParser\BuilderFactory;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Parser;
use ReflectionClass;
use PhpParser\Node\Stmt\Class_;

/**
 * Class DataDriver
 * @package Iono\Lom\Factory
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class DataDriver implements FactoryInterface
{

    use GetterTrait;

    /** @var Parser  */
    protected $parser;

    /** @var BuilderFactory  */
    protected $builder;

    /**
     * @param Parser $parser
     * @param BuilderFactory $builder
     */
    public function __construct(Parser $parser, BuilderFactory $builder)
    {
        $this->parser = $parser;
        $this->builder = $builder;
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return void
     */
    public function parser(ReflectionClass $reflectionClass)
    {
        foreach ($reflectionClass->getProperties() as $property) {
            $name = $property->getName();
            $this->createGetter($name);
            $this->createSetter($name);
        }
        $parsed = $this->parser->parse(file_get_contents($reflectionClass->getFileName()));
        foreach ($parsed as $part) {
            if ($part instanceof Class_) {
                foreach ($this->getGetters() as $getter) {
                    if($reflectionClass->hasMethod($getter['method'])) {
                        return;
                    }
                    $part->stmts[] = $this->createMethod($getter);
                }
            }
        }

        $prettyPrinter = new \PhpParser\PrettyPrinter\Standard();
        file_put_contents($reflectionClass->getFileName(), $prettyPrinter->prettyPrintFile($parsed));
    }

    /**
     * @param array $getter
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function createMethod(array $getter)
    {
        return $this->builder->method($getter['method'])
            ->addStmt(
                new Return_(
                    new PropertyFetch(
                        new Variable('this'), $getter['property']
                    )
                )
            )->makePublic()->getNode();
    }

    /**
     * @param $name
     * @return string
     */
    protected function createSetter($name)
    {
        return "set" . ucfirst($name);
    }


}
