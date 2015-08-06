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
 * Class GetterDriver
 *
 * @package Iono\Lom\Factory
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class SetterDriver extends AbstractDriver implements FactoryInterface
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
                $part->stmts[] = $this->createSetterMethod([
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
        return "set" . ucfirst($this->property->getName());
    }

    /**
     * @param array $setter
     *
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function createSetterMethod(array $setter)
    {
        $detectAccessLevel = $this->setAccessLevel();

        return $this->builder->method($setter['method'])
            ->setDocComment("")
            ->addParam($this->builder->param($setter['property']))
            ->addStmt(
                new Name(
                    sprintf(Constants::SETTER_FORMAT, $setter['property'], $setter['property'])
                )
            )->$detectAccessLevel()->getNode();
    }
}
