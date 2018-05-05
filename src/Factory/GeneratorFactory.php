<?php

declare(strict_types=1);

/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 *
 * Copyright (c) 2018 Yuuki Takezawa
 */

namespace Ytake\Lom\Factory;

use PhpParser\BuilderFactory;
use ReflectionClass;

/**
 * Class GeneratorFactory.
 *
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class GeneratorFactory
{
    /** @var array */
    protected $parsed;

    /** @var ReflectionClass */
    protected $reflectionClass;

    /** @var */
    protected $annotation;

    /**
     * @param ReflectionClass $reflectionClass
     * @param array           $parsed
     */
    public function __construct(ReflectionClass $reflectionClass, array $parsed)
    {
        $this->reflectionClass = $reflectionClass;
        $this->parsed = $parsed;
    }

    /**
     * @param  $annotation
     *
     * @return AbstractDriver
     */
    public function driver($annotation): AbstractDriver
    {
        $className = explode('\\', get_class($annotation));
        $driverClass = 'create'.ucfirst(end($className)).'Driver';
        $this->annotation = $annotation;

        return $this->$driverClass();
    }

    /**
     * @return DataDriver
     */
    protected function createDataDriver(): DataDriver
    {
        return (new DataDriver(
            $this->parsed,
            new BuilderFactory()
        ))->setReflector($this->reflectionClass);
    }

    /**
     * @return ValueDriver
     */
    protected function createValueDriver(): ValueDriver
    {
        return (new ValueDriver(
            $this->parsed,
            new BuilderFactory()
        ))->setReflector($this->reflectionClass);
    }

    /**
     * for NoArgsConstructor Annotation Driver.
     *
     * @return NoArgsConstructorDriver
     */
    protected function createNoArgsConstructorDriver(): NoArgsConstructorDriver
    {
        return (new NoArgsConstructorDriver(
            $this->parsed,
            new BuilderFactory()
        ))->setReflector($this->reflectionClass);
    }

    /**
     * for AllArgsConstructor Annotation Driver.
     *
     * @return AllArgsConstructorDriver
     */
    protected function createAllArgsConstructorDriver(): AllArgsConstructorDriver
    {
        return (new AllArgsConstructorDriver(
            $this->parsed,
            new BuilderFactory()
        ))->setReflector($this->reflectionClass)
            ->setAnnotationInstance($this->annotation);
    }

    /**
     * for Getter Annotation Driver.
     *
     * @return GetterDriver
     */
    protected function createGetterDriver(): GetterDriver
    {
        return (new GetterDriver(
            $this->parsed,
            new BuilderFactory()
        ))->setReflector($this->reflectionClass)
            ->setAnnotationInstance($this->annotation);
    }

    /**
     * for Setter Annotation Driver.
     *
     * @return SetterDriver
     */
    protected function createSetterDriver(): SetterDriver
    {
        return (new SetterDriver(
            $this->parsed,
            new BuilderFactory()
        ))->setReflector($this->reflectionClass)
            ->setAnnotationInstance($this->annotation);
    }
}
