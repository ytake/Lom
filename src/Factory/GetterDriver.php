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

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Expr\PropertyFetch;

/**
 * Class GetterDriver
 *
 * @package Iono\Lom\Factory
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class GetterDriver extends AbstractDriver implements FactoryInterface
{
    /** @var bool */
    protected $exists = false;

    /**
     * @return array|mixed
     */
    public function generator()
    {
        foreach ($this->parsed as $part) {
            if ($part instanceof Class_) {
                $methodName = $this->resolveMethodName();
                $this->removeMethod($part, $methodName);
                $part->stmts[] = $this->createGetterMethod([
                    'method' => $methodName,
                    'property' => $this->property->getName()
                ]);
            }
        }

        return $this->parsed;
    }

    /**
     * @return string
     */
    protected function resolveMethodName()
    {
        return "get" . ucfirst($this->property->getName());
    }

    /**
     * @param array $getter
     *
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function createGetterMethod(array $getter)
    {
        $detectAccessLevel = $this->setAccessLevel();

        return $this->builder->method($getter['method'])
            ->setDocComment("")
            ->addStmt(
                new Return_(
                    new PropertyFetch(
                        new Variable('this'), $getter['property']
                    )
                )
            )->$detectAccessLevel()->getNode();
    }
}
