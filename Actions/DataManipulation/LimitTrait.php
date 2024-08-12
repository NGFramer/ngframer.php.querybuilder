<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use Exception;

Trait LimitTrait
{
    /**
     * This function will add the limit details to the actionLog.
     * @param int $limit
     * @return SelectTable|LimitTrait|SelectView
     * @throws Exception
     */
    public function limit(int $limit): self
    {
        $this->addToActionLog('limit', $limit);
        return $this;
    }
}