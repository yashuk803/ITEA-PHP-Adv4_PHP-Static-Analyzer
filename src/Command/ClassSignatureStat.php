<?php
/**
 * This file is part of the "Library Analyzer" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Greeflas\StaticAnalyzer\Command;

use Greeflas\StaticAnalyzer\Analyzer\ClassSignature;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ClassSignatureStat is the console command classes extends Symfony\Component\Console\Command\Command.
 *
 * A console class consists of one or configure and command execute.
 * Users call a console command by analyzed classes signature.
 *
 * How create command:
 *
 * @see https://symfony.com/doc/current/console.html
 *
 * @author Mariia Tarantsova <yashuk803@gmail.com>
 */
class ClassSignatureStat extends Command
{
    protected function configure()
    {
        $this
            ->setName('class-signature-stat')
            ->setDescription('Shows information about signature classes')
            ->addArgument(
                'fullClassName',
                InputArgument::REQUIRED,
                'Namespace and name class'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fullClassName = $input->getArgument('fullClassName');

        $signature = new ClassSignature();
        $print = $signature->getSignature($fullClassName);

        $output->writeln($print);
    }
}
