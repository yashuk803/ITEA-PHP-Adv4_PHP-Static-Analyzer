<?php

/**
 * This file is part of the "project" package.
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
class GenerationClassSignature
{
    private const TYPE_PUBLIC    = 'public';
    private const TYPE_PRIVATE   = 'private';
    private const TYPE_PROTECTED = 'protected';

    /**
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * GenerationClassSignature constructor.
     *
     * @param string $fullClassName full path where save classes for analyzed
     *
     * @throws \ReflectionException return when classes doesn't exist
     */
    public function __construct(string $fullClassName)
    {
        $this->reflection = new \ReflectionClass($fullClassName);
    }

    /**
     * Return name classes, which analyzed
     *
     * @return string
     */
    public function getNameClass(): string
    {
        return $this->reflection->getShortName();
    }

    /**
     * Return type classes (default, final, abstract)
     *
     * @return string
     */
    public function getTypeClass(): string
    {
        if ($this->reflection->isAbstract()) {
            $type = 'Abstract';
        } elseif ($this->reflection->isFinal()) {
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
        return  $this->getCountParam($this->reflection->getProperties(), $types, $static);
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
        return  $this->getCountParam($this->reflection->getMethods(), $types, $static);
    }

    /**
     * This method return count properties or methods analyzed classes
     *
     * @param array $array this may be array properties or methods analyzed classes
     * @param string $types type properties or methods (public, protected, private)
     * @param bool $static if need get count properties or methods with modification static
     *
     * @return int
     */
    private function getCountParam(array $array, string $types, bool $static = false): int
    {
        $countParam = 0;

        foreach ($array as $element) {
            if ($element->isPublic() && (false !== \stripos($types, self::TYPE_PUBLIC)) && !$static) {
                $countParam++;
            } elseif ($element->isPrivate() && (false !== \stripos($types, self::TYPE_PRIVATE)) && !$static) {
                $countParam++;
            } elseif ($element->isProtected() && (false !== \stripos($types, self::TYPE_PROTECTED)) && !$static) {
                $countParam++;
            } elseif ($element->isStatic() && $element->isPublic() && (false !== \stripos($types, self::TYPE_PUBLIC)) && $static) {
                $countParam++;
            } elseif ($element->isStatic() && $element->isPrivate() && (false !== \stripos($types, self::TYPE_PRIVATE)) && $static) {
                $countParam++;
            } elseif ($element->isStatic() && $element->isProtected() && (false !== \stripos($types, self::TYPE_PROTECTED)) && $static) {
                $countParam++;
            }
        }

        //Ths RECURSION need when need to know count prop or method parent classes
        if ($parentClass = $this->reflection->getParentClass()) {
            $ref = new \ReflectionClass($parentClass->getName());

            $this->getCountParam($ref->getProperties(), $types);
        }

        return $countParam;
    }
}
