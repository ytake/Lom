<?php

namespace Ytake\Lom\Console;

use PhpParser\PrettyPrinter\Standard;
use Ytake\Lom\Lom;
use TokenReflection\Broker;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateCommand
 *
 * @package Ytake\Lom\Console
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class GenerateCommand extends Command
{
    /** @var string  command name */
    protected $command = 'generate-code';

    /** @var string  command description */
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

    /**
     * @return mixed
     */
    protected function arguments()
    {
        $this->addArgument('dir', InputArgument::REQUIRED, 'specify your source directory');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->finder($input->getArgument('dir'));
        $output->write("<info>generated</info>");
    }

    protected function finder($directory)
    {
        $finder = new Finder();
        $broker = new Broker(new Broker\Backend\Memory());
        $annotationReader = new \Ytake\Lom\AnnotationRegister();
        $printer = new \Ytake\Lom\Printer(new Standard());
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
