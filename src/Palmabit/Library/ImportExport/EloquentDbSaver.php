<?php  namespace Palmabit\Library\ImportExport; 
/**
 * Class EloquentDbSaver
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
use ArrayIterator;
use Palmabit\Library\ImportExport\Interfaces\Saver;

class EloquentDbSaver implements Saver
{
    public function save(ArrayIterator $objects)
    {
        foreach ($objects as $object)
        {
            if( ! $object->save()) return false;
        }

        return true;
    }

} 