<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use Exception;

trait WhereTrait
{
    /**
     * @throws Exception
     */
    public function where(array $whereConditions): string
    {
        // If there are no WHERE conditions, throw an exception.
        if (empty($whereConditions)) {
            throw new Exception('Empty whereConditions asked, modify the query to continue.');
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
     * @throws Exception . If required, keys are missing in the condition arrays.
     */
    private function buildWhereConditions(array $conditions): string
    {
        // Determine the logical link (AND/OR) for the condition group. Default is 'AND'.
        $link = strtoupper($conditions['link'] ?? 'AND');
        // Get the elements' array, which contains condition blocks or nested groups.
        $elements = $conditions['elements'] ?? throw new Exception('Elements not found in whereConditions.');

        // Initialize an array to hold individual WHERE clauses.
        $clauses = [];

        // Loop through each element to build the clause.
        foreach ($elements as $element) {
            if (isset($element['elements'])) {
                // If the element contains a nested group, recursively build that group's clause.
                $clauses[] = '(' . $this->buildWhereConditions($element) . ')';
            } else {
                // Handle a single condition block.
                $column = $element['column'] ?? throw new Exception('Column not found in whereConditions.');
                $value = $element['value'] ?? throw new Exception('Value not found in whereConditions.');
                $operator = $element['operator'] ?? '=';
                // We shall have bindings in a query statement instead of value.
                $binding = $column.$this->getBindingIndex();
                $this->addBinding($binding, $value);

                /**
                // TODO: To be checked before using this anywhere.
                // If the value is an array, treat it as an IN clause or similar.
                if (is_array($value)) {
                    $value = '(' . implode(',', array_map(fn($val) => "'$val'", $value)) . ')';
                    $operator = strtoupper($operator) === 'IN' ? 'IN' : $operator;
                } else {
                    $value = "'$value'";
                }
                 **/

                // Build the SQL fragment for this condition.
                $clauses[] = "`$column` $operator $binding";
            }
        }

        // Join all clauses using the specified logical link (AND/OR).
        return implode(" $link ", $clauses);
    }
}