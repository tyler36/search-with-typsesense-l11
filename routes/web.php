<?php

use Illuminate\Support\Facades\Route;
use Typesense\Client;

Route::get('/create-collection', function (Client $client) {
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

Route::get('/import-collection', function (Client $client) {
    $books = file_get_contents(base_path('books.jsonl'));
    $response = $client->collections['books']->documents->import($books);

    return 'Book imported';
});

Route::get('/search-collection', function (Client $client) {
    $results = $client->collections['books']->documents->search([
        'q' => request('q'),
        'query_by' => 'title',
        'sort_by' => '_text_match:desc,publication_year:desc',  // use ':asc' for ascending
        'per_page' => 15,
    ]);

    $titles = collect($results['hits'])->map(fn ($hit) => $hit['document']['title']);
    dd($titles);
});


Route::get('/filter-search', function (Client $client) {
    return $client->collections['books']->documents->search([
        'q' => request('q'),
        'query_by' => 'title',
        'sort_by' => '_text_match:desc,publication_year:desc',  // use ':asc' for ascending
        'per_page' => 15,
        'filter_by' => 'authors:=Blake Crouch'
    ]);
});
