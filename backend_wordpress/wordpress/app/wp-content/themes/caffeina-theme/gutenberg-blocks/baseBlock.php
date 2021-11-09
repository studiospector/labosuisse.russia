<?php

namespace gutenbergBlocks;

class BaseBlock {
  public $id;
  public $name;
  public $className;
  protected $block;
  private $context;
  private $field_names = ['block_id', 'block_className'];

  public function __construct($block)
  {
    $this->block = $block;
    $this->name = str_replace("acf/","",$this->block['name']);
    $this->id = $this->name . $block['id'];
    // $this->id = "hero-" . $this->block['id'];
    if( !empty($this->block['anchor']) ) {
        $id = $this->block['anchor'];
    }
    //?
    $className = $this->name;
    // $this->className = 'hero';
    if( !empty($this->block['className']) ) {
        $this->className .= ' ' . $this->block['className'];
    }
    if( !empty($this->block['align']) ) {
        $this->className.= ' align' . $this->block['align'];
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
  }


  public function setContext($payload){
    $this->context['data'] = array_merge($this->context['data'],$payload);

  }
  public function render(){
   // Preview in editor
    if ( isset($this->block['data']['is_preview']) && $this->block['data']['is_preview'] == true ) {
        \Timber::render('@PathViews/gutenberg-preview.twig', [
            'base_url' => get_site_url(),
            'name' => $this->name,
            'img' => 'block-two-images',
            'ext' => 'png',
        ]);
        return;
    }

    \Timber::render('@PathViews/components/base/gutenberg-block-switcher.twig', $this->context);

  }



}
