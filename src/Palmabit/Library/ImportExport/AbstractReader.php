<?php  namespace Palmabit\Library\ImportExport; 
/**
 * Class AbstractReader
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 * @todo better error handling
 */
use Palmabit\Library\ImportExport\Interfaces\Reader;
use ArrayIterator, Exception;

abstract class AbstractReader implements Reader
{
    /**
     * The objects as StdClass
     * @var \ArrayIterator
     */
    protected $objects;
    /**
     * Objects as real usable class
     * @var \ArrayIterator
     */
    protected $objects_istantiated;
    /**
     * @var String
     */
    protected $istantiated_objects_class_name;

    /**
     * @return \ArrayIterator
     */
    public function getObjects()
    {
        return $this->objecs;
    }

    /**
     * @return \ArrayIterator
     */
    public function getObjectsIstantiated()
    {
        return $this->objects_istantiated;
    }

    /**
     * Assuming that we can pass all the proprieties to that object as an array
     * we istantiate each of that StdClass as a IstantiatedObject
     * @return \ArrayIterator
     * @throws \Exception
     */
    public function istantiateObjects()
    {
        if( ! $this->istantiated_objects_class_name) throw new Exception("You need to set istantiated_object_class_name");

        $objects_iterator = new ArrayIterator;

        if($this->objects) foreach ($this->objects as $object)
        {
            // fetch data as array
            $data_array = get_object_vars($object);
            // istantiate new class
            $object = new $this->istantiated_objects_class_name($data_array);
            // append to iterator
            $objects_iterator->append($object);
        }

        $this->objects_istantiated = $objects_iterator;
        return $this->objects_istantiated;
    }

    /**
     * @return String
     */
    public function getIstantiatedObjectsClassName()
    {
        return $this->istantiated_objects_class_name;
    }

    /**
     * @param array $objects
     */
    public function setObjects(array $objects)
    {
        $this->objects = $objects;
    }

}