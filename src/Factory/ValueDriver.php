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

/**
 * Class ValueDriver.
 *
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class ValueDriver extends AbstractDriver implements FactoryInterface
{
    // getter generator
    use GetterTrait, ToStringTrait;

    /**
     * {@inheritdoc}
     */
    public function generator(): ?array
    {
        foreach ($this->reflector->getProperties() as $property) {
            $name = $property->getName();
            $this->createGetter($name);
        }
        foreach ($this->parsed as $part) {
            if ($part instanceof Class_) {
                foreach ($this->getGetters() as $getter) {
                    if ($this->reflector->hasMethod($getter['method'])) {
                        continue;
                    }
                    $part->stmts[] = $this->createGetterMethod($getter);
                }
                if (!$this->reflector->hasMethod('__toString')) {
                    $part->stmts[] = $this->createToString($this->getGetters());
                }
            }
        }

        return $this->parsed;
    }
}
