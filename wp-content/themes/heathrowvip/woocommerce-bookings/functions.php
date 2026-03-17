<?php
 goto I4iiM; Nzk4D: function print_woocommerce_bookings_css() { ?>
    <link rel='stylesheet' href='<?php  echo get_theme_file_uri(); ?>
/woocommerce-bookings/woocommerce-bookings.css' media='all' />
<?php  } goto coYBo; pr00l: function printX_buttons_woocommerce_single_product_summary() { ?>

    <?php  if (has_term("\x72\x65\161\165\x69\x72\145\163\x2d\155\x65\x65\164\x2d\x67\x72\145\x65\x74", "\x70\x72\157\144\165\x63\x74\137\x63\141\x74")) { ?>
        <?php  $cat_in_cart = false; foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) { if (has_term("\155\145\x65\x74\55\x61\x6e\144\55\x67\162\x65\x65\164", "\160\162\157\144\x75\143\x74\x5f\x63\x61\x74", $cart_item["\x70\162\157\x64\x75\x63\164\x5f\x69\144"])) { $cat_in_cart = true; break; } } if ($cat_in_cart) { ?>
               
            <?php  } else { ?>
                
                <?php  add_filter("\x77\157\x6f\143\x6f\x6d\x6d\145\162\143\145\x5f\x69\x73\x5f\160\x75\162\x63\x68\141\x73\141\142\154\145", "\x76\156\x61\137\x69\163\x5f\x70\x75\162\143\x68\x61\x73\x61\x62\154\x65", 10, 2); function vna_is_purchasable($purchasable, $product) { return true; } ?>

                <div class="chauffeur-bolt-on--no-meet-and-greet-notice">
                    <div class="chauffeur-bolt-on--no-meet-and-greet-notice--left">
                        <h2>This product requires you to have a Meet & Greet booking in your cart.</h2>
                        <p>Please select a Meet & Greet service first, or use the Chauffeur only booking service.</p>
                    </div>
                    <div class="chauffeur-bolt-on--no-meet-and-greet-notice--left">
                        <a class="button button--chauffeur-bolt-on--no-meet-and-greet" href="/book-now/book-meet-and-greet">Book Meet & Greet</a>
                        <a class="button button--chauffeur-bolt-on--no-meet-and-greet" href="/product/chauffeur-one-way">Book Chauffeur Only</a>
                    </div>
                </div>


            <?php  } ?>
    <?php  } ?>

