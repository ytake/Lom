<?php

/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Ytake\Lom;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\IndexedReader;

/**
 * Class AnnotationRegister.
 *
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
class AnnotationRegister {
    /**
     * annotations register.
     *
     * @return $this
     */
    public function register() {
        $iterator = new \DirectoryIterator(__DIR__.'/Meta');
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $name = $file->getPathInfo()->getPathname().'/'.$file->getFilename();
                AnnotationRegistry::registerFile($name);
            }
        }

        return $this;
    }

    /**
     * @throws \Doctrine\Common\Annotations\AnnotationException
     *
     * @return IndexedReader
     */
    public function getReader() {
        return new IndexedReader(new AnnotationReader());
    }
}
