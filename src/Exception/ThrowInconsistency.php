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

namespace Ytake\Lom\Exception;

/**
 * Class ThrowInconsistency.
 *
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class ThrowInconsistency implements Throwable {
    /**
     * @param array $annotations
     *
     * @throw InconsistencyException
     */
    public function detectAnnotationErrorThrow(array $annotations) {
        if (array_key_exists(\Ytake\Lom\Meta\NoArgsConstructor::class, $annotations)
            && array_key_exists(\Ytake\Lom\Meta\AllArgsConstructor::class, $annotations)
        ) {
            throw new InconsistencyException();
        }
        if (array_key_exists(\Ytake\Lom\Meta\Data::class, $annotations)
            && array_key_exists(\Ytake\Lom\Meta\Value::class, $annotations)
        ) {
            throw new InconsistencyException();
        }
    }
}
