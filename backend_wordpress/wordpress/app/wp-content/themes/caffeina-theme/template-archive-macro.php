<?php

/* Template Name: Template Archive Macro categoria */

use Caffeina\LaboSuisse\Resources\ArchiveMacro;
use Timber\Timber;

if(!isset($_GET['product_category']) or $_GET['product_category'] === null) {
    return wp_safe_redirect(
        get_search_link()
    );
}

$archiveMacro = new ArchiveMacro($_GET['product_category']);

$context = [
    'filters' => [
        'filter_type' => 'product',
        'post_type' => 'product',
        'posts_per_page' => -1,
        'containerized' => false,
        'items' => [
            [
                'id' => 'lb-brand',
                'label' => '',
                'placeholder' => __('Brand', 'labo-suisse-theme'),
                'multiple' => true,
                'required' => false,
                'disabled' => false,
                'confirmBtnLabel' => __('Applica', 'labo-suisse-theme'),
                'options' => $archiveMacro->brands,
                'attributes' => ['data-taxonomy="lb-brand"'],
                'variants' => ['primary']
            ],
            [
                'id' => 'lb-product-cat-typology',
                'label' => '',
                'placeholder' => __('Tipi di prodotto', 'labo-suisse-theme'),
                'multiple' => true,
                'required' => false,
                'disabled' => false,
                'confirmBtnLabel' => __('Applica', 'labo-suisse-theme'),
                'options' => $archiveMacro->categories,
                'attributes' => ['data-taxonomy="product_cat"'],
                'variants' => ['primary']
            ],
            // [
            //     'id' => 'lb-product-order',
            //     'label' => __('Ordina per', 'labo-suisse-theme'),
            //     'placeholder' => __('Scegli...', 'labo-suisse-theme'),
            //     'multiple' => true,
            //     'required' => false,
            //     'disabled' => false,
            //     'confirmBtnLabel' => __('Applica', 'labo-suisse-theme'),
            //     'options' => [],
            //     'variants' => ['secondary']
            // ],
        ],
        'search' => [
            'type' => 'search',
            'name' => 's',
            'label' => __('Cerca... (inserisci almeno 3 caratteri)', 'labo-suisse-theme'),
            'value' => !empty($_GET['s']) ? $_GET['s'] : null,
            'disabled' => false,
            'required' => true,
            'buttonTypeNext' => 'submit',
            'variants' => ['secondary'],
        ],
       'hidden' => [
           'name' => 'product_category',
           'value' => $_GET['product_category'],
       ]
    ],
    'grid_type' => 'ordered',
    'num_posts' => __('Risultati:', 'labo-suisse-theme') . ' <span>' . $archiveMacro->totalPosts . '</span>',
    'items' => $archiveMacro->products,
    // 'load_more' => [
    //     'posts_per_page' => 4,
    //     'label' => __('Carica altro', 'labo-suisse-theme'),
    // ],
    'page_intro' => [
        'title' => $archiveMacro->category->name,
        'description' => nl2br($archiveMacro->category->description),
    ],
];

Timber::render('@PathViews/template-archive-macro.twig', $context);

