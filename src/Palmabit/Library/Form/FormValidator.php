<?php namespace Palmabit\Library\Forms;

use App;

use Illuminate\Validation\Factory as Validator;
use Illuminate\Validation\Validator as ValidatorInstance;
use Palmabit\Library\Exceptions\FormValidationException;

abstract class FormValidator {

  /**
   * @var Validator
   */
  protected $validator;

  /**
   * @var ValidatorInstance
   */
  protected $validation;


  /**
   *
   * @param Validator $validator
   */
  function __construct(Validator $validator = null)
  {
    $this->validator = $validator ? $validator : App::make('validator');
  }

  /**
   * @param array $formData
   * @param null  $parameters
   * @return bool
   * @throws \Palmabit\Library\Exceptions\FormValidationException
   */
  public function validate(array $formData, $parameters = null)
  {

    $this->validation = $this->validator->make($formData, $this->getValidationRules($parameters));

    if ($this->validation->fails())
    {
      throw new FormValidationException(\L::t($this->getValidationErrors()), $this->getValidationErrors());
    }

    return true;
  }

  /**
   * Get the validation rules
   *
   * @return array
   */
  public function getValidationRules($parameters = null)
  {
    return (method_exists($this, 'getRules')) ? $this->getRules($parameters) : $this->rules;
  }

  /**
   * Get the validation errors
   *
   * @return \Illuminate\Support\MessageBag
   */
  protected  function getValidationErrors()
  {
    return $this->validation->errors();
  }

}