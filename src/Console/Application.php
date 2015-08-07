<?php

namespace Ytake\Lom\Console;

use Ytake\Lom\Lom;

/**
 * Class Application
 *
 * @package Ytake\Lom
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Application extends \Symfony\Component\Console\Application
{
    /** @var string */
    protected $name = 'lom';

    /** @var float */
    protected $version = 0.1;

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
                new \Ytake\Lom\Lom(
                    new \Ytake\Lom\CodeParser(
                        new \PhpParser\Parser(new \PhpParser\Lexer)
                    )
                )
            )
        );
        $this->run();
    }
}
