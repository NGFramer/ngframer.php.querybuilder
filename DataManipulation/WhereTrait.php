<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPExceptions\exceptions\SqlBuilderException;

trait WhereTrait
{
    // Function to add to the query log.
    // Will be used as has been defined in the _builder abstract class, accessed from the parent class.
    abstract protected function addToQueryLogDeepArray(mixed ...$arguments): void;

    // Will be used to check if the array is associated array or not, accessed from the parent class.
    abstract protected function isAssocArray(array $array): bool;

    // Will be used to get the query log, accessed from the parent class.
    abstract protected function getQueryLog(): array;

    // Will be used to get the bind index starter, accessed from the parent class.
    abstract protected function getBindIndexStarter(): int;

    // Will be used to sanitize the value, accessed from the parent class.
    abstract protected function sanitizeValue(string $value): string;

    //  Will be used to update the bind parameters, accessed from the builder class.
    abstract protected function areElementsArray(array $elementContainer): bool;


    public function where(mixed ...$arguments): self
    {
        // Initialize an empty array to store WHERE conditions.
        $where = [];

        // Handle the case where the first argument is not an array.
        // Format for passing the arguments is (column, value) condition.
        if (!is_array($arguments[0])) {
            if (count($arguments) > 3 or count($arguments) < 2) {
                throw new SqlBuilderException('InvalidArgumentException, Invalid where condition format. Expected 2 or 3 arguments.', 0, null, 500, ['error_type'=>'dmlWhere_invalid_data']);
            }
            // If the argument is not an array, it is a simple "column, value" condition.
            $where['elements'][] = $this->processWhereOne($arguments[0], $arguments[1], $arguments[2] ?? '=');
        } // Handle the case where the first argument is an array, meaning that other arguments should also be an array.
        else {
            // Proceed with the original logic for handling array-based conditions
            foreach ($arguments as $argument) {
                // If the argument is not an array, throw an exception.
                if (!is_array($argument)) {
                    throw new SqlBuilderException('Invalid where condition: Invalid argument type.', 0, null, 500, ['error_type'=>'dmlWhere_invalid_data']);
                }

                // If the argument is an indexed array, it is a simple "column, value, operator" condition.
                if (!$this->isAssocArray($argument)) {
                    if (count($argument) > 3 or count($argument) < 2) {
                        throw new SqlBuilderException('Invalid where condition format. Expected 2 or 3 arguments.', 0, null, 500, ['error_type'=>'dmlWhere_invalid_data']);
                    }
                    $where['elements'][] = $this->processWhereOne($argument[0], $argument[1], $argument[2] ?? '=');
                } // If the argument is an indexed array, it is a simple "column, value" condition.
                else if (isset($argument['column'])) {
                    if (count($argument) > 1) $where['link'] = $argument['link'] ?? 'and';
                    $where['elements'][] = $this->processWhereOne($argument['column'], $argument['value'], $argument['operator'] ?? '=');
                } else if (isset($argument['elements'])) {
                    $nestedWhere = [];
                    if (count($argument['elements']) > 1) $nestedWhere['link'] = $argument['link'] ?? 'and';
                    $nestedWhere['elements'] = [];

                    foreach ($argument['elements'] as $subArgument) {
                        $nestedWhere['elements'][] = $this->processWhereOne(
                            $subArgument['column'] ?? $subArgument[0],
                            $subArgument['value'] ?? $subArgument[1],
                            $subArgument['operator'] ?? $subArgument[2] ?? '='
                        );
                    }
                    $where['elements'][] = $nestedWhere;
                } // If the argument is an associative array, it is a nested WHERE condition.
                else {
                    throw new SqlBuilderException('Invalid where condition structure.', 0, null, 500, ['error_type'=>'dmlWhere_invalid_data']);
                }
            }
        }

        // Add the WHERE conditions to the query log.
        $this->addToQueryLogDeepArray('where', $where);
        // Return the Query object to allow for method chaining.
        return $this;
    }


    private function whereOne(string $column, string|array $value, string $operator = '=', string $type = null): self
    {
        $where = $this->processWhereOne($column, $value, $operator, $type);
        $this->addToQueryLogDeepArray('where', $where);
        return $this;
    }

    private function processWhereOne(string $column, string|array $value, string $operator = '=', string $type = null): array
    {
        if ($type) {
            $where = ['type' => $type, 'column' => $column, 'value' => $value, 'operator' => $operator];

        } else {
            $where = ['column' => $column, 'value' => $value, 'operator' => $operator];
        }
        return $where;
    }

    public function whereAnd(array ...$arguments): self
    {
        // Form the where array.
        $where = [
            'link' => 'and',
            'elements' => $arguments
        ];
        // Generate array.
        $this->where($where);
        // Return for object chaining.
        return $this;
    }


