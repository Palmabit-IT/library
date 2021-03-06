<?php namespace Palmabit\Library\Form;
/**
 * Class FormModel
 *
 * Classe per il salvataggio di form associati ad un model
 *
 * @package Auth
 * @author jacopo beschi
 */
use Palmabit\Library\Validators\ValidatorInterface;
use Palmabit\Library\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\MessageBag;
use Palmabit\Library\Exceptions\NotFoundException;
use Palmabit\Authentication\Exceptions\PermissionException;
use Event;

class FormModel implements FormInterface{

    /**
     * Validatore
     * @var \Palmabit\Library\Validators\ValidatorInterface
     */
    protected $v;
    /**
     * Repository usato per la gestione dei dati
     * @var
     */
    protected $r;
    /**
     * Nome del campo id del model
     * @var string
     */
    protected $id_name = "id";
    /**
     * Errori di validazione
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    public function __construct(ValidatorInterface $validator, $repository)
    {
        $this->v = $validator;
        $this->r = $repository;
    }

    /**
     * Processa l'input e chiama create o opdate a seconda
     * @param array $input
     * @throws \Palmabit\Library\Exceptions\PalmabitExceptionsInterface
     */
    public function process(array $input)
    {
        try
        {
            $success = $this->v->validate($input);
        }
        catch(ValidationException $e)
        {
            $this->setErrorsAndThrowException();
        }
        if( ! $success)
        {
            $this->setErrorsAndThrowException();
        }

        Event::fire("form.processing", array($input));
        return $this->callRepository($input);
    }

    /**
     * Chiama il repository con i metodo update o create
     * @param $input
     * @throws \Palmabit\Library\Exceptions\NotFundException
     */
    protected function callRepository($input)
    {
        if($this->isUpdate($input))
        {
            try
            {
                $obj = $this->r->update($input[$this->id_name], $input);
            }
            catch(ModelNotFoundException $e)
            {
                $this->errors = new MessageBag(array("model" => "Elemento non trovato"));
                throw new NotFoundException();
            }
            catch(PermissionException $e)
            {
                $this->errors = new MessageBag(array("model" => "Non è possibile modificare questo elemento"));
                throw new PermissionException();
            }
        }
        else
        {
            try
            {
                $obj = $this->r->create($input);
            }
            catch(NotFoundException $e)
            {
                $this->errors = new MessageBag(array("model" => $e->getMessage()));
                throw new NotFoundException();
            }
        }
        return $obj;
    }

    /**
     * Ottiene se l'operazione da effettuare è update o create
     * @param $input
     * @return booelan $update update=true create=false
     */
    protected function isUpdate($input)
    {
        return (isset($input[$this->id_name]) && ! empty($input[$this->id_name]) );
    }

    /**
     * Cancella il model dal db
     * @param $input
     * @throws \Palmabit\Library\Exceptions\NotFoundException
     */
    public function delete(array $input)
    {
        if(isset($input[$this->id_name]) && ! empty($input[$this->id_name]))
        {
            try
            {
                $this->r->delete($input[$this->id_name]);
            }
            catch(ModelNotFoundException $e)
            {
                $this->errors = new MessageBag(array("model" => "Elemento non esistente"));
                throw new NotFoundException();
            }
            catch(PermissionException $e)
            {
                $this->errors = new MessageBag(array("model" => "Non è possibile cancellare questo elemento, verifica i tuoi permessi e che l'elemento non sia associato ad altri."));
                throw new PermissionException();
            }
        }
        else
        {
            $this->errors = new MessageBag(array("model" => "Id non fornito"));
            throw new NotFoundException();
        }
    }
    
    public function getErrors()
    {
        return $this->errors;
    }

    protected function setErrorsAndThrowException()
    {
        $this->errors = $this->v->getErrors();
        throw new ValidationException;
    }

    /**
     * @param mixed $r
     */
    public function setR($r)
    {
        $this->r = $r;
    }

    /**
     * @return mixed
     */
    public function getR()
    {
        return $this->r;
    }
}