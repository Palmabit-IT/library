<?php namespace Palmabit\Library\ImportExport\Interfaces;
/**
 * Interface Saver
 *
 * @author jacopo beschi j.beschi@palmabit.com
 */
use ArrayIterator;

interface Saver
{
    /**
     * Handle saving the array of data
     * @param \ArrayIterator $objects
     * @return mixed
     */
    public function save(ArrayIterator $objects);
} 