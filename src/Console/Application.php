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

namespace Ytake\Lom\Console;

use PhpParser\Lexer;
use PhpParser\Parser\Php7;
use Ytake\Lom\CodeParser;
use Ytake\Lom\Lom;

/**
 * Class Application.
 *
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Application extends \Symfony\Component\Console\Application
{
    /** @var string */
    protected $name = 'lom';

    /** @var string */
    protected $version = '0.2';

    public function __construct()
    {
        parent::__construct($this->name, $this->version);
    }

    /**
     * @throws \Exception
     */
    public function boot()
    {
        $this->add(
            new GenerateCommand(
                new Lom(
                    new CodeParser(
                        new Php7(new Lexer())
                    )
                )
            )
        );
        $this->run();
    }
}
