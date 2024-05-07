<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class Create extends _DdlCommon
{

    public function create(string $lastSetAction): void
    {
        if ($lastSetAction == 'setTable') {
            $this->createTable();
        } elseif ($lastSetAction == 'setView') {
            $this->createView();
        } else {
            throw new \Exception("No table or view has been set. You must set a table or view before creating.");
        }
    }

    private function createTable(): CreateTable
    {
        $this->addAction('createTable');
        $this->logTable($this->getTableName());
        return new CreateTable($this->getTableName());
    }

    private function createView(): CreateView
    {
        $this->addAction('createView');
        $this->logView($this->getViewName());
        return new CreateView($this->getViewName());
    }


}