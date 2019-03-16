<?php
/**
 * Created by PhpStorm.
 * User: masha
 * Date: 16.03.19
 * Time: 14:41
 */

namespace Greeflas\StaticAnalyzer;

class GenerateClassSignature extends AbstractGenerateClassSignature
{

    private $reflecation;

    public function __construct(string $fullClassName)
    {
        $this->reflecation = new \ReflectionClass($fullClassName);
    }

    public function getNameClass(): string
    {
        return $this->reflecation->getName();
    }

    public function getTypeClass(): string
    {
        if($this->reflecation->isAbstract()) {
            $type = 'Abstract';
        } elseif ($this->reflecation->isFinal()) {
            $type = 'Final';
        }else {
            $type = 'Default';
        }
        return $type;
    }

    public function getClassProperties(string $types='private'): int
    {
      return  $this->getCountParam($this->reflecation->getProperties(), $types);
    }

    public function getMethods(string $types='private'): int
    {
        return  $this->getCountParam($this->reflecation->getMethods(), $types);
    }
}
