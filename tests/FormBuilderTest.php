<?php  namespace Palmabit\Library\Tests;
use Palmabit\Library\Form\FormBuilder;
use Session, Input;
use Illuminate\Database\Eloquent\Model as Eloquent;
/**
 * Test FormBuilderTest
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
class FormBuilderTest extends TestCase {

    protected $old_language_input_name;
    protected $builder;
    protected $slug_lang_name;

    public function setUp()
    {
        parent::setUp();

        $this->builder = new FormBuilder($this->app['html'], $this->app['url'], $this->app['session.store']->getToken());
        $this->old_language_input_name = $this->builder->getOldLanguageInputName();
        $this->slug_lang_name = "slug_lang";
    }

    /**
     * @test
     **/
    public function it_gets_session_value_at_last()
    {
        list($field_name, $field_value) = $this->initializeOldSessionLanguageData();
        Input::shouldReceive('has')
            ->once()
            ->with($this->slug_lang_name)
            ->andReturn(true);

        $form_value = $this->builder->getValueAttribute($field_name, null);

        $this->assertEquals($field_value, $form_value);
    }

    /**
     * @test
     **/
    public function it_doesnt_get_session_value_if_slug_lang_is_not_set()
    {
        list($field_name, $field_value) = $this->initializeOldSessionLanguageData();

        $form_value = $this->builder->getValueAttribute($field_name, null);

        $this->assertNull($form_value);
    }
    
    /**
     * @test
     **/
    public function it_updateSessionLangValuesWithModelAttributes()
    {
        $model_stub = new EloquentStub;
        $model_stub->field = "value";
        $this->builder->setModel($model_stub);

        $this->builder->open();

        $this->assertTrue(Session::has($this->builder->getOldLanguageInputName() ) );
        $old_input = Session::get($this->builder->getOldLanguageInputName() );
        $this->assertEquals($old_input["field"], $model_stub->field);
    }

    /**
     * @return array
     */
    private function initializeOldSessionLanguageData()
    {
        $field_name         = "test_name_field";
        $field_value        = "value of the field";
        $old_language_input = [$field_name => $field_value];
        Session::put($this->old_language_input_name, $old_language_input);

        return array($field_name, $field_value);
    }
}

class EloquentStub extends Eloquent
{}