<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\Common;

use Exception;

trait DropColumnAttribute
{
    private abstract function changeColumnAttribute(string $attributeName, mixed $attributeValue): void;


    /**
     * @throws Exception
     */
    public function dropPrimary(): void
    {
        $this->changeColumnAttribute('primary', false);
    }


    /**
     * @throws Exception
     */
    public function changeType(string $type): void
    {
        $this->changeColumnAttribute('type', $type);
    }


    /**
     * @throws Exception
     */
    public function changeLength(int $length): void
    {
        $this->changeColumnAttribute('length', $length);
    }


    /**
     * @throws Exception
     */
    public function dropNullable(): void
    {
        $this->changeColumnAttribute('nullable', false);
    }


    /**
     * @throws Exception
     */
    public function dropUnique(): void
    {
        $this->changeColumnAttribute('unique', false);
    }


    /**
     * @throws Exception
     */
    public function dropAutoIncrement(): void
    {
        $this->changeColumnAttribute('auto_increment', false);
    }


    /**
     * @throws Exception
     */
    public function dropForeignKey(string $table, string $column): void
    {
        $this->changeColumnAttribute('foreign_key', false);
    }
}