<?php

namespace NGFramer\NGFramerPHPSQLServices\Utilities;

use Exception;

class ArrayTools
{
    /**
     * Constructor function.
     * Defined to not allow object initialization of the class.
     */
    private function __construct()
    {
    }


    /**
     * Checks if an array is associative.
     * @param array $array The array to check.
     * @return bool Returns true if the array is associative, false otherwise.
     */
    public static function isAssociative(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }


    /**
     * Checks if an array is indexed.
     * @param array $array The array to check.
     * @return bool Returns true if the array is indexed, false otherwise.
     */
    public static function isIndexed(array $array): bool
    {
        return !self::isAssociative($array);
    }


    /**
     * This function will assign the specified value to the array at the specified key.
     * Uses reference so the edit is made in place.
     * @param array $array . The array to which the value will be added.
     * @param string $arrayKey . The key where the value will be added.
     * @param mixed $arrayValue . The value to be assigned to the key.
     */
    public static function addToArray(array &$array, string $arrayKey, mixed $arrayValue): void
    {
        // Append the array and make edits to the array.
        $array[$arrayKey] = $arrayValue;
    }


    /**
     * Modified function of addToArray().
     * This function will add the specified value to the array at the specified key.
     * Uses reference so the edit is made in place.
     * @param array $array . The array to which the value will be added.
     * @param string $arrayKey . The key where the value will be added.
     * @param mixed $arrayValue . The value to be assigned to the key.
     */
    public static function addInArray(array &$array, string $arrayKey, mixed $arrayValue): void
    {
        // Append the array and make edits to the array.
        $array[$arrayKey][] = $arrayValue;
    }


    /**
     * This function is the extended version of the addToArray().
     * This function will add key value pairs at deeper levels from the array surface.
     * @param array $array . The array to which the value will be added.
     * @param mixed ...$arguments . The arguments to (n-1)th position are keys, and nth argument is value.
     * @throws Exception
     */
    public static function addToArrayDeep(array &$array, mixed ...$arguments): void
    {
        // Check for the arguments.
        if (count($arguments) < 2) {
            throw new Exception("At least two arguments required: a key and a value.");
        }

        // Get the value. And, the key is now array's arguments.
        $value = array_pop($arguments);

        // Reference to the array to update with the value.
        $current = &$array;

        // Loop through the arguments and add them to the array.
        foreach ($arguments as $key) {
            // Ensure the current element is an array.
            if (!isset($current[$key]) || !is_array($current[$key])) {
                $current[$key] = [];
            }
            $current = &$current[$key];
        }

        // Assign the value to the deepest level key.
        $current = $value;
    }

    /**
     * This function is the extended version of the addToArrayDeep().
     * This function will add key value-making arrays at deeper levels in the array surface.
     * @param array $array . The array to which the value will be added.
     * @param mixed ...$arguments . The arguments to (n-1)th position are keys, and nth argument is value.
     * @throws Exception
     */
    public static function addInArrayDeep(array &$array, mixed ...$arguments): void
    {
        // Check for the arguments.
        if (count($arguments) < 2) {
            throw new Exception("At least two arguments required: a key and a value.");
        }

        // Get the value to be added to the array.
        $value = array_pop($arguments);

        // Reference to traverse the array.
        $current = &$array;

        // Loop through the arguments to set keys as needed.
        foreach ($arguments as $key) {
            // Ensure the current element is an array.
            if (!isset($current[$key]) || !is_array($current[$key])) {
                $current[$key] = [];
            }
            $current = &$current[$key];
        }

        // Add the value to the innermost array.
        $current[] = $value;
    }


    /**
     * The function drops the specified value from the array. This function does not use the key of the value for dropping.
     * @param array $array . The array from which the value needs to be dropped.
     * @param mixed $value . The value that needs to be dropped from the array.
     * @return void . Returns void, Updates the array passed in function.
     * @throws Exception
     */
    public static function dropFromArray(array &$array, mixed $value): void
    {
        $valueExists = false;
        // Loop through the array and remove elements with the specified value
        foreach (array_keys($array, $value) as $key) {
            if ($array[$key] == $value) {
                $valueExists = true;
                unset($array[$key]);
            }
        }
        if (!$valueExists) {
            throw new Exception("Value not found in the array passed.");
        }
        // Reindex array to have consecutive keys
        $array = array_values($array);
    }


    /**
     * This function removes the specified key from the array. Can also unset the entire array, so use carefully.
     * @param array $array . The array to drop. Pass in a key along an array to drop.
     * @return void
     * @throws Exception
     */
    public static function dropArray(array &$array): void
    {
        if (count($array) == 0) {
            throw new Exception("Empty array, drop is not possible.");
        }
        unset($array);
    }


    /**
     * Checks if all the elements of the array are also arrays.
     * @param mixed $array
     * @return bool
     */
    public static function areAllArray(mixed $array): bool
    {
        if (self::isAssociative($array)) {
            foreach ($array as $key => $value) {
                if (!is_array($value)) {
                    return false;
                }
            }
        } else {
            foreach ($array as $value) {
                if (!is_array($value)) {
                    return false;
                }
            }
        }
        return true;
    }
}