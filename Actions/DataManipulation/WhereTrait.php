<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Utilities\ArrayTools;

Trait WhereTrait
{
    /**
     * @throws SqlServicesException
     */
    public function where(mixed ...$arguments): self
    {
        // Initialize an empty array to store WHERE conditions.
        $where = [];

        // Handle the case where the first argument is not an array.
        // Format for passing the arguments is (column, value) condition.
        if (!is_array($arguments[0])) {
            if (count($arguments) > 3 or count($arguments) < 2) {
                throw new SqlServicesException('InvalidArgumentException, Invalid where condition format. Expected 2 or 3 arguments.', 5002001, 'sqlservices.invalidWhereCondition');
            }
            // If the argument is not an array, it is a simple "column, value" condition.
            $where['elements'][] = $this->processWhereOne($arguments[0], $arguments[1], $arguments[2] ?? '=');
        } // Handle the case where the first argument is an array, meaning that other arguments should also be an array.
        else {
            // Proceed with the original logic for handling array-based conditions
            foreach ($arguments as $argument) {
                // If the argument is not an array, throw an exception.
                if (!is_array($argument)) {
                    throw new SqlServicesException('Invalid where condition: Invalid argument type.', 5002002, 'sqlservices.invalidWhereCondition');
                }

                // If the argument is an indexed array, it is a simple "column, value, operator" condition.
                if (!ArrayTools::isAssociative($argument)) {
                    if (count($argument) > 3 or count($argument) < 2) {
                        throw new SqlServicesException('Invalid where condition format. Expected 2 or 3 arguments.', 5002003, 'sqlservices.invalidWhereCondition');
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
                } // If the argument is an associative array, it is a nexted WHERE condition.
                else {
                    throw new SqlServicesException('Invalid where condition structure.', 5002004, 'sqlservices.invalidWhereCondition');
                }
            }
        }

        // Add the WHERE conditions to the query log.
        $this->addToActionLog('where', $where);
        // Return the Query object to allow for method chaining.
        return $this;
    }


    /**
     * @throws SqlServicesException
     */
    private function whereOne(string $column, string|array $value, string $operator = '=', string $type = null): self
    {
        $where = $this->processWhereOne($column, $value, $operator, $type);
        $this->addToActionLog('where', $where);
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

    /**
     * @throws SqlServicesException
     */
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


    /**
     * @throws SqlServicesException
     */
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

    /**
     * @throws SqlServicesException
     */
    public function whereNot(string $column, string $value, string $operator = '='): self
    {
        $where = $this->processWhereOne($column, $value, $operator, 'not');
        $this->addToActionLog('where', $where);
        return $this;
    }

    /**
     * @throws SqlServicesException
     */
    public function whereNull(string $column): self
    {
        $where = $this->processWhereOne($column, null, 'is');
        $this->addToActionLog('where', $where);
        return $this;
    }

    /**
     * @throws SqlServicesException
     */
    public function whereNotNull(string $column): self
    {
        $where = $this->processWhereOne($column, null, 'is', 'not');
        $this->addToActionLog('where', $where);
        return $this;
    }

    /**
     * @throws SqlServicesException
     */
    public function whereBetween(string $column, string $value1, string $value2): self
    {
        $where = $this->processWhereOne($column, [$value1, $value2], 'between');
        $this->addToActionLog('where', $where);
        return $this;
    }

    /**
     * @throws SqlServicesException
     */
    public function whereNotBetween(string $column, string $value1, string $value2): self
    {
        $where = $this->processWhereOne($column, [$value1, $value2], 'between', 'not');
        $this->addToActionLog('where', $where);
        return $this;
    }

    /**
     * @throws SqlServicesException
     */
    public function whereLike(string $column, string $valuePattern): self
    {
        $where = $this->processWhereOne($column, $valuePattern, 'like');
        $this->addToActionLog('where', $where);
        return $this;
    }

    /**
     * @throws SqlServicesException
     */
    public function whereNotLike($column, $valuePattern): self
    {
        $where = $this->processWhereOne($column, $valuePattern, 'like', 'not');
        $this->addToActionLog('where', $where);
        return $this;
    }
}