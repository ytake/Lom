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

namespace Ytake\Lom\Factory;

use Ytake\Lom\Constants;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;

/**
 * Class AllArgsConstructorDriver
 *
 * @package Ytake\Lom\Factory
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class AllArgsConstructorDriver extends AbstractDriver implements FactoryInterface
{
    /**
     * @return mixed
     */
    public function generator()
    {
        foreach ($this->parsed as $part) {
            // auto generate for constructor
            if ($part instanceof Class_) {
                // remove constructor
                $this->removeConstructor($part);
                $part->stmts[] = $this->createConstructor();
                foreach ($part->stmts as $key => $statement) {
                    if ($statement instanceof ClassMethod) {
                        if ($statement->name !== '__construct') {
                            unset($part->stmts[$key]);
                            $part->stmts[] = $statement;
                        }
                    }
                }
            }
        }

        return $this->parsed;
    }

    /**
     * @return ClassMethod
     */
    protected function createConstructor()
    {
        $properties = [];
        $sets = [];
        foreach ($this->reflector->getProperties() as $property) {
            $properties[] = $this->builder->param($property->getName());
            $sets[] = new Name(
                sprintf(Constants::SETTER_FORMAT, $property->getName(), $property->getName())
            );
        }
        $detectAccessLevel = $this->setAccessLevel();

        return $this->builder->method('__construct')
            ->setDocComment("\n/**
                              *
                              */")
            ->addParams($properties)->$detectAccessLevel()
            ->addStmts($sets)
            ->getNode();
    }

}
