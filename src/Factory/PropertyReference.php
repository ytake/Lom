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
 * Class PropertyReference.
 *
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
abstract class PropertyReference extends AbstractDriver implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function generator(): ?array
    {
        foreach ($this->parsed as $part) {
            if ($part instanceof Class_) {
                $methodName = $this->resolveMethodName();
                $this->removeMethod($part, $methodName);
                $part->stmts[] = $this->createPropertyMethod(array(
                    'method' => $methodName,
                    'property' => $this->property->getName(),
                ));
            }
        }

        return $this->parsed;
    }

    /**
     * @return string
     */
    abstract protected function resolveMethodName(): string;

    /**
     * @param array $setter
     *
     * @return ClassMethod
     */
    protected function createPropertyMethod(array $setter): ClassMethod
    {
        $detectAccessLevel = $this->setAccessLevel();

        return $this->builder->method($setter['method'])
            ->setDocComment('')
            ->addParam($this->builder->param($setter['property']))
            ->addStmt(
                new \PhpParser\Node\Stmt\Class_(
                    sprintf(Constants::SETTER_FORMAT, $setter['property'], $setter['property'])
                )
            )->$detectAccessLevel()->getNode();
    }
}
