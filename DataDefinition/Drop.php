<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class Drop extends _DdlCommon
{
    public function drop(string $type = 'table'): self
    {
        if ($type == 'table'){
            $this->addAction('dropTable');
            $this->logTable($this->getTableName());
        } elseif ($type == 'view'){
            $this->addAction('dropView');
            $this->logView($this->getViewName());
        } else {
            throw new \Exception("The type of object to drop is not supported.");
        }
        return $this;
    }

    public function build(): string
    {
        return "";
    }
}