<?php
/**
 *
 * Tyche Contact Widget
 *
 * @package Tyche
 */
?>

<?php if ( isset( $params['contact_title'] ) ) : ?>
	<h5 class="widget-title"><span><?php echo esc_html( $params['contact_title'] ) ?></span></h5>
<?php endif; ?>

<?php if ( isset( $params['address'] ) ) : ?>
	<p class="tyche-contact-p"><i class="fa fa-map-marker"></i>
		<strong><?php echo esc_html__( 'Address:', 'tyche' ) ?></strong>
		<br/><?php echo esc_html( $params['address'] ) ?></p>
<?php endif; ?>

<?php if ( isset( $params['phone'] ) ) : ?>
	<p class="tyche-contact-p"><i class="fa fa-mobile"></i>
		<strong><?php echo esc_html__( 'Phone:', 'tyche' ) ?></strong>
		<br/><?php echo esc_html( $params['phone'] ) ?></p>
<?php endif; ?>

<?php if ( isset( $params['email'] ) ) : ?>
	<p class="tyche-contact-p"><i class="fa fa-envelope"></i>
		<strong><?php echo esc_html__( 'Email:', 'tyche' ) ?></strong>
		<br/><?php echo esc_html( $params['email'] ) ?></p>
<?php endif; ?>
