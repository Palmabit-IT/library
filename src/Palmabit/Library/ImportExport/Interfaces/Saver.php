<?php use Palmabit\Library\ImportExport\Interfaces;
/**
 * Interface Saver
 *
 * @author jacopo beschi j.beschi@palmabit.com
 */
interface Saver 
{
    /**
     * Handle saving the array of data
     * @param array $data
     * @return mixed
     */
    public function save(array $data);
} 