<?php

/*
 * This file is part of the "greeflas/php-static-analyzer" package.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Greeflas\StaticAnalyzer\GenerationClassSignature;

/**
 * @author Mariia Tarantsova <yashuk803@gmail.com>
 */
class ClassSignatureStatCommand extends Command
{
    /**
     * @var GenerationClassSignature
     */
    private $signature;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('class-signature-stat')
            ->setDescription('Shows information about signature classes')
            ->addArgument(
                'fullClassName',
                InputArgument::REQUIRED,
                'Namespace and name class'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fullClassName = $input->getArgument('fullClassName');

        $buildOutput = $this->getSignature($fullClassName);

        $output->writeln($buildOutput);
    }

    /**
     * This method builds output information about signature of needed class.
     * If class doesn't exists return Message ReflectionException.
     *
     * @param string $fullClassName
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    private function getSignature(string $fullClassName): string
    {
        try {
            $this->signature = new GenerationClassSignature($fullClassName);

            return $this->buildOutput();
        } catch (\ReflectionException $e) {
            return "Class $fullClassName does not exist";
        }
    }

    private function getClassName(): string
    {
        return $this->signature->getClassName();
    }

    /**
     * Returns type of class (e.g. default, final or abstract).
     *
     * @return string
     */
    private function getTypeClass(): string
    {
        return $this->signature->getTypeClass();
    }

    /**
     * Return count properties analyzed classes.
     *
     * @param string $type this param may be public, private, protected.
     * @param bool $staic when need count properties public static
     * or protected static.
     *
     * @return int
     */
    private function getCountPropClass(string $type, bool $static = false): int
    {
        return $this->signature->getClassProperties($type, $static);
    }

    /**
     *  Return count methods analyzed classes.
     *
     * @param string $type this param may be public, private, protected.
     * @param bool $staic when need count methods public static
     * or private static.
     *
     * @return int
     */
    private function getCountMethodClass(string $type, bool $static = false): int
    {
        return $this->signature->getClassMethods($type, $static);
    }

    /**
     * This method builds output information about signature of needed class.
     *
     * @return string
     */
    private function buildOutput(): string
    {
        $output = '';
        $output .= \sprintf('Class: %s is %s' . \PHP_EOL, $this->getClassName(), $this->getTypeClass());

        $output .= \sprintf('Properties:' . \PHP_EOL);

        $output .= \sprintf(
            "\t" . 'public: %d (%d static)' . \PHP_EOL,
            $this->getCountPropClass($this->signature::TYPE_PUBLIC),
            $this->getCountPropClass($this->signature::TYPE_PUBLIC, true)
        );

        $output .= \sprintf(
            "\t" . 'protected: %d (%d static)' . \PHP_EOL,
            $this->getCountPropClass($this->signature::TYPE_PROTECTED),
            $this->getCountPropClass($this->signature::TYPE_PROTECTED, true)
        );

        $output .= \sprintf("\t" . 'private: %d ' . \PHP_EOL, $this->getCountPropClass($this->signature::TYPE_PRIVATE));

        $output .= \sprintf('Methods:') . \PHP_EOL;

        $output .= \sprintf(
            "\t" . 'public: %d (%d static)' . \PHP_EOL,
            $this->getCountMethodClass($this->signature::TYPE_PUBLIC),
            $this->getCountMethodClass($this->signature::TYPE_PUBLIC, true)
        );

        $output .= \sprintf("\t" . 'protected: %d ' . \PHP_EOL, $this->getCountMethodClass($this->signature::TYPE_PROTECTED));

        $output .= \sprintf(
            "\t" . 'private: %d (%d static)' . \PHP_EOL,
            $this->getCountMethodClass($this->signature::TYPE_PRIVATE),
            $this->getCountMethodClass($this->signature::TYPE_PRIVATE, true)
        );

        return $output;
    }
}
