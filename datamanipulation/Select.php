<?php

namespace NGFramer\NGFramerPHPSQLBuilder\datamanipulation;

Class Select
{
    public static function build(string ...$fields = null)
    {
        if (empty($fields)) {
            return "SELECT *";
        } else {
            return "SELECT " . implode(', ', $fields);
        }
    }
}
