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

use PhpParser\PrettyPrinterAbstract;

/**
 * Class Printer.
 *
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Printer {
    /** @var array */
    protected $parsed;

    /** @var PrettyPrinterAbstract */
    protected $printer;

    /**
     * @param PrettyPrinterAbstract $printer
     */
    public function __construct(PrettyPrinterAbstract $printer) {
        $this->printer = $printer;
    }

    /**
     * @param array $parsed
     *
     * @return $this
     */
    public function setStatement(array $parsed) {
        $this->parsed = $parsed;

        return $this;
    }

    public function display() {
        return $this->printer->prettyPrint($this->parsed);
    }

    /**
     * @param $fileName
     */
    public function putFile($fileName) {
        file_put_contents($fileName, $this->printer->prettyPrintFile($this->parsed));
    }
}
