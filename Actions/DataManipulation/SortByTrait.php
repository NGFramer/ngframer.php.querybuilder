<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use Exception;

Trait SortByTrait
{
    /**
     * This function will add a sorting instruction to the actionLog.
     * Can also include multiple instructions in the form of array.
     * No validation is done on the sorting instructions.
     * @param mixed ...$sortInstructions
     * @return SelectView|SelectTable|SortByTrait
     * @throws Exception
     */
    public function sortBy(mixed ...$sortInstructions): self
    {
        // If the sorting instructions have not been passed.
        if (empty($sortInstructions)) {
            throw new Exception('At least one sorting instruction must be provided.');
        }

        // If the sorting instructions are passed as two strings.
        if (count($sortInstructions) == 2 and is_string($sortInstructions[0]) or is_string($sortInstructions[1])) {
            $this->addtoActionLog('sortBy', ['field' => $sortInstructions[0], 'order' => $sortInstructions[1]]);
            return $this;
        }

        // If the sorting instructions are passed as an array.
        foreach ($sortInstructions as $sortInstruction){
            // Sort Instruction is an array.
            if (is_array($sortInstruction)) {
                $this ->addInActionLog('sortBy', ['field' => $sortInstruction['field'] ?? $sortInstruction[0], 'order' => $sortInstruction['order'] ?? $sortInstruction[1]]);
                return $this;
            }
            // Sort Instruction is not array.
            else {
                throw new Exception('Invalid sorting instruction format. Expected 2 arguments.');
            }
        }

        // If anything reaches to this point, throw an exception.
        throw new Exception('Something went wrong, please check the format of sorting instructions and run the function again.');
    }


    private function getSortByIndex(): int
    {
        return count($this->actionLog['sortBy']);
    }
}