<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

Trait LimitTrait
{
    // Abstract function used in the class.
    abstract function addToQueryLogDeepArray(mixed ... $arguments): void;



    
    // Main function for the class.
    public function limit(int $limit): self
    {
        $this->addToQueryLogDeepArray('limit', $limit);
        return $this;
    }
}