<?php  namespace Palmabit\Library\Traits;

/**
 * Trait OverrideConnectionTrait
 *
 * @author jacopo beschi j.beschi@palmabit.com
 */
use App;

trait OverrideConnectionTrait
{
  /**
   * @override
   * @return \Illuminate\Database\Connection
   */
  public function getConnection()
  {
    return DB::connection($this->getConnectionName());
//    return static::resolveConnection($this->getConnectionName());
  }

  public function getConnectionName()
  {
    return (App::environment() != 'testing') ? 'authentication' : 'testbench';
  }
} 