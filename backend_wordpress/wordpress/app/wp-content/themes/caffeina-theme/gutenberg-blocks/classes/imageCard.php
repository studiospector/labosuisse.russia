<?php
require_once(__DIR__.'/baseBlock.php');
use gutenbergBlocks\BaseBlock;
class ImageCard extends BaseBlock {
    public function __construct( $block , $name ) {
		parent::__construct( $block , $name );
        $payload = [
            'images' => [
                'original' => get_field('lb_block_image_card_image_left'),
                'large' => get_field('lb_block_image_card_image_left'),
                'medium' => get_field('lb_block_image_card_image_left'),
                'small' => get_field('lb_block_image_card_image_left')
            ],
            'card' => [
                'images' =>[
                    'original' => get_field('lb_block_image_card_image_right'),
                    'large' => get_field('lb_block_image_card_image_right'),
                    'medium' => get_field('lb_block_image_card_image_right'),
                    'small' => get_field('lb_block_image_card_image_right')
                ],
                'variants' => ['type-8']
        
                
            ],
        ];
        $this->addInfobox($payload['card']);
        $this->setContext($payload);   
    }
}
