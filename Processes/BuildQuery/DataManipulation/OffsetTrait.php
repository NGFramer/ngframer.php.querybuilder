<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

Trait OffsetTrait
{
    /**
     * This function will build the specific offset part of the query.
     * @param int $offset
     * @return string
     */
    public function offset(int $offset): string
    {
        return ' OFFSET ' . $offset;
    }
}