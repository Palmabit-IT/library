<?php  namespace Palmabit\Library\Tests; 
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery as m;
use Palmabit\Library\Repository\EloquentBaseRepository;

/**
 * Test EloquentBaseRepositoryTest
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
class EloquentBaseRepositoryTest extends TestCase {

  /**
   * @test
   **/
  public function canFindAModel()
  {
      $expected_model = "i'm expected to be returned from a find";
      $finder_mock = m::mock('StdClass');
      $finder_mock->shouldReceive('findOrFail')
        ->once()
        ->andReturn($expected_model);

      $repository = new EloquentBaseRepository($finder_mock);

      $obtained_model = $repository->find(1);
      $this->assertEquals($expected_model, $obtained_model);
  }
  
  /**
   * @test
   * @expectedException \Palmabit\Library\Exceptions\NotFoundException
   **/
  public function itThrowsException_IfCannotFindAModel()
  {
    $finder_failer_mock = m::mock('StdClass');
    $finder_failer_mock->shouldReceive('findOrFail')
            ->once()
            ->andThrow(new ModelNotFoundException);

    $repository = new EloquentBaseRepository($finder_failer_mock);

    $repository->find(1);
  }

  /**
   * @test
   **/
  public function itCallsAllOnModel()
  {
    $all_mock = m::mock('StdClass');
    $all_mock->shouldReceive('all')
            ->once()
            ->andReturn('');

    $repository = new EloquentBaseRepository($all_mock);
    $repository->all();
  }

  /**
   * @test
   **/
  public function itCallsCreateOnModel()
  {
    $all_mock = m::mock('StdClass');
    $all_mock->shouldReceive('create')
            ->once()
            ->andReturn('');

    $repository = new EloquentBaseRepository($all_mock);
    $repository->create([]);
  }

  /**
   * @test
   **/
  public function itUpdatesAModel()
  {
    list($update_data, $model_mock) = $this->getMockModelFindUpdate();

    $object_id = 1;
    $repository = new EloquentBaseRepository($model_mock);
    $repository->update($object_id, $update_data);
  }
  
  /**
   * @test
   **/
  public function itDeleteModel()
  {
    $model_mock = $this->getMockModelFindDelete();

    $object_id = 1;
    $repository = new EloquentBaseRepository($model_mock);
    $repository->delete($object_id);
  }

  /**
   * @return array
   */
  private function getMockModelFindUpdate()
  {
    $update_data     = ["column" => "value"];
    $obj_update_mock = m::mock('StdClass');
    $obj_update_mock->shouldReceive('update')->once()->with($update_data);

    $model_mock = m::mock('StdClass');
    $model_mock->shouldReceive('findOrFail')->once()->andReturn($obj_update_mock);
    return array($update_data, $model_mock);
  }

  /**
   * @return m\MockInterface|\Yay_MockObject
   */
  private function getMockModelFindDelete()
  {
    $obj_delete_mock = m::mock('StdClass');
    $obj_delete_mock->shouldReceive('delete')->once();

    $model_mock = m::mock('StdClass');
    $model_mock->shouldReceive('findOrFail')->once()->andReturn($obj_delete_mock);
    return $model_mock;
  }

}
 