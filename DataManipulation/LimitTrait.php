<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

trait LimitTrait
{
    // Abstract function used in the class.
    abstract function addToQueryLogDeep(mixed ...$arguments): void;

    abstract function getQueryLog(): array;


    // Main function for the class.
    public function limit($limit): self
    {
        $queryLog = $this->getQueryLog();
        $this->addToQueryLogDeep('limit', $limit);
        return $this;
    }


    // Builder function for the class.
    public function buildQuery(): string
    {
        // Get the queryLog initially to process.
        $queryLog = $this->getQueryLog();
        // Check the existence of limit key in the queryLog.
        if (isset($queryLog['limit'])) return ' LIMIT ' . $queryLog['limit'];
        else return '';
    }
}