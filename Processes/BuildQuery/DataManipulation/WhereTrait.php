<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

trait WhereTrait
{
    /**
     * @throws SqlServicesException
     */
    public function where(array $whereConditions): string
    {
        // If there are no WHERE conditions, throw an exception.
        if (empty($whereConditions)) {
            throw new SqlServicesException('Empty whereConditions asked, modify the query to continue.', 5003014);
        }

        // Build the WHERE clause using the provided conditions.
        $whereClause = $this->buildWhereConditions($whereConditions);

        // Return the where clause.
        return " WHERE " . $whereClause;
    }

    /**
     * Recursively builds the WHERE clause for nested conditions.
     *
     * @param array $conditions . Array of conditions and subConditions.
     * @return string . The resulting SQL WHERE clause.
     * @throws SqlServicesException . If required, keys are missing in the condition arrays.
     */
    private function buildWhereConditions(array $conditions): string
    {
        // Determine the logical link (AND/OR) for the condition group. Default is 'AND'.
        $link = strtoupper($conditions['link'] ?? 'AND');
        // Get the elements' array, which contains condition blocks or nested groups.
        $elements = $conditions['elements'] ?? throw new SqlServicesException('Elements not found in whereConditions.', 5001011);

        // Initialize an array to hold individual WHERE clauses.
        $clauses = [];

        // Loop through each element to build the clause.
        foreach ($elements as $element) {
            if (isset($element['elements'])) {
                // If the element contains a nested group, recursively build that group's clause.
                $clauses[] = '(' . $this->buildWhereConditions($element) . ')';
            } else {
                // Handle a single condition block.
                $column = $element['column'] ?? throw new SqlServicesException('Column not found in whereConditions.', 5001012);
                $value = $element['value'] ?? throw new SqlServicesException('Value not found in whereConditions.', 5001013);
                $operator = $element['operator'] ?? '=';
                // We shall have bindings in a query statement instead of value.
                $binding = $column.$this->getBindingIndex();
                $this->addBinding($binding, $value);

                // Build the SQL fragment for this condition.
                $clauses[] = "`$column` $operator $binding";
            }
        }

        // Join all clauses using the specified logical link (AND/OR).
        return implode(" $link ", $clauses);
    }
}