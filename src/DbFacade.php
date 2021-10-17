<?php
namespace Scpzc\LaravelDb;

use Illuminate\Support\Facades\Facade;


class DbFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Db';
    }
}
