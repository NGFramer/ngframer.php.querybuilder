<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class Drop extends _DdlCommon
{
    public function drop(string $lastSetAction): void
    {
        if ($lastSetAction === "setTable") {
            $this->dropTable();
        } elseif ($lastSetAction === "setView") {
            $this->dropView();
        } else {
            throw new \Exception("Invalid action");
        }
    }

    private function dropTable(): DropTable
    {
        $this->addAction('dropTable');
        $this->logTable($this->getTableName());
        return new DropTable($this->getTableName(), null);
    }

    private function dropView(): DropView
    {
        $this->addAction('dropView');
        $this->logView($this->getViewName());
        return new DropView(null, $this->getViewName());
    }

}