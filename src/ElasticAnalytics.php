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

    public static function fireEvent(array $params) {
        self::buildClient()->index($params);
    }
}
