<?php

/* Template Name: Template Archive Macro categoria */

use Caffeina\LaboSuisse\Resources\ArchiveMacro;
use Timber\Timber;

$archiveMacro = new ArchiveMacro($_GET['product_category']);

$context = [
    'filters' => [
        'post_type' => 'product',
        'posts_per_page' => 4,
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
                'options' => [],
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
    ],
    'grid_type' => 'ordered',
    'num_posts' => __('Risultati:', 'labo-suisse-theme') . ' <span>' . $archiveMacro->totalPosts . '</span>',
    'items' => $archiveMacro->products,
    'load_more' => [
        'posts_per_page' => 4,
        'label' => __('Carica altro', 'labo-suisse-theme'),
    ],
    'term_name' => $archiveMacro->category->name,
    'term_description' => $archiveMacro->category->description
];

Timber::render('@PathViews/template-archive-macro.twig', $context);

