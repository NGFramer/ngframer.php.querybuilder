<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

Trait LimitTrait
{
    /**
     * This function builds the limit part of the SQL query.
     * @param int $limit
     * @return string
     */
    public function limit(int $limit): string
    {
        return " LIMIT " . $limit;
    }
}