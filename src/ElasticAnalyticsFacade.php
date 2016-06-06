<?php
namespace ElasticAnalytics;

use Illuminate\Support\Facades\Facade;

class ElasticAnalyticsFacade extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'elasticAnalytics'; }
}
