<?php declare(strict_types=1);

return [
    'hosts' => [
        env('ELASTIC_HOST', 'http://elasticsearch:9200'),
    ]
];
