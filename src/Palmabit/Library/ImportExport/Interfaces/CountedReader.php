<?php  namespace Palmabit\Library\ImportExport\Interfaces; 
/**
 * Interface CountedReader
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
interface CountedReader 
{
    /**
     * Read a n number of objects and set pointer to the last readed element if possible
     * @return \ArrayIterator
     */
    public function readNObjects();
} 