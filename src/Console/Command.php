<?php

namespace Ytake\Lom\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command
 *
 * @package YtakeLom\Console
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
abstract class Command extends \Symfony\Component\Console\Command\Command
{
    /** @var string  command name */
    protected $command;

    /** @var string  command description */
    protected $description;

    /**
     * @return mixed
     */
    abstract protected function arguments();

    /**
     * command interface configure
     * @return void
     */
    public function configure()
    {
        $this->setName($this->command);
        $this->setDescription($this->description);
        $this->arguments();
    }
}
