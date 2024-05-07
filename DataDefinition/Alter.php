<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class Alter extends _DdlCommon
{
    public function alter(string $lastSetAction): void
    {
        if ($lastSetAction == 'setTable') {
            $this->alterTable();
        } elseif ($lastSetAction == 'setView') {
            $this->alterView();
        } else {
            throw new \Exception("No table or view has been set. You must set a table or view before altering.");
        }
    }

    private function alterTable(): AlterTable
    {
        $this->addAction('alterTable');
        $this->logTable($this->getTableName());
        return new AlterTable($this->getTableName(), null);
    }

    private function alterView(): AlterView
    {
        $this->addAction('alterView');
        $this->logView($this->getViewName());
        return new AlterView(null, $this->getViewName());
    }
}