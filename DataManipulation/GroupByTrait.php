<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

Trait GroupByTrait
{
    // Abstract function used in the class.
    abstract function addToQueryLogDeep(mixed ... $arguments): void;




    // Main function for the trait.
    public function groupBy(string $columnName): void
    {
        $this->addToQueryLogDeep('groupBy', $columnName);
    }
}