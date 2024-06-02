<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive;

use NGFramer\NGFramerPHPExceptions\exceptions\SqlBuilderException;
use NGFramer\NGFramerPHPSQLBuilder\_Builder;

abstract class _DmlStructure extends _Builder
{
    // Variable defined here.
    private bool $goDirect = false;
    private array $bindParameters = [];
    private array $structure;


    // Constructor function for the class.
    protected function __construct(string $structureType, string $structureValue)
    {
        if (empty($structureType)) {
            throw new SqlBuilderException('Structure type cannot be empty. Please provide a structure type.', 500, ['dml_structureType_notDefined', 0x19]);
        }
        if (empty($structureValue)) {
            throw new \Exception("$structureType name cannot be empty. Please provide a structure value.", 500, ['dml_structureValue_notDefined', 0x20]);
        }
        $this->setStructure($structureType, $structureValue);
    }


    protected function setStructure(string $structureType, string $structureValue): void
    {
        $this->structure['type'] = $structureType;
        $this->structure['value'] = $structureValue;
    }


    protected function getStructureValue(): string
    {
        return $this->structure['value'];
    }


    // Functions used for defining the query execution method.
    protected function goDirect(): mixed
    {
        // Use this function to set the method of executing the query to direct (not using prepare).
        $this->goDirect = true;
        // Returning nothing, only for compatibility, mixed to reuse in the further classes.
        return null;
    }


    // Function to check if execution method is direct.
    protected function isGoDirect(): bool
    {
        return $this->goDirect;
    }


    // Function to update/add to the bind parameters.
    protected function updateBindParameters(string $key, string $value): void
    {
        if (array_key_exists($key, $this->bindParameters)){
            throw new SqlBuilderException("Something unexpected happened. Repeated bindParameters Key.", 500, ['dml_repeatedBindParametersKey', 0x21]);
        }else{
            $this->bindParameters[$key] = $value;
        }
    }


    // Provides number to use further for the another binding, array starts from 0th position.
    protected function getBindIndexStarter(): int
    {
        // Bind parameter will start from 1.
        return !$this->goDirect ? (count($this->bindParameters)+1):0;
    }


    protected function sanitizeValue(string $value): string
    {
        // Escape special characters in the string
        $escapedValue = addslashes($value);
        // Convert special characters to HTML entities
        return htmlspecialchars($escapedValue);
    }


    public function buildBindParameters(): array
    {
        return $this->bindParameters;
    }


    public function build(): array
    {
        // Get the build Log and build the action.
        $buildLog = $this->buildLog();
        $action = $buildLog['action'];
        // Return the response.
        $resultArray = [
            'success' => true,
            'status_code' => 200,
            'response' => [
                'action' => $action,
                'execution_method' => $this->isGoDirect() ? 'direct' : 'prepare',
                'query' => $this->buildQuery()
            ],
        ];
        // Check if the execution method is direct, if so, add bind_parameters.
        if (!$this->isGoDirect()){
            $resultArray['response']['bind_parameters'] = $this->buildBindParameters();
        }
        // Return the result array.
        return $resultArray;
    }
}
