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
 */

namespace Ytake\Lom\Factory;

use PhpParser\BuilderFactory;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Ytake\Lom\Access;

/**
 * Class AbstractDriver.
 *
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
abstract class AbstractDriver
{
    /** @var ReflectionClass */
    protected $reflector;

    /** @var array */
    protected $parsed;

    /** @var BuilderFactory */
    protected $builder;

    /** @var */
    protected $annotation;

    /** @var ReflectionProperty */
    protected $property;

    /** @var ReflectionMethod */
    protected $method;

    /**
     * @param array          $parsed
     * @param BuilderFactory $builder
     */
    public function __construct(array $parsed, BuilderFactory $builder)
    {
        $this->parsed = $parsed;
        $this->builder = $builder;
    }

    /**
     * set ReflectionClass.
     *
     * @param ReflectionClass $reflection
     *
     * @return $this
     */
    public function setReflector(ReflectionClass $reflection)
    {
        $this->reflector = $reflection;

        return $this;
    }

    /**
     * @param $annotation
     *
     * @return $this
     */
    public function setAnnotationInstance($annotation)
    {
        $this->annotation = $annotation;

        return $this;
    }

    /**
     * @param ReflectionProperty $name
     *
     * @return $this
     */
    public function setProperty(ReflectionProperty $name)
    {
        $this->property = $name;

        return $this;
    }

    /**
     * @param $part
     */
    protected function removeConstructor($part)
    {
        if (!is_null($this->reflector->getConstructor())) {
            $this->removeMethod($part, '__construct');
        }
    }

    /**
     * @param Class_ $part
     * @param string $name
     */
    protected function removeMethod(Class_ $part, string $name)
    {
        foreach ($part->stmts as $key => $statement) {
            if ($statement instanceof ClassMethod) {
                if ($statement->name === $name) {
                    unset($part->stmts[$key]);
                }
            }
        }
    }

    /**
     * detect constructor access level.
     *
     * @return string
     */
    protected function setAccessLevel(): string
    {
        switch ($this->annotation->access) {
            case Access::LEVEL_PRIVATE:
                return 'makePrivate';
            case Access::LEVEL_PROTECTED:
                return 'makeProtected';
            default:
                return 'makePublic';
        }
    }
}
