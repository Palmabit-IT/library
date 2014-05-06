<?php

if( ! function_exists('getValueItem'))
{
    function getValueItem($item, $key, $default_value = null)
    {
        // convert to object
        if(is_array($item)) $item = (object)$item;

        return isset($item->$key) ? $item->$key : $default_value;
    }
}