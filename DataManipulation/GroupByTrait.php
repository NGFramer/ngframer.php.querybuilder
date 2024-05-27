<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPException\exception\SqlBuilderException;

trait GroupByTrait
{
    // Abstract function used in the class.
    abstract function addToQueryLogDeep(mixed ...$arguments): void;

    abstract function getQueryLog(): array;


    // Main function for the trait.
    public function groupBy(string $columnName): self
    {
        $this->addToQueryLogDeep('groupBy', $columnName);
        return $this;
    }


    // Builder function for the trait Group By.
    public function build(): string
    {
        // Get the queryLog initially to process.
        $queryLog = $this->getQueryLog();
        // Check if groupBy attribute is set.
        if (!isset($queryLog['groupBy'])) {
            return '';
        } else if (!empty($queryLog['groupBy']) and is_string($queryLog['groupBy'])) {
            $groupBy = $queryLog['groupBy'];
            return " GROUP BY $groupBy";
        } else {
            throw new SqlBuilderException('InvalidValueException, Group By attribute must be a string and not empty.', 500, ['dmlGroupBy_invalid_data', 0x22]);
        }
    }
}