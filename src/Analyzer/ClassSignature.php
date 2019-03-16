<?php
/**
 * Created by PhpStorm.
 * User: masha
 * Date: 16.03.19
 * Time: 9:54
 */

namespace Greeflas\StaticAnalyzer\Analyzer;

use Greeflas\StaticAnalyzer\GenerationClassSignature;

class ClassSignature
{
    private $signature;

    public function getSignature(string $fullClassName)
    {
        try {
            $this->signature = new GenerationClassSignature($fullClassName);

            return $this->printSignatureClass();
        } catch (\ReflectionException $e) {

            return $e->getMessage();
        }
    }


    public function getNameClass()
    {
       return $this->signature->getNameClass();
    }

    public function getTypeClass()
    {
        return $this->signature->getTypeClass();
    }

    public function getCountPropClass($type, $staic = false)
    {
        return $this->signature->getClassProperties($type, $staic);
    }
    public function getCountMethodClass($type, $staic = false)
    {
        return $this->signature->getClassMethods($type, $staic);
    }

    private function printSignatureClass()
    {
        $output = '';
        $output.= \sprintf('Class: %s is %s'.\PHP_EOL, $this->getNameClass(), $this->getTypeClass());

        $output.= \sprintf('Properties:'.\PHP_EOL);

        $output.= \sprintf("\t". 'public: %d (%d static)'.\PHP_EOL,
            $this->getCountPropClass('public'),
            $this->getCountPropClass('public', true));

        $output.= \sprintf("\t".'protected: %d (%d static)'.\PHP_EOL,
            $this->getCountPropClass('protected'),
            $this->getCountPropClass('protected', true));

        $output.= \sprintf("\t".'private: %d '.\PHP_EOL, $this->getCountPropClass('private'));

        $output.= \sprintf('Methods:').\PHP_EOL;

        $output.= \sprintf("\t".'public: %d (%d static)'.\PHP_EOL,
            $this->getCountMethodClass('public'),
            $this->getCountMethodClass('public', true));

        $output.= \sprintf("\t".'protected: %d '.\PHP_EOL, $this->getCountMethodClass('protected'));

        $output.= \sprintf("\t".'private: %d (%d static)'.\PHP_EOL,
            $this->getCountMethodClass('private'),
            $this->getCountMethodClass('private', true));

        return $output;

    }

}
