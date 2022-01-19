<?php
require_once(__DIR__.'/baseBlock.php');
use gutenbergBlocks\BaseBlock;
class NumberListImage extends BaseBlock {
    public function __construct( $block , $name ) {
		parent::__construct( $block , $name );
        $list = [];
        if( have_rows('lb_block_numbers_list') ) {
            $list = [];
            while( have_rows('lb_block_numbers_list') ) : the_row();
                $list[] = [
                    //'number' => get_sub_field('lb_block_numbers_list_number'),
                    'title' => get_sub_field('lb_block_numbers_list_title'),
                    'text' => get_sub_field('lb_block_numbers_list_text'),
                ];
               
            endwhile;
        }
        
        $payload= [
            'images' => [
                'original' => get_field('lb_block_numbers_image'),
                'large' => get_field('lb_block_numbers_image'),
                'medium' => get_field('lb_block_numbers_image'),
                'small' => get_field('lb_block_numbers_image')
            ],
            'numbersList' => [
                'title' => get_field('lb_block_numbers_title'),
                'list' => $list,
            ]
        ];
        
        // $this->addInfobox($payload['leftCard']);
        $this->setContext($payload);
           
    }
}






