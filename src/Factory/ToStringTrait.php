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

use PhpParser\Node\Stmt\ClassMethod;

/**
 * Class ToStringTrait.
 *
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
trait ToStringTrait
{
    /**
     * @param \string[] $getters
     *
     * @return ClassMethod
     */
    protected function createToString(array $getters): ClassMethod
    {
        $class = $this->reflector->getName();
        $classMethods = array();
        foreach ($getters as $getter) {
            $classMethods[] = "\$this->{$getter['method']}()";
        }
        $stringBuilder = implode(" . ', ' . ", $classMethods);
        $build = "return '{$class}(' . $stringBuilder . ')';";

        return $this->builder->method('__toString')
            ->setDocComment('')
            ->addStmt(
                new \PhpParser\Node\Stmt\Class_($build)
            )->makePublic()->getNode();
    }
}
