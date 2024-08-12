<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions;

use NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery;

abstract class LogBase
{
    /**
     * Use the utility trait for utility functions.
     */
    use UtilityTrait;

    /**
     * The only variable which will be used in all the action classes.
     */
    protected array $actionLog = [];


    /**
     * This will call the LogAction class's constructor.
     * @return array
     */
    protected function log(): array
    {
        (new BuildQuery())->_construct($this->actionLog);
        return $this->actionLog; //sth
    }


    /**
     * This will call the BuildQuery class's constructor.
     * @return array
     */
    protected function build(): array
    {
        (new BuildQuery())->_construct($this->actionLog);
        return $this->actionLog; //sth
    }


    /**
     * This will call the ExecuteQuery class's constructor.
     * @return array
     */
    protected function execute(): array
    {
        (new BuildQuery())->_construct($this->actionLog);
        return $this->actionLog; //sth
    }
}