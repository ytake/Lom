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

namespace Iono\Lom;

use ReflectionClass;
use Iono\Lom\Factory\GeneratorFactory;
use Doctrine\Common\Annotations\Reader;
use Iono\Lom\Exception\InconsistencyException;

/**
 * Class Lom
 *
 * @package Iono\Lom
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

    /** @var CodeParser  */
    protected $parser;

    /**
     * @param CodeParser $parser
     */
    public function __construct(CodeParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param $className
     * @return $this
     */
    public function target($className)
    {
        $this->reflection = new ReflectionClass($className);

        return $this;
    }

    /**
     * @param AnnotationRegister $register
     * @return $this
     */
    public function register(AnnotationRegister $register)
    {
        $this->register = $register->register()->getReader();

        return $this;
    }

    /**
     * @param bool|false $printer
     * @return $this|void
     */
    public function generateCode($printer = false, $fileName = null)
    {
        $parsed = $this->parser->parser($this->reflection);
        $this->parseClassAnnotations($parsed);
        $this->parsePropertyAnnotations($parsed);

        $prettyPrinter = new \PhpParser\PrettyPrinter\Standard();
        if (!is_null($this->parsed)) {
            $parsed = $this->parsed;
        }
        if ($printer) {
            return $prettyPrinter->prettyPrintFile($parsed);
        }
        if(is_null($fileName)) {
            $fileName = $this->reflection->getFileName();
        }
        file_put_contents($fileName, $prettyPrinter->prettyPrintFile($parsed));
        return $this;
    }

    /**
     * @param array $parsed
     * @return mixed
     */
    protected function parseClassAnnotations(array $parsed)
    {
        $annotations = $this->register->getClassAnnotations($this->reflection);
        $this->detectException($annotations);
        foreach ($annotations as $annotation) {
            $this->parsed = $this->generator($parsed, $annotation);
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
                $this->parsed = $this->generator($parsed, $propertyAnnotation);
            }
        }
    }

    /**
     * @param $annotations
     */
    protected function detectException($annotations)
    {
        if(array_key_exists(\Iono\Lom\Meta\NoArgsConstructor::class, $annotations)
            && array_key_exists(\Iono\Lom\Meta\AllArgsConstructor::class, $annotations)
        ) {
            throw new InconsistencyException;
        }
        if(array_key_exists(\Iono\Lom\Meta\Data::class, $annotations)
            && array_key_exists(\Iono\Lom\Meta\Value::class, $annotations)
        ) {
            throw new InconsistencyException;
        }
    }


    /**
     * @param array $parsed
     * @param       $annotation
     * @return mixed
     */
    protected function generator(array $parsed, $annotation)
    {
        /** @var \Iono\Lom\Factory\FactoryInterface $factory */
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
