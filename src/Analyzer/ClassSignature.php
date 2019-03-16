<?php
/**
 * This file is part of the "Library Analyzer" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Greeflas\StaticAnalyzer\Analyzer;

use Greeflas\StaticAnalyzer\GenerationClassSignature;

/**
 * Class ClassSignature
 *
 * This class intended for analyzer classes and
 * print signature classes
 *
 * @property string $signature help save link in object GenerationClassSignature.
 *
 * @author Tarantsova Mariia <yashuk803@gmail.com>
 */
class ClassSignature
{
    /**
     * @var GenerationClassSignature
     */
    private $signature;

    /**
     * This method print information about Signature classes
     *if class doesn't exists return Message ReflectionException
     *
     * @param string $fullClassName
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    public function getSignature(string $fullClassName): string
    {
        try {
            $this->signature = new GenerationClassSignature($fullClassName);

            return $this->printSignatureClass();
        } catch (\ReflectionException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Return name classes, which analyzed
     *
     * @return string
     */
    public function getNameClass(): string
    {
        return $this->signature->getNameClass();
    }

    /**
     * Return type classes (default, final, abstract)
     *
     * @return string
     */
    public function getTypeClass(): string
    {
        return $this->signature->getTypeClass();
    }

    /**
     * Return count properties analyzed classes
     *
     * @param string $type this param may be public, private, protected
     * @param bool $staic when need count properties public static
     * or protected static
     *
     * @return int
     */
    public function getCountPropClass(string $type, bool $staic = false): int
    {
        return $this->signature->getClassProperties($type, $staic);
    }

    /**
     *  Return count methods analyzed classes
     *
     * @param string $type this param may be public, private, protected
     * @param bool $staic when need count methods public static
     * or private static
     *
     * @return int
     */
    public function getCountMethodClass(string $type, bool $staic = false): int
    {
        return $this->signature->getClassMethods($type, $staic);
    }

    /**
     * Print info about signature classes
     *
     * @return string
     */
    private function printSignatureClass(): string
    {
        $output = '';
        $output.= \sprintf('Class: %s is %s' . \PHP_EOL, $this->getNameClass(), $this->getTypeClass());

        $output.= \sprintf('Properties:' . \PHP_EOL);

        $output.= \sprintf(
            "\t" . 'public: %d (%d static)' . \PHP_EOL,
            $this->getCountPropClass('public'),
            $this->getCountPropClass('public', true)
        );

        $output.= \sprintf(
            "\t" . 'protected: %d (%d static)' . \PHP_EOL,
            $this->getCountPropClass('protected'),
            $this->getCountPropClass('protected', true)
        );

        $output.= \sprintf("\t" . 'private: %d ' . \PHP_EOL, $this->getCountPropClass('private'));

        $output.= \sprintf('Methods:') . \PHP_EOL;

        $output.= \sprintf(
            "\t" . 'public: %d (%d static)' . \PHP_EOL,
            $this->getCountMethodClass('public'),
            $this->getCountMethodClass('public', true)
        );

        $output.= \sprintf("\t" . 'protected: %d ' . \PHP_EOL, $this->getCountMethodClass('protected'));

        $output.= \sprintf(
            "\t" . 'private: %d (%d static)' . \PHP_EOL,
            $this->getCountMethodClass('private'),
            $this->getCountMethodClass('private', true)
        );

        return $output;
    }
}
