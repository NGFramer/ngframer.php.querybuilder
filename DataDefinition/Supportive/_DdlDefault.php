<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Supportive;

class _DdlDefault
{
    private static array $defaultLength;


    public static function setLength(): void
    {
        self::$defaultLength['int'] = 11;
        self::$defaultLength['varchar'] = 255;
        self::$defaultLength['char'] = 255;
        self::$defaultLength['tinyint'] = 4;
        self::$defaultLength['smallint'] = 6;
        self::$defaultLength['mediumint'] = 9;
        self::$defaultLength['bigint'] = 20;
        self::$defaultLength['decimal'] = 10;
        self::$defaultLength['float'] = 12;
        self::$defaultLength['double'] = 22;
        self::$defaultLength['bit'] = 1;
        self::$defaultLength['date'] = 0;
        self::$defaultLength['time'] = 0;
        self::$defaultLength['datetime'] = 0;
        self::$defaultLength['timestamp'] = 0;
        self::$defaultLength['year'] = 0;
        self::$defaultLength['text'] = 0;
        self::$defaultLength['tinytext'] = 0;
        self::$defaultLength['mediumtext'] = 0;
        self::$defaultLength['longtext'] = 0;
        self::$defaultLength['blob'] = 0;
        self::$defaultLength['tinyblob'] = 0;
        self::$defaultLength['mediumblob'] = 0;
        self::$defaultLength['longblob'] = 0;
        self::$defaultLength['enum'] = 0;
        self::$defaultLength['set'] = 0;
    }


    public static function getLength(string $type): int
    {
        self::setLength();
        return self::$defaultLength[$type];
    }

}