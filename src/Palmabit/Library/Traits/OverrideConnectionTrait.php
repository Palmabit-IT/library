<?php  namespace Palmabit\Library\Traits;

/**
 * Trait OverrideConnectionTrait
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