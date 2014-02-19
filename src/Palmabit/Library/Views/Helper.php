<?php namespace Palmabit\Library\Views;
/**
 * Class View Helper
 *
 * @author jacopo beschi j.beschi@palmabit.com
 */
use Request;
use Route;

class Helper 
{
    /**
     * Check if url is the same of the current url and return active state
     * @param String $url
     * @param String $active
     * @return $active
     */
    public static function get_active($url, $active = 'active')
    {
        return (Request::url() == $url) ? $active : '';
    }

    /**
     * Check if route name is the same as the current url and returns active state
     * @param $match
     * @param $active
     */
    public static function get_active_route_name($match, $active = 'active')
    {
        $route_name = Route::currentRouteName();
        $base_name = array_values(explode(".", $route_name))[0];
        return (strcasecmp($base_name, $match) == 0) ? $active : '';
    }
} 