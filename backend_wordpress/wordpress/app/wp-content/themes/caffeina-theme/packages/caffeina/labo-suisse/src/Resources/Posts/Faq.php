<?php

namespace Caffeina\LaboSuisse\Resources\Posts;

use Caffeina\LaboSuisse\Resources\Traits\Arrayable;
use Caffeina\LaboSuisse\Resources\Traits\HasImages;

class Faq
{
    use Arrayable, HasImages;

    private $post;

    public $images;
    public $infobox;
    public $type = 'type-7';

    public function __construct($post)
    {
        $this->post = $post;

        $this->images = $this->getImages();
        $this->infobox = $this->getInfobox();
    }

    private function getInfobox()
    {
        $image = (get_field('lb_faq_logo')) ? get_field('lb_faq_logo') : null;

        $questions = [];

        while (have_rows('lb_faq_items', $this->post->ID)) {
            the_row();
            $questions[] = get_sub_field('lb_faq_item_question', $this->post->ID);
        }

        $questions = array_slice($questions, -4);

        return [
            'image' => $image,
            'subtitle' => ($image) ? null : $this->post->post_title,
            'items' => $questions,
            'cta' => [
                'title' => __('Vedi tutto', 'labo-suisse-theme'),
                'url' => get_permalink($this->post->ID),
                'variants' => ['quaternary']
            ]
        ];
    }
}
