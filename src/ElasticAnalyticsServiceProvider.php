<?php

namespace BrockReece\ElasticAnalytics;

use Illuminate\Support\ServiceProvider;

class ElasticAnalyticsServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('elasticAnalytics', '\BrockReece\ElasticAnalytics');
    }
}
