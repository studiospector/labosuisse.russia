<?php

namespace Caffeina\LaboSuisse\Blocks;

class BaseBlock
{
    public $id;
    public $name;
    public $acfName;
    public $className;
    public $payload = [];
    protected $block;
    public $context;
    private $field_names = ['block_id', 'block_className'];

    public function __construct($block = null, $name = null)
    {
        if ($block != null) {
            $this->block = $block;

            $this->name = is_null($name) ? str_replace("acf/lb-", "", $this->block['name']) : $name;
            $this->id = $this->name . $block['id'];
            // $this->id = "hero-" . $this->block['id'];
            if (!empty($this->block['anchor'])) {
                $id = $this->block['anchor'];
            }
            //?
            $className = $this->name;
            // $this->className = 'hero';
            if (!empty($this->block['className'])) {
                $this->className .= ' ' . $this->block['className'];
            }
            if (!empty($this->block['align'])) {
                $this->className .= ' align' . $this->block['align'];
            }
        } else {
            $this->name = $name;
            $this->id = 0;
            $this->className = "";
        }
        $this->context = [
            'block' => $this->name,
            'data' => [
                'conf' => [
                    'id' => esc_attr($this->id),
                    'classes' => esc_attr($this->className)
                ],
            ]
        ];
        $this->acfName = 'lb_block_' . str_replace(["block-", "-"], ["", "_"], $this->name);
        // var_dump($this->acfName);
    }

    public function addInfobox(&$context = null)
    {
        //creare cta

        $infobox = [
            'infobox' => [
                'tagline' => get_field($this->acfName . '_infobox_tagline'),
                'title' => get_field($this->acfName . '_infobox_title'),
                'subtitle' => get_field($this->acfName . '_infobox_subtitle'),
                'paragraph' => get_field($this->acfName . '_infobox_paragraph'),
                'paragraph_small' => get_field($this->acfName . '_infobox_paragraph_small'),
                //  'cta' => array_merge( get_field($this->acfName.'_infobox_btn') == "" ? [] : [get_field($this->acfName.'_infobox_btn')] ,['variants' => [get_field($this->acfName.'_infobox_btn_variants')]])
            ]
        ];
        if (get_field($this->acfName . '_infobox_btn') != "") {
            $infobox['infobox']['cta'] = array_merge((array)get_field($this->acfName . '_infobox_btn'), ['variants' => [get_field($this->acfName . '_infobox_btn_variants')]]);
        }


        if (!is_null($context)) {

            $context = array_merge($context, $infobox);
        } else {
            $this->context['data'] = array_merge($this->context['data'], $infobox);
            $this->payload = array_merge($this->payload, $infobox);
        }
        // echo '<pre>';
        // var_dump( $infobox );
        // die;


    }

    public function setContext($payload)
    {
        $this->payload = $payload;
        $this->context['data'] = array_merge($this->context['data'], $payload);
    }
    public function getPayload()
    {
        $active = is_null(get_field($this->acfName . '_visibility')) ? true : get_field($this->acfName . '_visibility');

        $retPayload = [];
        if ($active) {
            $retPayload = $this->payload;
        }
        //   var_dump($this->acfName.'_visibility');
        //   var_dump($active);
        return $retPayload;
    }
    public function render()
    {
        $active = is_null(get_field($this->acfName . '_visibility')) ? true : get_field($this->acfName . '_visibility');
        if (isset($this->block['data']['is_preview']) && $this->block['data']['is_preview'] == true) {
            \Timber::render('@PathViews/gutenberg-preview.twig', [
                'base_url' => get_site_url(),
                'name' => $this->name,
                'img' => 'block-two-images',
                'ext' => 'png',
            ]);
            return;
        }
        $contextRet = $this->context;
        if (!$active) {
            $contextRet['data'] = [];
        }
        \Timber::render('@PathViews/components/base/gutenberg-block-switcher.twig', $contextRet);
    }
}
