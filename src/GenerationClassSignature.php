<?php
/**
 * Created by PhpStorm.
 * User: masha
 * Date: 16.03.19
 * Time: 14:41
 */

namespace Greeflas\StaticAnalyzer;

class GenerationClassSignature extends AbstractGenerationClassSignature
{


    public function __construct(string $fullClassName)
    {
        $this->reflecation = new \ReflectionClass($fullClassName);
    }

    public function getNameClass(): string
    {
        return $this->reflecation->getShortName();
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

    public function getClassProperties(string $types='private', bool $static = false): int
    {
      return  $this->getCountParam($this->reflecation->getProperties(), $types, $static);
    }

    public function getClassMethods(string $types='private', bool $static = false): int
    {
        return  $this->getCountParam($this->reflecation->getMethods(), $types, $static);
    }
}
