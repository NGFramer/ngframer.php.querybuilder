<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class Drop extends _DdlCommon
{
    public function drop(): void
    {
        $this->addAction('dropTable');
        $this->logTable($this->getTableName());
    }

    public function build(): string
    {
        return "";
    }
}