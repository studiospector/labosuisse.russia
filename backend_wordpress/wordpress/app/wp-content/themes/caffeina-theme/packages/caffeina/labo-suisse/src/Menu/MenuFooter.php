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
            'title' => $search['title'],
            'input' => [
                // The only parameter to manage in options is label
                'type' => 'search',
                'name' => "lb-search-store-footer",
                'label' => $search['label'],
                'disabled' => false,
                'required' => false,
                'buttonTypeNext' => 'button',
                'variants' => ['secondary'],
            ]
        ];
    }

    private static function newsletter()
    {
        $newsletter = (new Option())
            ->getFooterNewsletterOptions();

        return [
            'title' => $newsletter['title'],
            'text' => $newsletter['text'],
            'cta' => $newsletter['cta']
        ];
    }

    private static function social()
    {
        return (new Option())
            ->getFooterSocialNetwork();
    }

    private static function leftBlock($options)
    {
        return [
            'title' => $options['lb_prefooter_left_block_title'],
            'text' => $options['lb_prefooter_left_block_text'],
            'cta' => array_merge($options['lb_prefooter_left_block_cta'], ['variants' => ['quaternary']])
        ];
    }

    private static function centerBlock($options)
    {
        return [
            'title' => $options['lb_prefooter_center_block_title'],
            'text' => $options['lb_prefooter_center_block_text'],
            'input' => [
                // The only parameter to manage in options is label
                'type' => 'search',
                'name' => "lb-search-store-prefooter",
                'label' => $options['lb_prefooter_center_block_label'],
                'disabled' => false,
                'required' => false,
                'buttonTypeNext' => 'button',
                'variants' => ['secondary'],
            ]
        ];
    }

    private static function rightBlock($options)
    {
        return [
            'title' => $options['lb_prefooter_right_block_title'],
            'text' => $options['lb_prefooter_right_block_text'],
            'cta' => array_merge($options['lb_prefooter_right_block_cta'], ['variants' => ['quaternary']])
        ];
    }
}