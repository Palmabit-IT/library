<?php namespace Palmabit\Library\Tests;

use Illuminate\Support\MessageBag;
use Palmabit\Library\Exceptions\ValidationException;
use Palmabit\Library\Form\FormModel;
use Mockery as m;
use Palmabit\Library\Tests\TestCase;

class FormModelTest extends TestCase
{
    protected $faker;
    protected $repo;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @expectedException Palmabit\Library\Exceptions\ValidationException
     */
    public function testProcessThrowsValidationException()
    {
        $stub_validator = new ValidatorInterfaceStubFalse();

        $form = new FormModel($stub_validator, new \StdClass());
        $form->process(array());
    }

    public function testProcessCreateWorks()
    {
        $stub_validator = new ValidatorInterfaceStub();
        $obj = new \StdClass();
        $obj->id="1";
        $mock_repo = m::mock('StdClass')->shouldReceive(array(
                                                             'create' => $obj,
                                                        ))
                      ->getMock();
        $form = new FormModel($stub_validator, $mock_repo);
        $form->process(array());
    }

    public function testProcessUpdateWorks()
    {
        $stub_validator = new ValidatorInterfaceStub();
        $obj = new \StdClass();
        $obj->id="1";
        $mock_repo = m::mock('StdClass')->shouldReceive(array(
                                                             "update" => $obj,
                                                        ))
                      ->getMock();
        $form = new FormModel($stub_validator, $mock_repo);
        $form->process(array("id" => "1"));
    }

    /**
     * @expectedException Palmabit\Library\Exceptions\NotFoundException
     */
    public function testProcessThrowNotFound()
    {
        $stub_validator = new ValidatorInterfaceStub();

        $mock_repo = m::mock('StdClass')->shouldReceive('update')->andThrow(new \Palmabit\Library\Exceptions\NotFoundException)->getMock();
        $form = new FormModel($stub_validator, $mock_repo);
        $form->process(array("id" => "1"));
    }

    /**
     * @test
     **/
    public function itSetErrorsOnValidationException()
    {
        $stub_validator = new ValidatorInterfaceStubException();

        $form = new FormModel($stub_validator, new \StdClass());

        $got_exception = false;
        try
        {
            $form->process(array());
        }
        catch(ValidationException $e)
        {
            $got_exception = true;
        }

        $this->assertTrue($got_exception);
        $this->assertFalse($form->getErrors()->isEmpty());
    }
}

class ValidatorInterfaceStub implements \Palmabit\Library\Validators\ValidatorInterface
{
    public function validate($input){
        return true;
    }
    public function getErrors(){}

}

class ValidatorInterfaceStubFalse extends ValidatorInterfaceStub
{
    public function validate($input){
        return false;
    }
}

class ValidatorInterfaceStubException extends ValidatorInterfaceStub
{
    public function validate($input){
        throw new ValidationException;
    }

    public function getErrors()
    {
        return new MessageBag(["error" => "error"]);
    }
}