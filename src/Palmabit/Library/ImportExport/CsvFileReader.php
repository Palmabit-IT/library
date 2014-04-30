<?php  namespace Palmabit\Library\ImportExport;

use ArrayIterator;
use Palmabit\Library\ImportExport\Reader;
use SplFileObject;

/**
 * Class DbCsvFileReader
 *
 * @author jacopo beschi j.beschi@palmabit.com
 */
class CsvFileReader extends Reader
{
  /**
   * @var \SplFileObject
   */
  protected $spl_file_object;
  /**re
   *
   * @var string
   */
  protected $delimiter = ";";
  /**
   * @var Array
   */
  protected $columns_name;

  /**
   * Open stream from a source
   *      A source can be anything: for instance a db, a file, or a socket
   *
   * @param String $path
   * @return void
   * @throws \Palmabit\Library\Exceptions\CannotOpenFileException
   */
  public function open($path)
  {
    $this->convertToLF($path);
    $this->spl_file_object = new SplFileObject($path);
    $this->spl_file_object->setCsvControl($this->delimiter);
    $this->columns_name = $this->spl_file_object->fgetcsv();
  }

  /**
   * Reads a single element from the source
   *    then return a Object instance
   *
   * @return \StdClass|false object instance
   */
  public function readElement()
  {
    $csv_line_data = $this->spl_file_object->fgetcsv();
    if($csv_line_data)
    {
      $csv_line_data[0] = $this->convertToUtf8($csv_line_data);
      if($this->isValidLine($csv_line_data))
      {
        $csv_line         = array_combine($this->columns_name, $csv_line_data);
        // we cast it to StdClass
        return (object)$csv_line;
      }
    }

    return false;
  }

  /**
   * @param $csv_line_data
   * @return mixed
   */
  protected function isValidLine($csv_line_data)
  {
    return $csv_line_data[0];
  }

  /**
   * Read all the objects from the source
   *
   * @return \ArrayIterator
   */
  public function readElements()
  {
    $iterator = new ArrayIterator;
    do
    {
      $object = $this->readElement();
      if($object) $iterator->append($object);
    } while((boolean)$object);

    $this->objects = $iterator;
    return $this->objects;
  }

  /**
   * @return string
   */
  public function getDelimiter()
  {
    return $this->delimiter;
  }

  /**
   * @param string $delimiter
   */
  public function setDelimiter($delimiter)
  {
    $this->delimiter = $delimiter;
  }

  /**
   * @param $csv_line_data
   * @return bool|mixed|string
   */
  protected function convertToUtf8($csv_line_data)
  {
    return mb_convert_encoding($csv_line_data[0], "UTF-8");
  }

  protected function convertToLF($path)
  {
    $cr   = "\r"; // Carriage Return: Mac
    $lf   = "\n"; // Line Feed: Unix
    $crlf = "\r\n"; // Carriage Return and Line Feed: Windows

    $text = file_get_contents($path);

    $text = $this->convertCharacters($cr, $lf, $text);
    $text = $this->convertCharacters($crlf, $lf, $text);

    file_put_contents($path, $text);
  }

  /**
   * @param $cr
   * @param $lf
   * @param $text
   * @return mixed
   */
  protected function convertCharacters($cr, $lf, $text)
  {
    return str_replace($cr, $lf, $text);
  }
}