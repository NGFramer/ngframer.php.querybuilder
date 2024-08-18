<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation\Supportive;

trait Bindings
{
    /**
     * This function returns the index for the newer binding to be done.
     * @return int
     */
    public function getBindingIndex(): int
    {
        if (isset($this->queryLog['bindings'])) {
            return count($this->queryLog['bindings']);
        } else {
            return 0;
        }
    }

    /**
     * @param string $bindName
     * @param mixed $bindValue
     * @param string $bindType
     */
    public function addBinding(string $bindName, mixed $bindValue, string $bindType = 'string'): void
    {
        $this->queryLog['bindings'][] = [
            'name' => $bindName,
            'value' => $bindValue,
            'type' => $bindType
        ];
    }
}