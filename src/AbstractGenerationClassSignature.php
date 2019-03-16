<?php
/**
 * Created by PhpStorm.
 * User: masha
 * Date: 16.03.19
 * Time: 18:26
 */

namespace Greeflas\StaticAnalyzer;

class AbstractGenerationClassSignature
{

    private const  PUBLIC    = 'public';
    private const PRIVATE   = 'private';
    private const PROTECTED = 'protected';

    protected $reflecation;

    protected function getCountParam ($array, $types, $static = false)
    {
        $countParam = 0;
        foreach($array as $kay) {

            if($kay->isPublic() && (stripos($types, self::PUBLIC) !== false) && !$static) {

                $countParam++;

            } elseif($kay->isPrivate() && (stripos($types, self::PRIVATE) !== false) && !$static) {

                $countParam++;

            } elseif($kay->isProtected() && (stripos($types, self::PROTECTED) !== false) && !$static) {

                $countParam++;

            } elseif ($kay->isStatic() && $kay->isPublic() && (stripos($types, self::PUBLIC) !== false) && $static) {

                $countParam++;

            } elseif ($kay->isStatic() && $kay->isPrivate() && (stripos($types, self::PRIVATE) !== false) && $static) {

                $countParam++;
            } elseif ($kay->isStatic() && $kay->isProtected() && (stripos($types, self::PROTECTED) !== false) && $static) {

                $countParam++;
            }
        }

        if($parentClass = $this->reflecation->getParentClass()) {

           $this->reflecation->getCountParam($parentClass->getName());//RECURSION
        }

        return $countParam;
    }
}
