<?php
/* @var array $errors All errors for the tool, grouped by blog_id then media_id */
/* @var string $tool Tool key the errors belong to */

/* @var Amazon_S3_And_CloudFront */
global $as3cf;

if ( ! isset( $errors ) || ! is_array( $errors ) ) {
	return;
}

$all_errors = array();

foreach ( $errors as $blog_id => $blog_errors ) {
	foreach ( $blog_errors as $media_id => $messages ) {
		$all_errors[] = (object) compact( 'blog_id', 'media_id', 'messages' );
	}
}

?>

<ol class="as3cf-notice-toggle-list as3cf-<?php esc_attr_e( $tool ) ?>-notice-list" data-tool="<?php esc_attr_e( $tool ) ?>">
	<?php foreach ( $errors as $error ) :
		// If the error is stored as an array, it's almost certainly stored
		// in a previous format/structure that we can't render properly.
		// This will be corrected by the upgrade process, but that process may
		// not have completed yet.
		if ( is_array( $error ) ) {
			continue;
		}

		$this->switch_to_blog( $error->blog_id );

		/** @var \DeliciousBrains\WP_Offload_Media\Items\Item $class */
		$class            = $as3cf->get_source_type_class( $error->source_type );
		$source_type_name = $as3cf->get_source_type_name( $error->source_type );
		$link             = $class::admin_link( $error );
		?>

		<li class="media-error media-error-<?php esc_attr_e( $error->source_type ); ?>-<?php esc_attr_e( $error->source_id ); ?>"
			data-blog-id="<?php esc_attr_e( $error->blog_id ); ?>"
			data-source-type="<?php esc_attr_e( $error->source_type ); ?>"
			data-source-id="<?php esc_attr_e( $error->source_id ); ?>"
		>
			<div class="media-id">
				<strong class="media-error-title"><?php printf( __( '%1$s Item #%2$s', 'amazon-s3-and-cloudfront' ), $source_type_name, $error->source_id ) ?></strong>

				<?php if ( ! empty( $link ) ) : ?>
					<a class="link-inline" href="<?php echo esc_url( $link->url ) ?>" target="_blank"><?php echo esc_html( $link->text ) ?></a>
				<?php endif ?>

				<a href="#" class="link-inline" data-action="dismiss-item-errors"><?php _e( 'Dismiss All', 'amazon-s3-and-cloudfront' ) ?></a>
			</div>

			<ul class="media-error-messages">
				<?php foreach ( (array) $error->messages as $idx => $message ) : ?>
					<li class="media-error-message media-error-message-<?php echo $idx ?>" data-idx="<?php echo $idx ?>">
						<span class="media-error-message-text"><?php echo $message ?></span>
						<span class="media-error-dismiss">
							<a href="#" class="dismiss-link" data-action="dismiss-error"><?php _e( 'Dismiss', 'amazon-s3-and-cloudfront' ) ?></a>
						</span>
					</li>
				<?php endforeach ?>
			</ul>
		</li>

		<?php
		$this->restore_current_blog();

	endforeach;
	?>
</ol>