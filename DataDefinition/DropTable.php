<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class DropTable extends _DdlCommon
{

    public function drop()
    {
        $this->logTable($this->getTableName());
        return new CreateTable($this->getTableName());
    }
}