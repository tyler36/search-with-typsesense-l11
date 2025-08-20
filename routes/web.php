<?php

use App\Models\Course;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Typesense\Client;
use Typesense\Documents;

Route::get('/', function () {
    return Course::search(request('q', '*') )
        ->options([
            'query_by' => 'embedding',
        ])
        ->raw();
});

Route::get('/search', function () {
    return Inertia::render('Search/Index');
});

Route::get('/playground', function (Client $client) {
    // Target a query for "Twilight" exactly
    // bump the document with the ID of 8354
    $override = [
        'rule' => [
            'query' => 'twilight',
            'match' => 'exact',
        ],
        'includes' => [
            ['id' => '8354', 'position' => 1]
        ],
    ];

    $client->collections['books']->overrides->upsert('promote_twilight_sponsorship', $override);

    // Uncomment the below line to remove the override.
    // $client->collections['books']->overrides['promote_twilight_sponsorship']->delete();

    return 'Override created';
});

Route::get('/create-collection', function (Client $client) {
    $bookSchema = [
        'name' => 'books',
        'fields' => [
            ['name' => 'title', 'type' => 'string'],
            ['name' => 'authors', 'type' => 'string[]', 'facet' => true],
            ['name' => 'publication_year', 'type' => 'int32'],
            ['name' => 'ratings_count', 'type' => 'int32'],
            ['name' => 'average_rating', 'type' => 'float'],
        ],
        'default_sorting_field' => 'ratings_count',
    ];

    $client->collections['books']->delete();

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
        // 'filter_by' => 'publication_year:2000',
        // 'filter_by' => 'publication_year:[2000..2010]',
        // 'filter_by' => 'authors:=Blake Crouch',
        // 'filter_by' => 'authors:=Blake Crouch && publication_year:=2016'
        // 'filter_by' => 'authors:=Blake Crouch || publication_year:=2000'
        // 'filter_by' => 'publication_year:[1990..2000] || publication_year:[2010..2020]'
        // 'filter_by' => 'publication_year:[1990..2000, 2010..2020]'
        'filter_by' => 'publication_year:<1950',
    ]);
});

Route::get('/faceting', function (Client $client) {
    return $client->collections['books']->documents->search([
        'q' => request('q'),
        'query_by' => 'title',
        'sort_by' => '_text_match:desc,ratings_count:desc',
        'per_page' => 50,
        'facet_by' => 'authors'
    ]);
});
