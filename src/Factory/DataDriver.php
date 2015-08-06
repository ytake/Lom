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

use Iono\Lom\Constants;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;

/**
 * Class DataDriver
 *
 * @package Iono\Lom\Factory
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class DataDriver extends AbstractDriver implements FactoryInterface
{
    // getter generator and setter generator
    use GetterTrait, SetterTrait, ToStringTrait;

    /**
     * @return array|mixed
     */
    public function generator()
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
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function createSetterMethod(array $setter)
    {
        return $this->builder->method($setter['method'])
            ->setDocComment("")
            ->addParam($this->builder->param($setter['property']))
            ->addStmt(
                new Name(
                    sprintf(Constants::SETTER_FORMAT, $setter['property'], $setter['property'])
                )
            )->makePublic()->getNode();
    }
}
