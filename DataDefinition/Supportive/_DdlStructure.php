<?php

namespace NGFramer\NGFramerPHPSQLServices\DataDefinition\Supportive;

use Exception;
use NGFramer\NGFramerPHPSQLServices\exceptions\SqlBuilderException;
use NGFramer\NGFramerPHPSQLServices\_Base;
use NGFramer\NGFramerPHPSQLServices\_Executor;

abstract class _DdlStructure extends _Base
{
    // Use the following properties for this class.
    private array $structure;
    private array $queryBuilt;


    /**
     * @throws SqlBuilderException
     */
    protected function __construct(string $structureType, string $structureValue)
    {
        if (empty($structureType)) {
            throw new SqlBuilderException('Structure type cannot be empty. Please provide a structure type.', 0, null, 500, ['error_type' => 'ddl_structureType_notDefined']);
        }
        if (empty($structureValue)) {
            throw new SqlBuilderException("$structureType name cannot be empty. Please provide a structure value.", 0, null, 500, ['error_type' => 'ddl_structureValue_notDefined']);
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

    public function build(): array
    {
        // Run this only if the query has not been built.
        if (empty($this->queryBuilt)) {
            // Get the build Log and build the action.
            $buildLog = $this->getQueryLog();
            $action = $buildLog['action'];

            // Return the response.
            $resultArray = [
                'success' => true,
                'status_code' => 200,
                'response' => [
                    'action' => $action,
                    'query' => $this->buildQuery()
                ],
            ];

            // Save the result array.
            $this->queryBuilt = $resultArray;
        }
        // Return the result array.
        return $this->queryBuilt;
    }


    /**
     * Uses the _Executor class for the execution.
     * Executes the query that has been made using the direct method execution.
     * @return array|bool|int. Returns nothing but only true.
     * @throws Exception
     */
    public function execute(): array|bool|int
    {
        // Firstly, run the build function.
        $this->build();
        // Now fetch the values.
        $action = $this->queryBuilt['response']['action'];
        $query = $this->queryBuilt['response']['query'];
        // Now pass all the values to the _Executor.
        return _Executor::getInstance()->execute($action, $query);
    }

}
