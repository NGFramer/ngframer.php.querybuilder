<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\Common;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

Trait AddColumnAttribute
{
    private abstract function addColumnAttribute(string $attributeName, mixed $attributeValue): void;

    /**
     * @throws SqlServicesException
     */
    public function addPrimary(): void
    {
        $this->addColumnAttribute('primary', true);
    }

    /**
     * @throws SqlServicesException
     */
    public function addType(string $type): void
    {
        $this->addColumnAttribute('type', $type);
    }

    /**
     * @throws SqlServicesException
     */
    public function addNullable(): void
    {
        $this->addColumnAttribute('nullable', true);
    }

    /**
     * @throws SqlServicesException
     */
    public function addUnique(): void
    {
        $this->addColumnAttribute('unique', true);
    }

    /**
     * @throws SqlServicesException
     */
    public function addAutoIncrement(): void
    {
        $this->addColumnAttribute('auto_increment', true);
    }

    /**
     * @throws SqlServicesException
     */
    public function addForeignKey(string $table, string $column): void
    {
        $this->addColumnAttribute('foreign_key', [$table, $column]);
    }
}