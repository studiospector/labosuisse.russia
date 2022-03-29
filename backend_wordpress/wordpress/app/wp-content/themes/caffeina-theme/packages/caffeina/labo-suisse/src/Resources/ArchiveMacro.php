<?php

namespace Caffeina\LaboSuisse\Resources;

use Timber\Timber;

class ArchiveMacro
{
    public $category;
    public $brands = [];
    public $products = [];
    public $totalPosts = 0;

    /**
     * @param $category
     */
    public function __construct($category)
    {
        $this->category = get_term_by('slug', $category, 'product_cat');
        $this->products();
    }

    private function products()
    {
        foreach (lb_get_brands() as $brand) {
            $query = new \WP_Query([
                'post_type' => 'product',
                'posts_per_page' => -1,
                'tax_query' => $this->setFilter($brand),
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ]);

            if (empty($query->posts)) {
                continue;
            }

            $this->brands[] = [
                'value' => $brand->slug,
                'label' => $brand->name,
            ];

            $this->products[$brand->term_id]['brand_card'] = $this->getBrandCard($brand);

            foreach ($query->posts as $product) {
                $this->products[$brand->term_id]['products'][] = Timber::get_post($product->ID);
                $this->totalPosts++;
            }
        }

        wp_reset_postdata();
    }


    /**
     * @param $brand
     * @return array
     */
    private function setFilter($brand)
    {
        $filters = [
            'relation' => 'AND',
            [
                'taxonomy' => 'lb-brand',
                'field' => 'slug',
                'terms' => $brand->slug,
            ]
        ];

        if ($this->category) {
            $filters[] = [
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $this->category->slug
            ];
        }

        return $filters;
    }

    /**
     * @param $brand
     * @return array
     */
    public function getBrandCard($brand)
    {
        return [
            'color' => get_field('lb_brand_color', $brand),
            'infobox' => [
                'subtitle' => $brand->name,
                'paragraph' => $brand->description,
                'cta' => [
                    'url' => get_term_link($brand),
                    'title' => __('Scopri il brand', 'labo-suisse-theme'),
                    'variants' => ['quaternary']
                ]
            ],
            'variants' => ['type-8']
        ];
    }
}