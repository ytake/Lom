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

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Ytake\Lom\Constants;

/**
 * Class DataDriver.
 *
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class DataDriver extends AbstractDriver implements FactoryInterface
{
    // getter generator and setter generator
    use GetterTrait, SetterTrait, ToStringTrait;

    /**
     * {@inheritdoc}
     */
    public function generator(): ?array
    {
        foreach ($this->reflector->getProperties() as $property) {
            $name = $property->getName();
            $this->createGetter($name);
            $this->createSetter($name);
        }
        foreach ($this->parsed as $part) {
            if ($part instanceof Class_) {
                foreach ($this->getGetters() as $getter) {
                    if ($this->reflector->hasMethod($getter['method'])) {
                        continue;
                    }
                    $part->stmts[] = $this->createGetterMethod($getter);
                }
                foreach ($this->getSetters() as $setter) {
                    if ($this->reflector->hasMethod($setter['method'])) {
                        continue;
                    }
                    $part->stmts[] = $this->createSetterMethod($setter);
                }
                if (!$this->reflector->hasMethod('__toString')) {
                    $part->stmts[] = $this->createToString($this->getGetters());
                }
            }
        }

        return $this->parsed;
    }

    /**
     * @param array $setter
     *
     * @return ClassMethod
     */
    protected function createSetterMethod(array $setter): ClassMethod
    {
        return $this->builder->method($setter['method'])
            ->setDocComment('')
            ->addParam($this->builder->param($setter['property']))
            ->addStmt(
                new Class_(
                    sprintf(Constants::SETTER_FORMAT, $setter['property'], $setter['property'])
                )
            )->makePublic()->getNode();
    }
}
