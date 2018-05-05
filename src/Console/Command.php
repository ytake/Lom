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

/**
 * Class Command.
 *
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
abstract class Command extends \Symfony\Component\Console\Command\Command
{
    /** @var string command name */
    protected $command;

    /** @var string command description */
    protected $description;

    /**
     * command interface configure.
     */
    public function configure()
    {
        $this->setName($this->command);
        $this->setDescription($this->description);
        $this->arguments();
    }

    abstract protected function arguments();
}
