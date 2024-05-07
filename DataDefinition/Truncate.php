<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class Truncate extends _DdlCommon
{
    public function truncate(string $lastSetAction): void
    {
        if ($lastSetAction === "setTable") {
            $this->truncateTable();
        } else {
            throw new \Exception("Invalid action");
        }
    }

    private function truncateTable(): TruncateTable
    {
        $this->addAction('truncateTable');
        $this->logTable($this->getTableName());
        return new TruncateTable($this->getTableName(), null);
    }
}