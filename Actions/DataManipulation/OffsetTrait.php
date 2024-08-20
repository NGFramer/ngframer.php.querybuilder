<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

Trait OffsetTrait
{
    /**
     * This function adds the offset details to the actionLog.
     * @param int $offset
     * @return OffsetTrait
     * @throws SqlServicesException
     */
    public function offset(int $offset = 0): static
    {
        $this->addToActionLog('offset', $offset);
        return $this;
    }
}