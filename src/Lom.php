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

namespace Ytake\Lom;

use ReflectionClass;
use Ytake\Lom\Exception\Throwable;
use Ytake\Lom\Factory\GeneratorFactory;
use Doctrine\Common\Annotations\Reader;
use Ytake\Lom\Exception\ThrowInconsistency;

/**
 * Class Lom
 *
 * @package Ytake\Lom
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Lom
{
    /** @var  ReflectionClass */
    protected $reflection;

    /** @var Reader */
    protected $register;

    /** @var */
    protected $property;

    /** @var */
    protected $parsed;

    /** @var */
    protected $method;

    /** @var CodeParser */
    protected $parser;

    /**
     * @param CodeParser     $parser
     * @param Throwable|null $throw
     */
    public function __construct(CodeParser $parser, Throwable $throw = null)
    {
        $this->parser = $parser;
        $this->throw = (is_null($throw)) ? new ThrowInconsistency : $throw;
    }

    /**
     * @param $className
     *
     * @return $this
     */
    public function target($className)
    {
        $this->reflection = new ReflectionClass($className);

        return $this;
    }

    /**
     * @param AnnotationRegister $register
     *
     * @return $this
     */
    public function register(AnnotationRegister $register)
    {
        $this->register = $register->register()->getReader();

        return $this;
    }

    /**
     * @param bool|false $printer
     *
     * @return array
     */
    public function parseCode()
    {
        $parsed = $this->parser->parser($this->reflection);
        $this->parseClassAnnotations($parsed);
        $this->parsePropertyAnnotations($parsed);

        if (!is_null($this->parsed)) {
            $parsed = $this->parsed;
        }
        return $parsed;
    }

    /**
     * @param array $parsed
     *
     * @return mixed
     */
    protected function parseClassAnnotations(array $parsed)
    {
        $annotations = $this->register->getClassAnnotations($this->reflection);
        $this->throw->detectAnnotationErrorThrow($annotations);
        foreach ($annotations as $annotation) {
            $this->parsed = $this->callFactory($parsed, $annotation);
        }
    }

    /**
     * @param array $parsed
     */
    protected function parsePropertyAnnotations(array $parsed)
    {
        foreach ($this->reflection->getProperties() as $property) {
            foreach ($this->register->getPropertyAnnotations($property) as $propertyAnnotation) {
                $this->setProperty($property);
                $this->parsed = $this->callFactory($parsed, $propertyAnnotation);
            }
        }
    }

    /**
     * @param array $parsed
     * @param       $annotation
     *
     * @return mixed
     */
    protected function callFactory(array $parsed, $annotation)
    {
        /** @var \Ytake\Lom\Factory\FactoryInterface $factory */
        $factory = (new GeneratorFactory($this->reflection, $parsed))
            ->driver($annotation);
        if (!is_null($this->property)) {
            $factory->setProperty($this->property);
        }

        return $factory->generator();
    }

    /**
     * @param $property
     */
    protected function setProperty($property)
    {
        $this->property = $property;
    }

    /**
     * @return mixed
     */
    public function getParsed()
    {
        return $this->parsed;
    }
}
