<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\Common;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

trait DropColumnAttribute
{
    private abstract function updateColumnAttribute(string $attributeName, mixed $attributeValue): void;


    /**
     * @throws SqlServicesException
     */
    public function dropPrimary(): void
    {
        $this->updateColumnAttribute('primary', false);
    }


    /**
     * @throws SqlServicesException
     */
    public function changeType(string $type): void
    {
        $this->updateColumnAttribute('type', $type);
    }


    /**
     * @throws SqlServicesException
     */
    public function changeLength(int $length): void
    {
        $this->updateColumnAttribute('length', $length);
    }


    /**
     * @throws SqlServicesException
     */
    public function dropNullable(): void
    {
        $this->updateColumnAttribute('nullable', false);
    }


    /**
     * @throws SqlServicesException
     */
    public function dropUnique(): void
    {
        $this->updateColumnAttribute('unique', false);
    }


    /**
     * @throws SqlServicesException
     */
    public function dropAutoIncrement(): void
    {
        $this->updateColumnAttribute('auto_increment', false);
    }


    /**
     * @throws SqlServicesException
     */
    public function dropForeignKey(string $table, string $column): void
    {
        $this->updateColumnAttribute('foreign_key', false);
    }
}