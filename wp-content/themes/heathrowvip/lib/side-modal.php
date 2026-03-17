<?php 

add_action('storefront_header', 'print_side_modal_buttons_after_storefront_header');
function print_side_modal_buttons_after_storefront_header () { ?>

<!--<div class="side-modal">
	<div class="side-modal-inner">
        <div class="text-center">
            <button type="button" class="btn btn-demo" data-toggle="modal" data-target="#myModal">
                Left Sidebar Modal
            </button>
            <button type="button" class="btn btn-demo" data-toggle="modal" data-target="#myModal2">
                Right Sidebar Modal
            </button>
        </div>
	</div>
</div>-->

<?php

}



add_action('storefront_header', 'print_side_modal_after_storefront_header');
function print_side_modal_after_storefront_header () { ?>

<div class="cart-side-modal">
	<div class="cart-side-modal-inner">

		<button type="button" class="open-deskop-side-modal-menu-button" data-toggle="modal" data-target="#myModal">
			<span class="material-icons">menu</span>
		</button>

		<button type="button" class="btn btn-demo" data-toggle="modal" data-target="#myModal">
			Left Sidebar Modal
		</button>
	
		<button type="button" class="btn btn-demo" data-toggle="modal" data-target="#myModal2">
			Right Sidebar Modal
		</button>

	</div>
</div>



<div class="container demo">
	
	
	<!-- Modal -->
	<div class="modal left fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<!--<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Your Basket</h4>
				</div>-->

				<div class="modal-body">
				
					<button type="button" class="close close-deskop-side-modal-menu-button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

					<div class="left-modal-menu">
						<nav id="site-navigation" class="main-navigation toggled" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
							<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="true">
								<span>
									<?php echo esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ); ?>
								</span>
							</button>
								<?php
									wp_nav_menu(
										array(
											'theme_location'	=> 'handheld',
											'container_class'	=> 'handheld-navigation',
											)
									);
								?>
						</nav><!-- #site-navigation -->

						<!--<?php	wp_nav_menu(
                            array(
                            'menu' => 'Main Menu',
                            )
						); ?>-->

					</div>
				</div>
			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->
	
	<!-- Modal -->
	<div class="modal right fade woocommerce-rhs-modal" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel2">Your Basket</h4>
				</div>

				<div class="modal-body">

					<?php if (class_exists('WooCommerce')) { ?>
	
						<?php echo do_shortcode('[free-shipping-cta]'); ?>

						<a class="cart-customlocation" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> – <?php echo WC()->cart->get_cart_total(); ?></a>

						<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
							<?php do_action( 'woocommerce_before_cart_table' ); ?>
								<ul class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
									<?php do_action( 'woocommerce_before_cart_contents' ); ?>
									<?php
									foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
										$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
										$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

										if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
											$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
											?>

											<li class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
												<div class="product-thumbnail">
													<?php
													$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

													if ( ! $product_permalink ) {
														echo $thumbnail; // PHPCS: XSS ok.
													} else {
														printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
													}
													?>
												</div>
												<div class="cart-item-details">
													<p class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
														<?php
														if ( ! $product_permalink ) {
															echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
														} else {
															echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
														}

														do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

														// Meta data.
														echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

														// Backorder notification.
														if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
															echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
														}
														?>
													</p>

													<p class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
														<?php
															echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
														?>
													</p>

													<div class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
														<p>Quantity:</p>
														<?php
														if ( $_product->is_sold_individually() ) {
															$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
														} else {
															$product_quantity = woocommerce_quantity_input( array(
																'input_name'   => "cart[{$cart_item_key}][qty]",
																'input_value'  => $cart_item['quantity'],
																'max_value'    => $_product->get_max_purchase_quantity(),
																'min_value'    => '0',
																'product_name' => $_product->get_name(),
															), $_product, false );
														}

														echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
														?>

														<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update', 'woocommerce' ); ?>"><?php esc_html_e( 'Update', 'woocommerce' ); ?></button>
													</div>

													<p class="product-remove">
														<?php
															// @codingStandardsIgnoreLine
															echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
																'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
																esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
																__( 'Remove this item', 'woocommerce' ),
																esc_attr( $product_id ),
																esc_attr( $_product->get_sku() )
															), $cart_item_key );
														?>
													</p>

												</div>
											</li>
											<?php
										}
									}
									?>

									<?php do_action( 'woocommerce_cart_contents' ); ?>

									<?php do_action( 'woocommerce_cart_actions' ); ?>
									<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

									<?php do_action( 'woocommerce_after_cart_contents' ); ?>
								</ul>

								<?php do_action( 'woocommerce_after_cart_table' ); ?>
						</form>

						<div class="woocommerce-rhs-modal-bottom-block">
							<?php  echo do_shortcode('[cart-cross-sells]'); ?> 
							<div class="woocommerce-rhs-modal-bottom-block-subtotal">
								<span class="subtotal-left">Subtotal</span>
								<span class="subtotal-right">£<?php echo WC()->cart->cart_contents_total ?></span>
							</div>
							<a href="/cart" class="button wide">Checkout</a>
						</div>
					<?php } ?>				
			
				</div>
			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->

</div><!-- container -->

<?php

}

