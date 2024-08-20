<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

Trait SortByTrait
{
    /**
     * This function will add a sorting instruction to the actionLog.
     * Can also include multiple instructions in the form of array.
     * No validation is done on the sorting instructions.
     * @param mixed ...$sortInstructions
     * @return SelectView|SelectTable|SortByTrait
     * @throws SqlServicesException
     */
    public function sortBy(mixed ...$sortInstructions): self
    {
        // If the sorting instructions have not been passed.
        if (empty($sortInstructions)) {
            throw new SqlServicesException('At least one sorting instruction must be provided.', 5002005);
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
                throw new SqlServicesException('Invalid sorting instruction format. Expected 2 arguments.', 5002006);
            }
        }

        // If anything reaches to this point, throw an exception.
        throw new SqlServicesException('Something went wrong, please check the format of sorting instructions and run the function again.', 5002007);
    }


    private function getSortByIndex(): int
    {
        return count($this->actionLog['sortBy']);
    }
}