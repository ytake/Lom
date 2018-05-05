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

use PhpParser\PrettyPrinter\Standard;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use TokenReflection\Broker;
use TokenReflection\Broker\Backend\Memory;
use Ytake\Lom\AnnotationRegister;
use Ytake\Lom\Lom;
use Ytake\Lom\Printer;

/**
 * Class GenerateCommand.
 *
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class GenerateCommand extends Command
{
    /** @var string command name */
    protected $command = 'generate-code';

    /** @var string command description */
    protected $description = 'generate code with a simple set of annotations';

    /** @var Lom */
    protected $lom;

    /**
     * @param Lom $lom
     */
    public function __construct(Lom $lom)
    {
        parent::__construct();
        $this->lom = $lom;
    }

    protected function arguments()
    {
        $this->addArgument('dir', InputArgument::REQUIRED, 'specify your source directory');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->finder($input->getArgument('dir'));
        $output->write('<info>generated</info>');
    }

    /**
     * @param string $directory
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    protected function finder(string $directory)
    {
        $finder = new Finder();
        $broker = new Broker(new Memory());
        $annotationReader = new AnnotationRegister();
        $printer = new Printer(new Standard());
        /** @var \Symfony\Component\Finder\SplFileInfo $file */
        foreach ($finder->files()->in($directory) as $file) {
            /** @var \TokenReflection\ReflectionFileNamespace $namespace */
            foreach ($broker->processFile($file, true)->getNamespaces() as $namespace) {
                /** @var \TokenReflection\ReflectionClass $class */
                foreach ($namespace->getClasses() as $class) {
                    $printer->setStatement(
                        $this->lom->register($annotationReader)
                            ->target($class->getName())
                            ->parseCode()
                    )->putFile($file->getPathname());
                }
            }
        }
    }
}
