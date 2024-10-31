<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Utilities\ArrayTools;

trait WhereTrait
{
    /**
     * @throws SqlServicesException
     */
    public function where(array $condition): self
    {
        // Initialize an empty array to store WHERE conditions.
        $where = [];

        // Check if the array is associative or not.
        if (ArrayTools::isAssociative($condition)) {
            // Check if we can find the 'link' key.
            isset($condition['link']) ? $where['link'] = $condition['link'] : 'and';
            // Check if we can find the 'elements' key.
            if (isset($condition['elements'])) {
                $where['elements'] = $this->formElements($condition['elements']);
            }
        } else {
            isset($condition['link']) ? $where['link'] = $condition['link'] : 'and';
            $where['elements'] = $this->formElements($condition);
        }

        // Add to the action log.
        $this->addToActionLog('where', $where);
        // For object chaining.
        return $this;
    }

    private function formElements(array $condition)
    {
        error_log('Condition: ' . json_encode($condition));
        // Initialize an empty array to store WHERE conditions.
        $elements = [];
        // Check if the array is associative or not.
        if (ArrayTools::isAssociative($condition)) {
            foreach ($condition as $key => $value) {
                $element['column'] = $key;
                $element['value'] = $value;
                $element['operator'] = '=';
                $elements[] = $element;
            }
        } else {
            // Check if all elements are array.
            if (ArrayTools::areAllArray($condition)) {
                foreach ($condition as $element) {
                    $elements[] = $this->formWhereElement($element);
                }
            } else {
                // Check the number of elements.
                if (count($condition) > 3 or count($condition) < 2) {
                    throw new SqlServicesException('Invalid where condition format. Expected 2 or 3 arguments.', 5006005, 'sqlservices.actions.where.invalidArgumentsCount.3');
                }
                // Check if the first element (column) is a string.
                if (is_string($condition[0])) {
                    $element['column'] = $condition[0];
                } else {
                    // TODO: Check and change the exception code, and label.
                    throw new SqlServicesException('Invalid where condition structure.', 5006006, 'sqlservices.actions.where.invalidConditionStructure.2');
                }
                // Check for the second element.
                if (count($condition) == 2) {
                    $element['value'] = $condition[1];
                    $element['operator'] = '=';
                } else {
                    $element['value'] = $condition[2];
                    $element['operator'] = $condition[1];
                }
                $elements[] = $element;
            }
        }
        // Return the elements.
        return $elements;
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