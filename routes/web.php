<?php

use Illuminate\Support\Facades\Route;
use Typesense\Client;

Route::get('/create-collection', function () {
    $client = new Client([
        'api_key' => config('services.typesense.api_key'),
        'nodes' => [
            [
                'host' => config('services.typesense.host'),
                'port' => config('services.typesense.port'),
                'protocol' => config('services.typesense.protocol'),
            ],
        ],
        'connection_timeout_seconds' => 2,
    ]);

    $bookSchema = [
        'name' => 'books',
        'fields' => [
            ['name' => 'title', 'type' => 'string'],
            ['name' => 'authors', 'type' => 'string[]'],
            ['name' => 'publication_year', 'type' => 'int32'],
            ['name' => 'ratings_count', 'type' => 'int32'],
            ['name' => 'average_rating', 'type' => 'float'],
        ],
        'default_sorting_field' => 'ratings_count',
    ];

    $client->collections->create($bookSchema);

    // Health check
    // curl "typesense:8108/collections/books" -H "X-TYPESENSE-API-KEY: xyz";

    return 'Collection created';
});

Route::get('/import-collection', function () {
    $client = new Client([
        'api_key' => config('services.typesense.api_key'),
        'nodes' => [
            [
                'host' => config('services.typesense.host'),
                'port' => config('services.typesense.port'),
                'protocol' => config('services.typesense.protocol'),
            ],
        ],
        'connection_timeout_seconds' => 2,
    ]);

    $books = file_get_contents(base_path('books.jsonl'));
    $response = $client->collections['books']->documents->import($books);

    return 'Book imported';
});

Route::get('/search-collection', function () {
    $client = new Client([
        'api_key' => config('services.typesense.api_key'),
        'nodes' => [
            [
                'host' => config('services.typesense.host'),
                'port' => config('services.typesense.port'),
                'protocol' => config('services.typesense.protocol'),
            ],
        ],
        'connection_timeout_seconds' => 2,
    ]);

    $results = $client->collections['books']->documents->search([
        'q' => request('q'),
        'query_by' => 'title',
    ]);

    dd($results);
});
