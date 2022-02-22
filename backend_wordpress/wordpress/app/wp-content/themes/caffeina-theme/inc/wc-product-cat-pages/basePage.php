<?php

namespace Pages;

class basePage
{
    private $context;
    public $name;

    public function __construct($name, $term)
    {
        $this->name = $name;

        $this->context = [
            'level' => $this->name,
            'data' => [
                'term_name' => $term->name,
                'term_description' => $term->description,
                'term_image' => get_field('lb_product_cat_image', $term),
            ]
        ];
    }

    public function setContext($payload)
    {
        $this->context['data'] = array_merge($this->context['data'], $payload);
    }

    public function render()
    {
        \Timber::render('@PathViews/woo/taxonomy-product-cat.twig', $this->context);
    }

    public static function getProductCategory($parent = null, $args = [])
    {
        $args['taxonomy'] = 'product_cat';
        $args['hide_empty'] = false;
        $args['parent'] = ($parent) ? $parent->term_id : null;

        return get_terms($args);
    }
}
