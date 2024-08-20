<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\Common;

use Exception;

trait DropColumnAttribute
{
    private abstract function updateColumnAttribute(string $attributeName, mixed $attributeValue): void;


    /**
     * @throws Exception
     */
    public function dropPrimary(): void
    {
        $this->updateColumnAttribute('primary', false);
    }


    /**
     * @throws Exception
     */
    public function changeType(string $type): void
    {
        $this->updateColumnAttribute('type', $type);
    }


    /**
     * @throws Exception
     */
    public function changeLength(int $length): void
    {
        $this->updateColumnAttribute('length', $length);
    }


    /**
     * @throws Exception
     */
    public function dropNullable(): void
    {
        $this->updateColumnAttribute('nullable', false);
    }


    /**
     * @throws Exception
     */
    public function dropUnique(): void
    {
        $this->updateColumnAttribute('unique', false);
    }


    /**
     * @throws Exception
     */
    public function dropAutoIncrement(): void
    {
        $this->updateColumnAttribute('auto_increment', false);
    }


    /**
     * @throws Exception
     */
    public function dropForeignKey(string $table, string $column): void
    {
        $this->updateColumnAttribute('foreign_key', false);
    }
}