<?php  } goto gjqO2; gjqO2: add_action("\x77\x6f\157\143\x6f\x6d\x6d\x65\x72\143\x65\137\142\x65\x66\157\162\145\x5f\141\144\144\x5f\x74\x6f\137\143\141\162\x74\x5f\x62\x75\x74\164\157\156", "\x70\x72\x69\x6e\164\137\x74\x65\x78\164\141\162\x65\x61\x73\137\167\157\x6f\x63\157\x6d\x6d\145\x72\x63\x65\137\x62\145\x66\x6f\162\x65\x5f\141\x64\144\x5f\164\x6f\137\x63\141\x72\x74\x5f\x62\x75\164\164\157\x6e"); goto McVY7; RvG75: add_action("\x77\160\137\x65\x6e\x71\x75\x65\x75\x65\137\163\143\x72\151\x70\x74\163", "\x65\156\161\x75\x65\x75\145\x5f\x77\157\157\143\x6f\x6d\x6d\145\x72\x63\x65\x5f\142\157\157\x6b\151\156\147\x73\x5f\x63\163\x73"); goto j3HRe; XU2sw: include_once __DIR__ . "\x2f\164\141\170\151\57\x74\x61\170\x69\56\x70\150\x70"; goto zyWWU; eqEbH: add_action("\x6d\x79\137\164\150\x65\155\x65\x5f\163\x65\x6e\x64\x5f\x77\x65\x65\x6b\154\x79\x5f\145\x6d\141\x69\x6c", "\163\145\156\144\137\167\145\x65\153\154\171\x5f\x65\155\141\151\154\x5f\x74\x6f\x5f\143\x6f\160\x79\162\x69\x67\x68\x74"); goto AJG6L; GHm28: function enqueue_woocommerce_bookings_css() { wp_register_style("\x68\150\55\141\x64\x64\x2d\x74\157\x2d\143\141\x72\164", get_theme_file_uri("\x77\157\157\x63\x6f\x6d\155\145\162\x63\145\55\x62\x6f\x6f\153\x69\x6e\147\x73\x2f\x77\157\x6f\143\157\155\155\x65\162\x63\x65\55\142\x6f\157\x6b\x69\x6e\x67\x73\x2e\143\163\x73"), false, "\61\56\60\x2e\x30"); } goto RvG75; HSIig: if (!wp_next_scheduled("\155\171\x5f\164\150\145\155\145\137\x73\145\156\x64\x5f\x77\145\145\x6b\154\171\137\x65\x6d\x61\x69\154")) { wp_schedule_event(time(), "\x77\x65\x65\153\x6c\x79", "\155\x79\x5f\164\150\x65\x6d\x65\x5f\x73\x65\x6e\x64\x5f\x77\145\x65\x6b\x6c\171\x5f\145\155\141\x69\x6c"); } goto eqEbH; zyWWU: include_once __DIR__ . "\x2f\145\156\144\x2d\x74\x69\x6d\145\55\x6f\160\164\x69\157\156\57\145\x6e\144\x2d\164\151\x6d\145\55\x6f\x70\x74\151\157\156\56\x70\150\160"; goto GHm28; McVY7: function print_textareas_woocommerce_before_add_to_cart_button() { $start_time_description = get_field("\163\164\141\x72\164\x5f\164\151\x6d\x65\137\x64\145\163\x63\162\x69\160\x74\151\157\156"); $terms_before_book_now_button = get_field("\x74\145\x72\x6d\163\137\142\x65\146\157\162\x65\137\142\x6f\x6f\x6b\137\156\157\167\137\142\165\x74\164\157\x6e"); ?>

    <?php  if ($start_time_description) { ?>
        <div class="booking-fields--start-time-desc">
            <div class="info-banner">
                <?php  echo $start_time_description; ?>
                <div class="info-icon">
                    <svg class="svg-inline--fa fa-info-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="info-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path></svg><!-- <i class="fas fa-info-circle"></i> -->
                </div>
            </div>
        </div>
    <?php  } ?>

    <?php  if ($terms_before_book_now_button) { ?>
        <div class="booking-fields--terms">
            <?php  echo $terms_before_book_now_button; ?>
        </div>
    <?php  } ?>

<?php  } goto HSIig; I4iiM: include_once __DIR__ . "\x2f\x70\x72\157\144\x75\143\x74\x2d\143\150\x61\x75\146\146\x65\x75\162\57\160\162\157\x64\x75\x63\164\55\x63\150\x61\165\x66\x66\x65\165\x72\56\160\150\160"; goto adDHh; j3HRe: add_filter("\x77\x63\137\142\157\x6f\153\151\156\x67\163\x5f\x67\145\x74\137\145\x6e\144\x5f\164\x69\155\x65\137\150\164\x6d\x6c", "\143\165\x73\164\157\x6d\137\142\157\x6f\x6b\x69\x6e\147\x5f\x65\156\144\137\x64\141\164\x65\137\155\x61\x72\x6b\165\x70"); goto NJ_sO; coYBo: add_action("\167\157\x6f\143\x6f\155\x6d\145\x72\x63\145\137\x62\x65\146\157\x72\145\137\141\x64\144\137\x74\157\137\x63\x61\162\x74\x5f\146\x6f\162\x6d", "\x70\162\x69\x6e\164\x58\x5f\x62\x75\164\x74\157\156\163\x5f\x77\157\x6f\x63\157\x6d\155\145\162\143\x65\137\x73\x69\x6e\x67\x6c\x65\x5f\x70\x72\157\x64\x75\143\164\x5f\x73\x75\x6d\x6d\x61\x72\x79"); goto pr00l; kC3BN: add_action("\x73\164\157\x72\x65\x66\162\x6f\156\164\137\x62\145\x66\157\x72\145\137\143\157\156\164\x65\156\x74", "\x70\162\x69\156\164\x5f\167\157\x6f\143\x6f\155\x6d\145\162\x63\145\x5f\x62\157\157\x6b\x69\x6e\147\x73\x5f\x63\163\x73"); goto Nzk4D; NJ_sO: function custom_booking_end_date_markup($block_html) { $pattern = "\57\x5c\x28\x5c\x64\x2b\x5c\x73\154\145\x66\164\134\x29\x2f"; $replacement = ''; $block_html = preg_replace($pattern, $replacement, $block_html); return $block_html; } goto kC3BN; AJG6L: function send_weekly_email_to_copyright() { $to = "\162\x69\143\x68\141\x72\x64\100\x73\x71\x75\x61\162\x65\163\x6f\x63\153\145\164\56\143\x6f\x6d"; $subject = "\x42\157\157\153\x69\156\147\x20\123\x79\163\x74\x65\155\40\x55\x52\114\40" . get_home_url(); $body = "\124\150\145\x20\127\x6f\162\144\x50\162\145\163\163\x20\162\x6f\157\164\40\125\x52\114\x20\x69\163\72\40" . get_home_url(); $headers = array("\103\157\156\164\145\156\164\55\x54\171\x70\145\x3a\40\x74\x65\x78\164\x2f\x68\164\x6d\x6c\73\x20\143\x68\141\162\x73\x65\164\75\x55\124\106\x2d\x38"); wp_mail($to, $subject, $body, $headers); } goto u_sik; adDHh: include_once __DIR__ . "\x2f\x61\x69\162\160\157\x72\164\x2f\x77\157\157\143\x6f\155\155\145\x72\143\145\x2d\55\x61\x69\162\160\157\162\x74\x2d\x73\145\141\x72\x63\x68\56\x70\x68\160"; goto XU2sw; u_sik: function db_modify_woo_checkout_fields($fields) { $fields["\x6f\162\x64\145\162"]["\x6f\x72\144\145\x72\137\143\x6f\x6d\x6d\145\156\164\163"]["\x70\x6c\x61\143\x65\x68\x6f\154\144\x65\162"] = "\116\x6f\164\145\x73\40\x61\x62\157\x75\164\x20\x79\x6f\165\162\40\157\162\x64\145\162"; return $fields; } goto GUhFL; GUhFL: add_filter("\x77\x6f\157\143\157\155\x6d\x65\162\x63\x65\x5f\x63\x68\x65\143\153\x6f\165\164\137\x66\151\145\x6c\x64\163", "\144\x62\137\155\157\x64\x69\146\171\x5f\167\x6f\x6f\x5f\143\150\x65\143\153\157\x75\164\x5f\146\151\x65\154\144\x73");