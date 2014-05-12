<?php  namespace Palmabit\Library\ImportExport; 
/**
 * Class AbstractReader
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
use InvalidArgumentException;
use Palmabit\Library\ImportExport\Interfaces\Reader as ReaderInterface;
use ArrayIterator, Exception;

abstract class Reader implements ReaderInterface
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
        return $this->objects;
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
        $this->validateObjectClassName();

        $objects_iterator = new ArrayIterator;

        $this->appendObjectDataToIterator($objects_iterator);

        $this->objects_istantiated = $objects_iterator;
        return $this->objects_istantiated;
    }

    private function validateObjectClassName()
    {
        if (!$this->istantiated_objects_class_name) throw new Exception("You need to set istantiated_object_class_name");

        if (!class_exists($this->istantiated_objects_class_name)) throw new InvalidArgumentException("The class name to istantiate given is not valid.");
    }

    /**
     * @param $objects_iterator
     */
    private function appendObjectDataToIterator($objects_iterator)
    {
        if ($this->objects) foreach ($this->objects as $object) {
            $data_array = $this->transformObjectDataToArray($object);
            $object = $this->istantiateObjectClass($data_array);

            $objects_iterator->append($object);
        }
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

    /**
     * @param $object
     * @return array
     */
    private function transformObjectDataToArray($object)
    {
        $data_array = get_object_vars($object);

        return $data_array;
    }

    /**
     * @param $data_array
     * @return mixed
     */
    private function istantiateObjectClass($data_array)
    {
        $object = new $this->istantiated_objects_class_name($data_array);

        return $object;
    }
}
