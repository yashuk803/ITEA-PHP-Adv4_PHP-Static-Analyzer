<?php
/**
 * Created by PhpStorm.
 * User: masha
 * Date: 16.03.19
 * Time: 18:26
 */

namespace Greeflas\StaticAnalyzer;

class AbstractGenerateClassSignature
{

    private const  PUBLIC    = 'public';
    private const PRIVATE   = 'private';
    private const PROTECTED = 'protected';

    private $coutnParam = 0;

    protected function getCountParam ($array, $types, $static = false)
    {
        foreach($array as $kay) {

            if($kay->isPublic() && (stripos($types, self::PUBLIC))) {

                $this->coutnParam++;

            } elseif($kay->isPrivate() && (stripos($types, self::PRIVATE))) {

                $this->coutnParam++;

            } elseif($kay->isProtected() && (stripos($types, self::PROTECTED))) {

                $this->coutnParam++;

            } elseif ($kay->isStatic() && $kay->isPublic() && (stripos($types, self::PUBLIC)) && $static) {

                $this->coutnParam++;

            } elseif ($kay->isStatic() && $kay->isPrivate() && (stripos($types, self::PRIVATE)) && $static) {

                $this->coutnParam++;
            } elseif ($kay->isStatic() && $kay->isProtected() && (stripos($types, self::PROTECTED)) && $static) {

                $this->coutnParam++;
            }
        }

        return $this->coutnParam;
    }
}
