<?php  namespace Palmabit\Library\Tests; 
use Mockery as m;
use Palmabit\Library\ImportExport\EloquentDbSaver;
use ArrayIterator;
/**
 * Test EloquentDbSaverTest
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
class EloquentDbSaverTest extends TestCase {

    public function tearDown()
    {
        m::close();
    }

    /**
     * @test
     **/
    public function it_saves_objects_and_returns_true_on_success()
    {
        $mock_object = m::mock('StdClass')
            ->shouldReceive('save')
            ->once()
            ->andReturn(true)
            ->getMock();
        $objects = new ArrayIterator([$mock_object]);
        $saver = new EloquentDbSaver();

        $success =$saver->save($objects);
        $this->assertTrue($success);

    }

}
 