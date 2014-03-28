<?php  namespace Palmabit\Library\Tests;
use Palmabit\Library\ImportExport\CsvFileReader;

/**
 * Test CsvFileReaderTest
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
class CsvFileReaderTest extends TestCase {

    /**
     * @test
     **/
    public function it_open_a_file()
    {
        $reader = new CsvFileReader();
        $reader->open(__DIR__."/mock_file.csv");
    }

    /**
     * @test
     **/
    public function it_read_element()
    {
        $reader = new CsvFileReader();
        $reader->open(__DIR__."/mock_file.csv");
        $element = $reader->readElement();

        $this->assertEquals('stdClass', get_class($element));
        // read the file to check his structure
        $this->assertEquals("name1", $element->first_name);
    }
   
    /**
     * @test
     **/
    public function it_reads_elements()
    {
        $reader = new CsvFileReader();
        $reader->open(__DIR__."/mock_file.csv");
        $elements = $reader->readElements();

        $this->assertEquals(2, count($elements));
        $this->assertEquals("name1", $elements->current()->first_name);
    }
}
 