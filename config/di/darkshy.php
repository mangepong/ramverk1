<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "content" => [
            "shared" => true,
            "callback" => function () {
                $darkshy = new \Anax\Controller\WeatherCurl();
                $cfg = $this->get("configuration");
                $config = $cfg->load("api_keys.php");
                $darkshy->setKey($config['config']['key']);

                return $darkshy;
            }
        ],
    ],
];