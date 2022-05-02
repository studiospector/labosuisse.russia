<?php

/* Template Name: Template Ricerca */

use Caffeina\LaboSuisse\Api\GlobalSearch\Search;

$search_val = !empty($_GET['lb-search-val']) ? $_GET['lb-search-val'] : null;

$items = (new Search())
    ->setSearch($search_val)
    ->get();

$context = [
    'num_res' => 0,
    'search_val' => $search_val,
    'tabs' => $items,
];

Timber::render('@PathViews/search.twig', $context);
