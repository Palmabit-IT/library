<?php namespace Palmabit\Library\Exceptions;


use Illuminate\Support\MessageBag;

class ImageEvidenceException extends \Exception implements PalmabitExceptionsInterface
{
    /**
     * @var MessageBag
     */
    protected $errors;

    /**
     * @param MessageBag $errors
     */
    function __construct(MessageBag $errors)
    {
        $this->errors = $errors;

    }

    /**
     * Get form validation errors
     *
     * @return MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }
} 