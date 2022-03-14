<?php

namespace Caffeina\LaboSuisse\Menu\Product;

use Caffeina\LaboSuisse\Menu\Traits\HasGetTerms;

class Area
{
    use HasGetTerms;

    private $areas = [];
    private $parent;
    private $device;

    public function __construct($parent, $device)
    {
        $this->parent = $parent;
        $this->device = $device;

        $this->areas = $this->getTerms('product_cat', [
            'parent' => $parent->term_id
        ]);
    }

    public function get()
    {
        return ($this->device == 'desktop')
            ? $this->desktop()
            : $this->mobile();
    }

    private function desktop()
    {
        $items = [
            'type' => 'submenu',
            'label' => $this->parent->name,
            'children' => [
                [
                    'type' => 'submenu',
                    'label' => 'Per Zona',
                    'children' => [
                        ['type' => 'link', 'label' => 'Tutte le zone ' . strtolower($this->parent->name), 'href' =>  get_term_link($this->parent)]
                    ]
                ],
                [
                    'type' => 'submenu-second',
                    'children' => []
                ]
            ],
            'fixed' => [
                [
                    'type' => 'card',
                    'data' => [
                        'images' => [
                            'original' => get_template_directory_uri() . '/assets/images/card-img-5.jpg',
                            'lg' => get_template_directory_uri() . '/assets/images/card-img-5.jpg',
                            'md' => get_template_directory_uri() . '/assets/images/card-img-5.jpg',
                            'sm' => get_template_directory_uri() . '/assets/images/card-img-5.jpg',
                            'xs' => get_template_directory_uri() . '/assets/images/card-img-5.jpg',
                        ],
                        'infobox' => [
                            'subtitle' => 'Magnetic Eyes',
                            'paragraph' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                            'cta' => [
                                'url' => '#',
                                'title' => 'Scopri di più',
                                'iconEnd' => ['name' => 'arrow-right'],
                                'variants' => ['quaternary']
                            ]
                        ],
                        'variants' => ['type-3']
                    ],
                ],
            ]
        ];

        foreach ($this->areas as $i => $area) {
            $items['children'][0]['children'][] = [
                'type' => 'submenu-link',
                'label' => $area->name,
                'trigger' => md5($area->slug),
            ];

            $items['children'][1]['children'][$i] = [
                'type' => 'submenu',
                'label' => 'Per Esigenza',
                'trigger' => md5($area->slug),
                'children' => (new Need($area))->get()
            ];
        }

        return $items;
    }

    private function mobile()
    {
        $items = [
            'type' => 'submenu',
            'label' => $this->parent->name,
            'subLabel' => 'Per zona',
            'children' => [
                ['type' => 'link', 'label' => 'Tutte le zone ' . strtolower($this->parent->name), 'href' =>  get_term_link($this->parent)]
            ]

        ];

        foreach ($this->areas as $i => $area) {
            $items['children'][] = [
                'type' => 'submenu',
                'label' => $area->name,
                'subLabel' => 'Per esigenza',
                'children' => (new Need($area))->get()
            ];
        }

        return $items;
    }
}