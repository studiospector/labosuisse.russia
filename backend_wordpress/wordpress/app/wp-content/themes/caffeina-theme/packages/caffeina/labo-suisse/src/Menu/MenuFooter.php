<?php

namespace Caffeina\LaboSuisse\Menu;

use Caffeina\LaboSuisse\Menu\DiscoverLabo\DiscoverLaboFooter;
use Caffeina\LaboSuisse\Menu\Support\Support;
use Caffeina\LaboSuisse\Option\Option;

class MenuFooter
{
    public static function get()
    {
        $prefooter = [];

        if (!is_home()) {
            $options = (new Option())->getPreFooterOptions();

            $prefooter = [
                'block_1' => self::leftBlock($options['left']),
                'block_2' => self::centerBlock($options['center']),
                'block_3' => self::rightBlock($options['right'])
            ];
        }

        return [
            'prefooter' => $prefooter,
            'footer' => [
                'discover' => (new DiscoverLaboFooter())->get(),
                'support' => (new Support())->get(),
                'search' => self::search(),
                'newsletter' => self::newsletter(),
                'social' => self::social()
            ]
        ];
    }

    private static function search()
    {
        $search = (new Option())
            ->getFooterSearchOptions();

        return [
            'title' => $search['title'] ?? null,
            'form' => [
                'action' => get_post_type_archive_link('lb-store'),
                'input' => [
                    'type' => 'search',
                    'id' => "lb-search-val-footer",
                    'name' => "lb-search-val",
                    'label' => $search['label'] ?? null,
                    'disabled' => false,
                    'required' => false,
                    'buttonTypeNext' => 'submit',
                    'variants' => ['secondary'],
                ],
            ],
        ];
    }

    private static function newsletter()
    {
        $newsletter = (new Option())
            ->getFooterNewsletterOptions();

        return [
            'title' => $newsletter['title'] ?? null,
            'text' => $newsletter['text'] ?? null,
            'cta' => $newsletter['cta'] ?? null
        ];
    }

    private static function social()
    {
        return (new Option())
            ->getFooterSocialNetwork();
    }

    private static function leftBlock($options)
    {
        if (is_null($options)) {
            return [
                'subtitle' => null,
                'paragraph' => null,
                'cta' => [],
            ];
        }

        return [
            'subtitle' => $options['lb_prefooter_left_block_title'],
            'paragraph' => $options['lb_prefooter_left_block_text'],
            'cta' => array_merge($options['lb_prefooter_left_block_cta'], [
                'class' => 'js-gtm-tracking',
                'attributes' => 'data-ga-event="click" data-ga-event-name="cta-prefooter" data-ga-event-value="left"',
                'variants' => ['quaternary'],
            ])
        ];
    }

    private static function centerBlock($options)
    {

        return [
            'subtitle' => $options['lb_prefooter_center_block_title'] ?? null,
            'paragraph' => $options['lb_prefooter_center_block_text'] ?? null,
            'form' => [
                'action' => get_post_type_archive_link('lb-store'),
                'input' => [
                    'type' => 'search',
                    'id' => "lb-search-val-prefooter",
                    'name' => "lb-search-val",
                    'label' => $options['lb_prefooter_center_block_label'] ?? null,
                    'disabled' => false,
                    'required' => false,
                    'buttonTypeNext' => 'submit',
                    'variants' => ['secondary'],
                ],
                'class' => 'js-gtm-tracking',
                'attributes' => 'data-ga-event="submit" data-ga-event-name="cta-prefooter" data-ga-event-value="center"',
            ],
        ];
    }

    private static function rightBlock($options)
    {
        if (is_null($options)) {
            return [
                'subtitle' => null,
                'paragraph' => null,
                'cta' => [],
            ];
        }

        return [
            'subtitle' => $options['lb_prefooter_right_block_title'],
            'paragraph' => $options['lb_prefooter_right_block_text'],
            'cta' => array_merge($options['lb_prefooter_right_block_cta'], [
                'class' => 'js-gtm-tracking',
                'attributes' => 'data-ga-event="click" data-ga-event-name="cta-prefooter" data-ga-event-value="right"',
                'variants' => ['quaternary'],
            ])
        ];
    }
}
