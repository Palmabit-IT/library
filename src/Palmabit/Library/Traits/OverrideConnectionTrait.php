<?php  namespace Palmabit\Library\Traits;

/**
 * Trait OverrideConnectionTrait
 *
 * You need to use to test models that leverage validation.
 * Using this Trait you override the default db connection using
 * the "testing" connection
 *
 * @author jacopo beschi j.beschi@palmabit.com
 */
use App;
use Illuminate\Database\Eloquent\Model as Eloquent;

trait OverrideConnectionTrait
{
  /**
   * @override
   * @return \Illuminate\Database\Connection
   */
  public function getConnection()
  {
    return Eloquent::resolveConnection($this->getConnectionName());
  }

  public function getConnectionName()
  {
    return (App::environment() != 'testing') ? 'authentication' : 'testbench';
  }
} 