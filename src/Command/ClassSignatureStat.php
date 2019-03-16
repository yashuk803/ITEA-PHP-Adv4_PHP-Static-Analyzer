<?php
/**
 * Created by PhpStorm.
 * User: masha
 * Date: 16.03.19
 * Time: 9:43
 */

namespace Greeflas\StaticAnalyzer\Command;
use Greeflas\StaticAnalyzer\Analyzer\ClassSignature;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;



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
