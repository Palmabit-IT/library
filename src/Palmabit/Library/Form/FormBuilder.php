<?php  namespace Palmabit\Library\Form; 
/**
 * Class FormBuilder
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
use Illuminate\Html\FormBuilder as LaravelFormBuilder;
use Session, Input;

class FormBuilder extends LaravelFormBuilder
{
    protected $old_language_input_name = "form_old_language_product_input";
    protected $slug_lang_name = "slug_lang";

    /**
     * Get the value that should be assigned to the field.
     *
     * @param  string  $name
     * @param  string  $value
     * @return string
     * @override
     */
    public function getValueAttribute($name, $value = null)
    {
        if (is_null($name)) return $value;

        if ( ! is_null($this->old($name)))
        {
            return $this->old($name);
        }

        if ( ! is_null($value)) return $value;

        if ($this->checkIfModelExists())
        {
            return $this->getModelValueAttribute($name);
        }

        if ($this->canUpdateValueWithSessionLang())
        {
            $language_input = $this->getOldLanguageInput();
            if($this->isAValidFormAttribute($name, $language_input)) return $language_input[$name];
        }
    }

    /**
     * @return mixed
     */
    private function getOldLanguageInput()
    {
        $language_input = Session::get($this->old_language_input_name);

        return $language_input;
    }

    /**
     * @return bool
     */
    private function canUpdateValueWithSessionLang()
    {
        return Session::has($this->old_language_input_name) && Input::has($this->slug_lang_name);
    }

    /**
     * @return mixed
     */
    public function getOldLanguageInputName()
    {
        return $this->old_language_input_name;
    }

    public function updateOldLanguageInput()
    {
        $old_lang_input = [];
        if ($this->checkIfModelExists()) foreach ($this->model->toArray() as $model_field => $model_value) {
            $old_lang_input[$model_field] = $model_value;
        }

        Session::put($this->old_language_input_name, $old_lang_input);
    }

    /**
     * @return bool
     */
    private function checkIfModelExists()
    {
        return isset($this->model) && $this->model->exists;
    }

    /**
     * @param $name
     * @param $language_input
     * @return bool
     */
    private function isAValidFormAttribute($name, $language_input)
    {
        return isset($language_input[$name]) && $name != 'id';
    }
}