<?php

namespace NGFramer\NGFramerPHPSQLServices;

trait _Utilities
{
    // Supportive function, to check if the array is associative or not.
    protected function isAssocArray(array $array): bool
    {
        // Check if any keys are non-numerical or not starting from 0
        foreach ($array as $key => $value) {
            if (!is_int($key) or $key !== key($array)) {
                return true;
            }
            // Move to the next key.
            next($array);
        }
        return false;
    }


    // Supportive function, to check if all the elements of an array are arrays.
    protected function areElementsArray(array $elementContainer): bool
    {
        // Loop through the element container elements.
        foreach ($elementContainer as $element) {
            if (!is_array($element)) {
                return false;
            }
        }
        return true;
    }
}