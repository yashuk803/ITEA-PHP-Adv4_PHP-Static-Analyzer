<?php

/**
 * This file is part of the "greeflas/php-static-analyzer" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Greeflas\StaticAnalyzer;

/**
 * This analyzer gets information about needed class.
 * Return name and type class, count methods and properties, which class have.
 *
 * @author Tarantsova Mariia <yashuk803@gmail.com>
 */
class GenerationClassSignature
{
    private const TYPE_PUBLIC    = 'public';
    private const TYPE_PRIVATE   = 'private';
    private const TYPE_PROTECTED = 'protected';
    private const TYPE_ABSTRACT  = 'Abstract';
    private const TYPE_FINAL     = 'Final';
    private const TYPE_DEFAULT   = 'Default';

    /**
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * GenerationClassSignature Constructor.
     *
     * @param string $fullClassName
     *
     * @throws \ReflectionException
     */
    public function __construct(string $fullClassName)
    {
        $this->reflection = new \ReflectionClass($fullClassName);
    }

    /**
     * Return name classes, which analyzed.
     *
     * @return string
     */
    public function getClassName(): string
    {
        return $this->reflection->getShortName();
    }

    /**
     * Returns type of class (e.g. default, final or abstract).
     *
     * @return string
     */
    public function getTypeClass(): string
    {
        if ($this->reflection->isAbstract()) {
            $type = self::TYPE_ABSTRACT;
        } elseif ($this->reflection->isFinal()) {
            $type = self::TYPE_FINAL;
        } else {
            $type = self::TYPE_DEFAULT;
        }

        return $type;
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
    public function getClassProperties(string $types = self::TYPE_PRIVATE, bool $static = false): int
    {
        return  $this->getCountParam($this->reflection->getProperties(), $types, $static);
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
    public function getClassMethods(string $types = self::TYPE_PRIVATE, bool $static = false): int
    {
        return  $this->getCountParam($this->reflection->getMethods(), $types, $static);
    }

    /**
     * This method return count properties or methods analyzed classes.
     *
     * @param array $array this may be array properties or methods analyzed classes.
     * @param string $types type properties or methods (public, protected, private).
     * @param bool $static if need get count properties or methods with modification static.
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

        //This RECURSION need to know count prop or method parent classes
        if ($parentClass = $this->reflection->getParentClass()) {
            $ref = new \ReflectionClass($parentClass->getClassName());

            $this->getCountParam($ref->getProperties(), $types);
        }

        return $countParam;
    }
}
