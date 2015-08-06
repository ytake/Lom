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

use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Expr\PropertyFetch;

/**
 * Class GetterTrait
 *
 * @package Iono\Lom\Factory
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
trait GetterTrait
{

    /** @var string[] */
    protected $getters = [];

    /**
     * @param $name
     *
     * @return void
     */
    protected function createGetter($name)
    {
        $this->getters[] = [
            'method' => "get" . ucfirst($name),
            'property' => $name
        ];
    }

    /**
     * @return \string[]
     */
    protected function getGetters()
    {
        return $this->getters;
    }

    /**
     * @param array $getter
     *
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function createGetterMethod(array $getter)
    {
        return $this->builder->method($getter['method'])
            ->setDocComment("")
            ->addStmt(
                new Return_(
                    new PropertyFetch(
                        new Variable('this'), $getter['property']
                    )
                )
            )->makePublic()->getNode();
    }
}
