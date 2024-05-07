<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class AlterView extends _DdlCommon
{

    public function select(string $selectQuery): self
    {
        $this->logViewValue($selectQuery);
        return $this;
    }

    public function build(): string
    {
        return "";
        // TODO: Implement build() method.
    }
}