<?php namespace Palmabit\Library\Validators;

use Event;
use Illuminate\Support\Facades\App;
use Validator as V;
use Illuminate\Validation\DatabasePresenceVerifier;
use Palmabit\Library\Traits\OverrideConnectionTrait;
use Palmabit\Library\Validators\AbstractValidator as BaseValidator;

class OverrideConnectionValidator extends BaseValidator
{
    use OverrideConnectionTrait;
}
