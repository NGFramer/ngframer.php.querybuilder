<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

Trait GroupByTrait
{
    /**
     * This function returns the GROUP BY part of the SQL Query.
     * @param string $column
     * @return string
     */
    public function groupBy(string $column): string
    {
        return "GROUP BY `" . $column . "`";
    }
}