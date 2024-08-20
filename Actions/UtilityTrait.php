<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Utilities\ArrayTools;

trait UtilityTrait
{
    /**
     * This function will set the action key in the action log.
     * @param string $action
     * @return void
     */
    public function setAction(string $action): void
    {
        ArrayTools::addToArray($this->actionLog, 'action', $action);
    }

    /**
     * This function will assign value to the key in the action log.
     * @throws SqlServicesException
     */
    public function addToActionLog(mixed ...$args): void
    {
        ArrayTools::addToArrayDeep($this->actionLog, ...$args);
    }

    /**
     * This function will assign an array to the key in the action log.
     * If further executed, will add more values on a single key (array).
     * @throws SqlServicesException
     */
    public function addInActionLog(mixed ...$args): void
    {
        ArrayTools::addInArrayDeep($this->actionLog, ...$args);
    }
}