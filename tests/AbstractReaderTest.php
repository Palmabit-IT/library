<?php  namespace Palmabit\Library\Tests;
use Illuminate\Database\Eloquent\Model;
use Palmabit\Library\ImportExport\AbstractReader;
use Mockery as m;
/**
 * Test AbstractReaderTest
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
class AbstractReaderTest extends TestCase {

    public function tearDown()
    {
        m::close();
    }

    /**
     * @test
     **/
    public function it_istantiate_objects_from_stdclass()
    {
        $number = 10;
        $objects = $this->createStdClassArray($number);

        $reader = m::mock('Palmabit\Library\Tests\AbstractReaderStub')->makePartial();
        $reader->setObjects($objects);

        $reader->istantiateObjects();
        $istantiated_objects = $reader->getObjectsIstantiated();

        $this->assertEquals("ArrayIterator",get_class($istantiated_objects));
        $this->assertEquals($number, count($istantiated_objects));
        $this->assertInstanceOf('\Palmabit\Library\Tests\IstantiatedObjectStub', $istantiated_objects->current());
        $this->assertEquals("name1", $istantiated_objects->current()->name);
    }

    /**
     * @test
     * @expectedException \Exception
     **/
    public function it_throws_exception_if_obj_class_name_is_not_setted()
    {
        $reader = m::mock('Palmabit\Library\ImportExport\AbstractReader')->makePartial();
        $reader->istantiateObjects();
    }

    protected function createStdClassArray($n = 10)
    {
        $objects = [];
        foreach (range(1, $n) as $key) {
            $object          = new \StdClass();
            $object->name    = "name{$key}";
            $object->surname = "surname{$key}";
            $objects[]       = $object;
        }

        return $objects;
    }
}

class IstantiatedObjectStub extends Model
{
    protected $fillable = ["name","surname"];
}

abstract class AbstractReaderStub extends AbstractReader
{
    protected $istantiated_objects_class_name = "\Palmabit\Library\Tests\IstantiatedObjectStub";
}


