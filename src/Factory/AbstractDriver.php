<?php
/**
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Iono\Lom\Factory;

use Iono\Lom\Access;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use PhpParser\BuilderFactory;
use PhpParser\Node\Stmt\ClassMethod;

/**
 * Class AbstractDriver
 *
 * @package Iono\Lom\Factory
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
     * set ReflectionClass
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
     * @param $part
     *
     * @return void
     */
    protected function removeConstructor($part)
    {
        if (!is_null($this->reflector->getConstructor())) {
            $this->removeMethod($part, '__construct');
        }
    }

    /**
     * @param $part
     * @param $name
     */
    protected function removeMethod($part, $name)
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
     * @param \ReflectionMethod $name
     *
     * @return $this
     */
    public function setMethod(ReflectionMethod $name)
    {
        $this->method = $name;

        return $this;
    }

    /**
     * detect constructor access level
     *
     * @return string
     */
    protected function setAccessLevel()
    {
        switch ($this->annotation->access) {
            case Access::LEVEL_PRIVATE:
                return 'makePrivate';
                break;
            case Access::LEVEL_PROTECTED:
                return 'makeProtected';
                break;
            default:
                return 'makePublic';
                break;
        }
    }
}
