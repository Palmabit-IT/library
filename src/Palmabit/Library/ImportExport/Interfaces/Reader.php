<?php namespace Palmabit\Library\ImportExport\Interfaces;
/**
 * Interface Reader
 *
 * @author jacopo beschi j.beschi@palmabit.com
 */
interface Reader 
{
    /**
     * Open stream from a source
     *      A source can be anything: for instance a db, a file, or a socket
     * @param $source
     * @return void
     * @throws \Palmabit\Library\Exceptions\CannotOpenFileException
     */
    public function open($source);

    /**
     * Reads a single element from the source
     *    then return a Object instance
     * @return \StdClass object instance
     */
    public function readElement();

    /**
     * Read all the objects from the source
     * @return \ArrayIterator
     */
    public function readObjects();

    /**
     * Obtains all the objects readed as StdClass
     * @return \ArrayIterator
     */
    public function getObjects();

    /**
     * Obtains all the objects readed as Istantiated Class
     * @return \ArrayIterator
     */
    public function getObjectsIstantiated();

    /**
     * Obtains the class name of the objects to istantiate
     * @return mixed
     */
    public function getIstantiatedObjectsClassName();

    /**
     * Set the StdClass objects
     * @param array $objects
     * @return mixed
     */
    public function setObjects(array $objects);

    /**
     * Creates the actual real instance of the required objects
     * @return \ArrayIterator
     */
    public function IstantiateObjects();
}