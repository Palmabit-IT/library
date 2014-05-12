<?php namespace Palmabit\Library\Validators;

use Event;
use Illuminate\Container\Container;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\App;
use Validator as V;
use Illuminate\Validation\DatabasePresenceVerifier;
use Palmabit\Library\Traits\OverrideConnectionTrait;
use Palmabit\Library\Validators\AbstractValidator as BaseValidator;

class OverrideConnectionValidator extends BaseValidator
{
    use OverrideConnectionTrait;

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