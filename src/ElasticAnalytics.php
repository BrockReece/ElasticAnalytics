<?php
namespace BrockReece\ElasticAnalytics;

class ElasticAnalytics {
    protected $client;

    public function __construct() {
        $this->client = $this->buildClient();
    }

    public static function buildClient() {
        return \Elasticsearch\ClientBuilder::create()
            ->setHosts(config('elasticquent.config.hosts'))
            ->setRetries(config('elasticquent.config.retries'))
            ->build();
    }

    public static function buildClientByIP($ip) {
        return \Elasticsearch\ClientBuilder::create()
            ->setHosts([$ip])
            ->setRetries(config('elasticquent.config.retries'))
            ->build();
    }

    public static function log(array $params) {
        self::buildClient()->index($params);
    }

    public static function magicReplicator($function) {
        if (!config('elasticquent.active')) {
            return;
        }
        
        foreach (config('elasticquent.clusters') as $ip) {
            $client = self::buildClientByIP($ip);
            $function($client);
        }
    }
}
