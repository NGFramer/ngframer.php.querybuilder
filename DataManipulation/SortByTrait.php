<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPExceptions\exceptions\SqlBuilderException;

Trait SortByTrait
{
    // Abstract function used in the class.
    abstract function addToQueryLogDeepArray(mixed ... $arguments): void;
    abstract function getQueryLog(): array;


    // Main function for the class.
    public function sortBy(mixed ...$sortInstructions): self
    {
        // If the sorting instructions has not been passed.
        if (empty($sortInstructions)) {
            throw new SqlBuilderException('InvalidArgumentException, At least one sorting instruction must be provided.', 500, ['dmlSortBy_invalid_data', 0x26]);
        }

        // If the sorting instructions are passed as two strings.
        if (count($sortInstructions) == 2 and is_string($sortInstructions[0]) or is_string($sortInstructions[1])) {
            $this->addToQueryLogDeepArray('sortBy', ['field' => $sortInstructions[0], 'order' => $sortInstructions[1]]);
            return $this;
        }

        // If the sorting instructions are passed as an array.
        foreach ($sortInstructions as $sortInstruction){
            // Sort Instruction is an array.
            if (is_array($sortInstruction)) {
                $this ->addToQueryLogDeepArray('sortBy', ['field' => $sortInstruction['field'] ?? $sortInstruction[0], 'order' => $sortInstruction['order'] ?? $sortInstruction[1]]);
                return $this;
            }
            // Sort Instruction is not array.
            else {
                throw new SqlBuilderException('InvalidArgumentException, Invalid sorting instruction format. Expected 2 arguments.', 500, ['dmlSortBy_invalid_data', 0x27]);
            }
        }

        // If anything reaches to this point, throw an exception.
        throw new SqlBuilderException('Something went wrong, please check the format of sorting instructions and run the function again.', 500, ['dmlSortBy_invalid_data', 0x28]);
    }


    public function addAsc(string $columnName): self
    {
        $this->sortBy($columnName, 'ASC');
        return $this;
    }


    public function addDesc(string $columnName): self
    {
        $this->sortBy($columnName, 'DESC');
        return $this;
    }


    // Builder function for the trait.
    public function buildQuery(): string
    {
        // Get the query log.
        $queryLog = $this->getQueryLog();
        // Check if the sortBy is empty or filled.
        if (!isset($queryLog['sortBy'])) return '';
        else{
            $sortByString = '';
            $sortBy = $queryLog['sortBy'];
            if (empty($sortBy)) throw new SqlBuilderException('InvalidArgumentException, Empty sortBy asked, modify the query to continue.', 500, ['dmlSortBy_invalid_data', 0x29]);
            else if (is_array($sortBy)) {
                foreach ($sortBy as $sortInstruction) {
                    $sortByString .= $this->getSortByString($sortInstruction);
                }
            }
            else {
                $sortByString = $this->getSortByString($sortBy);
            }
            return ' ORDER BY ' . rtrim($sortByString, ', ');
        }
    }


    private function getSortByString(mixed $sortByInstruction): string
    {
        $field = $sortByInstruction['field'] ?? $sortByInstruction[0];
        $order = $sortByInstruction['order'] ?? $sortByInstruction[1];
        if (!in_array(strtoupper($order), ['ASC', 'DESC'])) {
            throw new SqlBuilderException('Invalid sorting order provided. Please provide either ASC or DESC.', 500, ['dmlSortBy_invalid_data', 0x30]);
        }
        return $field . ' ' . $order . ', ';
    }
}