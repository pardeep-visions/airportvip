<?php 

add_action('storefront_header', 'print_secondary_mobile_menu_after_storefront_header');
function print_secondary_mobile_menu_after_storefront_header () { ?>

<div class="secondary-mobile-menu">

	<div class="secondary-mobile-menu-inner">
        <div class="openingbox">
            <a href="/" class="secondary-mobile-menu-link">
                <img width="500" height="200" src="/wp-content/uploads/2019/06/logo-placeholder.png" class="secondary-mobile-menu-custom-logo">
            </a>

            <button class="accordion secondary-mobile-menu-accordion">
                <span class="buttonbox">
                    <span class="material-icons">arrow_drop_down</span>
                </span>
            </button>
           

            <div class="panel secondary-mobile-menu-panel" style="display: none;">
                <div class="secondary-mobile-menu">
                    <div class="secondary-mobile-menu-inner">
                       
                            <?php	wp_nav_menu(
                                array(
                                'menu' => 'Footer Menu 1',
                                )
                            ); ?>
                       
                    </div>
                </div>
            
            </div>


        </div>
	</div>
</div>



<?php

}

add_action('storefront_header', 'print_secondary_mobile_menu_modal_after_storefront_header');
function print_secondary_mobile_menu_modal_after_storefront_header () { ?>


<?php

}

