<?php

$context = [
    'page_intro' => [
        'title' => get_the_title(),
        'description' => get_the_excerpt(),
    ],
    'content' => apply_filters('the_content', get_the_content()),
];

Timber::render('@PathViews/page.twig', $context);