    public function whereOr(array ...$arguments): self
    {
        // Form the where array.
        $where = [
            'link' => 'or',
            'elements' => $arguments
        ];
        // Generate array.
        $this->where($where);
        // Return for object chaining.
        return $this;
    }

    public function whereNot(string $column, string $value, string $operator = '='): self
    {
        $where = $this->processWhereOne($column, $value, $operator, 'not');
        $this->addToQueryLogDeepArray('where', $where);
        return $this;
    }

    public function whereNull(string $column): self
    {
        $where = $this->processWhereOne($column, null, 'is');
        $this->addToQueryLogDeepArray('where', $where);
        return $this;
    }

    public function whereNotNull(string $column): self
    {
        $where = $this->processWhereOne($column, null, 'is', 'not');
        $this->addToQueryLogDeepArray('where', $where);
        return $this;
    }

    public function whereBetween(string $column, string $value1, string $value2): self
    {
        $where = $this->processWhereOne($column, [$value1, $value2], 'between');
        $this->addToQueryLogDeepArray('where', $where);
        return $this;
    }

    public function whereNotBetween(string $column, string $value1, string $value2): self
    {
        $where = $this->processWhereOne($column, [$value1, $value2], 'between', 'not');
        $this->addToQueryLogDeepArray('where', $where);
        return $this;
    }

    public function whereLike(string $column, string $valuePattern): self
    {
        $where = $this->processWhereOne($column, $valuePattern, 'like');
        $this->addToQueryLogDeepArray('where', $where);
        return $this;
    }

    public function whereNotLike($column, $valuePattern): self
    {
        $where = $this->processWhereOne($column, $valuePattern, 'like', 'not');
        $this->addToQueryLogDeepArray('where', $where);
        return $this;
    }


    // The main builder function for the WHERE clause.
    protected function buildQuery(): string
    {
        // We'll use the $queryLog variable to process the WHERE conditions.
        $queryLog = $this->getQueryLog();

        // If there are no WHERE conditions, return an empty string.
        if (!isset($queryLog['where'])) {
            return "";
        }

        // Start building the WHERE clause.
        $whereClause = " WHERE ";

        // Structure of Where condition is ['elements' => [ ['column' => 'column', 'value' => 'value', 'operator' => 'operator'], [...], [...] ], 'link' => 'AND' ].
        // TODO: Change the element container to be only on the $queryLog['where']['elements'] array in future updates.
        $elementContainer = $queryLog['where']['elements'] ?? $queryLog['where'];

        // Making conditional statement maker.
        $whereClause .= $this->buildWhereClause($elementContainer);

        // Return the clause.
        return $whereClause;
    }

    protected function buildWhereClause(array $elementContainer): string
    {
        // Initialize an array to store the WHERE elements.
        $whereElementClauseContainer = [];

        // Check if all the elements of element container are not an array.
        if (!$this->areElementsArray($elementContainer)) {
            $whereElementClauseContainer[] = $this->buildWhereElementaryClause($elementContainer);
        } // If all the elements passed are array.
        else {
            // Loop through the element container elements.
            foreach ($elementContainer as $element) {
                // If the element is an array with elements key, it is a nested WHERE condition.
                if (isset($element['elements']) and count($element['elements']) !== 0) {
                    $whereElementClauseContainer[] = $this->buildWhereClause($element['elements']);
                } // If the element is an array with elements key but no elements, throw an exception.
                else if (isset($element['elements'])) {
                    throw new SqlBuilderException('InvalidArgumentException, Invalid where condition structure.', 500, ['dmlWhere_invalid_data', 0x37]);
                } // If the element is an array with no element key.
                else {
                    $whereElementClauseContainer[] = $this->buildWhereElementaryClause($element);
                }
            }
        }
        // Combine the elements with the appropriate link (AND/OR)
        $link = $elementContainer['link'] ?? 'AND';
        return "(" . implode(" " . $link . " ", $whereElementClauseContainer) . ")";
    }

    // Helper function to build the WHERE clause for a single element.
    private function buildWhereElementaryClause(array $element): string
    {
        $column = $element['column'] ?? $element[0];
        $value = $element['value'] ?? $element[1];
        $operator = $element['operator'] ?? $element[2] ?? '=';
        // Return based on the type of the execution method.
        // If the default condition, bind the parameters execution method.
        if (!$this->isGoDirect()) {
            $bindIndex = $this->getBindIndexStarter();
            $this->updateBindParameters($column . $bindIndex, $value);
            return "$column $operator :$column$bindIndex";
        } // If the other condition, direct execution method.
        else {
            $value = $this->sanitizeValue($value);
            return "$column $operator '$value'";
        }
    }
}
