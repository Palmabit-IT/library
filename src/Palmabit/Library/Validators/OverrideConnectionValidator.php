<?php namespace Palmabit\Library\Validators;

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
    public function instanceValidator($input)
    {
        $validator = V::make($input, static::$rules);
        // update presence verifier
        $validator->getPresenceVerifier()->setConnection($this->getConnection());
        return $validator;
    }
} 