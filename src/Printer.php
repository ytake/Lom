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
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 *
 * Copyright (c) 2018 Yuuki Takezawa
 */

namespace Ytake\Lom;

use PhpParser\PrettyPrinterAbstract;

/**
 * Class Printer.
 *
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Printer
{
    /** @var array */
    protected $parsed;

    /** @var PrettyPrinterAbstract */
    protected $printer;

    /**
     * @param PrettyPrinterAbstract $printer
     */
    public function __construct(PrettyPrinterAbstract $printer)
    {
        $this->printer = $printer;
    }

    /**
     * @param array $parsed
     *
     * @return Printer
     */
    public function setStatement(array $parsed): Printer
    {
        $this->parsed = $parsed;

        return $this;
    }

    /**
     * @return null|string
     */
    public function display(): ?string
    {
        return $this->printer->prettyPrint($this->parsed);
    }

    /**
     * @param string $fileName
     */
    public function putFile(string $fileName): void
    {
        file_put_contents($fileName, $this->printer->prettyPrintFile($this->parsed));
    }
}
