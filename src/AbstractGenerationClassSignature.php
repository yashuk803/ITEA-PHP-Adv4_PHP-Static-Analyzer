<?php

/**
 * This file is part of the "Library Analyzer" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Greeflas\StaticAnalyzer;

/**
 * Abstract Class AbstractGenerationClassSignature
 *
 * This class help get count properties or count method analyzed classes
 *
 * @property \ReflectionClass $reflecation need for save link in object and help use
 * this property for get parent analyzed class if it exist.
 *
 * @author Tarantsova Mariia <yashuk803@gmail.com>
 */
class AbstractGenerationClassSignature
{
    private const PUBLIC    = 'public';
    private const PRIVATE   = 'private';
    private const PROTECTED = 'protected';

    /**
     * @var \ReflectionClass
     */
    protected $reflecation;

    /**
     * This method return count properties or methods analyzed classes
     *
     * @param array $array this may be array properties or methods analyzed classes
     * @param string $types type properties or methods (public, protected, private)
     * @param bool $static if need get count properties or methods with modification static
     *
     * @return int
     */
    protected function getCountParam(array $array, string $types, bool $static = false): int
    {
        $countParam = 0;

        foreach ($array as $kay) {
            if ($kay->isPublic() && (false !== \stripos($types, self::PUBLIC)) && !$static) {
                $countParam++;
            } elseif ($kay->isPrivate() && (false !== \stripos($types, self::PRIVATE)) && !$static) {
                $countParam++;
            } elseif ($kay->isProtected() && (false !== \stripos($types, self::PROTECTED)) && !$static) {
                $countParam++;
            } elseif ($kay->isStatic() && $kay->isPublic() && (false !== \stripos($types, self::PUBLIC)) && $static) {
                $countParam++;
            } elseif ($kay->isStatic() && $kay->isPrivate() && (false !== \stripos($types, self::PRIVATE)) && $static) {
                $countParam++;
            } elseif ($kay->isStatic() && $kay->isProtected() && (false !== \stripos($types, self::PROTECTED)) && $static) {
                $countParam++;
            }
        }

        //Ths RECURSION need when classes have parent classes and need to know count prop or method
        if ($parentClass = $this->reflecation->getParentClass()) {
            $this->reflecation->getCountParam($parentClass->getName());
        }

        return $countParam;
    }
}
