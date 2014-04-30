<?php namespace Palmabit\Library\Validators;

use Event, V;
use Illuminate\Validation\DatabasePresenceVerifier;
use Palmabit\Library\Traits\OverrideConnectionTrait;
use Palmabit\Library\Validators\AbstractValidator as BaseValidator;

class OverrideConnectionValidator extends BaseValidator
{
  use OverrideConnectionTrait;

  /**
   * @param $input
   * @return mixed
   * @override
   */

  /**
   * @override
   * @param $input
   * @return bool
   */
  public function validate($input)
  {
    Event::fire('validating', [$input]);
    $validator = $this->instanceValidator($input);

    if($validator->fails())
    {
      $this->errors = $validator->messages();

      return false;
    }

    return true;
  }

  public function instanceValidator($input)
  {
    $validator = V::make($input, static::$rules);
    // update presence verifier
    $validator->getPresenceVerifier()->setConnection($this->getConnection());
    return $validator;
  }
} 