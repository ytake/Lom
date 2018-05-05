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

use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;

/**
 * Class GetterTrait.
 *
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
trait GetterTrait
{
    /** @var string[] */
    protected $getters = array();

    /**
     * @param string $name
     */
    protected function createGetter(string $name)
    {
        $this->getters[] = array(
            'method' => 'get'.ucfirst($name),
            'property' => $name,
        );
    }

    /**
     * @return \string[]
     */
    protected function getGetters(): ?array
    {
        return $this->getters;
    }

    /**
     * @param array $getter
     *
     * @return ClassMethod
     */
    protected function createGetterMethod(array $getter): ClassMethod
    {
        return $this->builder->method($getter['method'])
            ->setDocComment('')
            ->addStmt(
                new Return_(
                    new PropertyFetch(
                        new Variable('this'), $getter['property']
                    )
                )
            )->makePublic()->getNode();
    }
}
