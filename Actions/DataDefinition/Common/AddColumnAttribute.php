<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\Common;

use Exception;

Trait AddColumnAttribute
{
    private abstract function addColumnAttribute(string $attributeName, mixed $attributeValue): void;

    /**
     * @throws Exception
     */
    public function addPrimary(): void
    {
        $this->addColumnAttribute('primary', true);
    }

    /**
     * @throws Exception
     */
    public function addType(string $type): void
    {
        $this->addColumnAttribute('type', $type);
    }

    /**
     * @throws Exception
     */
    public function addNullable(): void
    {
        $this->addColumnAttribute('nullable', true);
    }

    /**
     * @throws Exception
     */
    public function addUnique(): void
    {
        $this->addColumnAttribute('unique', true);
    }

    /**
     * @throws Exception
     */
    public function addAutoIncrement(): void
    {
        $this->addColumnAttribute('auto_increment', true);
    }

    /**
     * @throws Exception
     */
    public function addForeignKey(string $table, string $column): void
    {
        $this->addColumnAttribute('foreign_key', [$table, $column]);
    }
}