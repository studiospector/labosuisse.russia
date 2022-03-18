<?php

use Caffeina\LaboSuisse\Option\Option;
use Timber\Timber;

$options = (new Option())->getStoresOptions();

$context = [
    'title' => $options['title'],
    'description' => $options['description'],
    'store_locator' => [
        'map_country' => 'IT',
        'map_lang' => 'it',
        'search' => [
            'type' => 'search',
            'name' => "lb-search-autocomplete",
            'label' => "Inserisci città, provincia, CAP",
            'disabled' => false,
            'required' => false,
            'autocomplete' => 'off',
            'buttonTypeNext' => 'button',
            'class' => 'js-caffeina-store-locator-search',
            'variants' => ['tertiary'],
        ]
    ],
    'card' => $options['card'],
];

Timber::render('@PathViews/archive-lb-store.twig', $context);
