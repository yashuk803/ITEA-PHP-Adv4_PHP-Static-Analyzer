<?php

/**
 * This file is part of the "Library Analyzer" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Greeflas\StaticAnalyzer;

/**
 * Class ctGenerationClassSignature
 *
 * This class help generation information about analyzed classes
 *
 * @author Tarantsova Mariia <yashuk803@gmail.com>
 */
class GenerationClassSignature extends AbstractGenerationClassSignature
{
    /**
     * GenerationClassSignature constructor.
     *
     * @param string $fullClassName full path where save classes for analyzed
     *
     * @throws \ReflectionException return when classes doesn't exist
     */
    public function __construct(string $fullClassName)
    {
        $this->reflecation = new \ReflectionClass($fullClassName);
    }

    /**
     * Return name classes, which analyzed
     *
     * @return string
     */
    public function getNameClass(): string
    {
        return $this->reflecation->getShortName();
    }

    /**
     * Return type classes (default, final, abstract)
     *
     * @return string
     */
    public function getTypeClass(): string
    {
        if ($this->reflecation->isAbstract()) {
            $type = 'Abstract';
        } elseif ($this->reflecation->isFinal()) {
            $type = 'Final';
        } else {
            $type = 'Default';
        }

        return $type;
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
    public function getClassProperties(string $types='private', bool $static = false): int
    {
        return  $this->getCountParam($this->reflecation->getProperties(), $types, $static);
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
    public function getClassMethods(string $types='private', bool $static = false): int
    {
        return  $this->getCountParam($this->reflecation->getMethods(), $types, $static);
    }
}
