<?php

$brand_obj = get_queried_object();

$items = [];

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();

        $items[] = \Timber::get_post( get_the_ID() );
    endwhile;
endif;

wp_reset_postdata();


$context = [
    'page_intro' => [
        'title' => $brand_obj->name,
        'description' => nl2br($brand_obj->description),
    ],
    'num_posts' => __('Risultati:', 'labo-suisse-theme') . ' <span>' . $brand_obj->count . '</span>',
    'grid_type' => 'default',
    'items' => $items,
    'pagination' => lb_pagination(),
];

Timber::render('@PathViews/taxonomy-lb-brand.twig', $context);
