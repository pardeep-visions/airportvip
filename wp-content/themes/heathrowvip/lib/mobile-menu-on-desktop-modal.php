<?php 

add_action('storefront_header', 'print_desktopmenu_modal_buttons_after_storefront_header');
function print_desktopmenu_modal_buttons_after_storefront_header () { ?>

<!-- Large modal -->
<button type="button" class="open-deskop-mobile-menu-button" data-toggle="modal" data-target=".open-deskop-mobile-menu-modal"><span class="material-icons">menu</span></button>

<div class="modal fade open-deskop-mobile-menu-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg deskop-mobile-menu-modal">
    <div class="modal-content deskop-mobile-menu-modal-content">
		
		<div class="desktop-mobile-top-section">
			<div class="row">
				<div class="col-4 deskop-mobile-menu-social-side">
					<span class="social-title">Socials</span>
					<ul class="deskop-mobile-menu-social-ul">
						<li>
							<a href="#" class="deskop-mobile-menu-social-side-link">
								Instagram
							</a>
							
						</li>
						<li>
							<a href="#" class="deskop-mobile-menu-social-side-link">
								Facebook
							</a>
						</li>
						<li>
							<a href="#" class="deskop-mobile-menu-social-side-link">
								LinkedIn
							</a>
						</li>
					</ul>
				</div>
				<div class="col-4">
					<a href="/" class="deskop-mobile-menu-logo-link">
						<img src="/wp-content/uploads/2019/06/logo-placeholder.png">
					</a>
				</div>
				<div class="col-4 deskop-mobile-menu-close-container">
					<button type="button" class="close deskop-mobile-menu-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
			</div>
		</div>

		<div class="row desktop-mobile-middle-section">
			<div class="col-12">
				<ul class="deskop-mobile-menu-ul">
					<li class="deskop-mobile-menu-item-li deskop-mobile-menu-item-li-1">
						<a href="#" class="deskop-mobile-menu-item deskop-mobile-menu-item-1">
							WORK
						</a>
						<img src="/wp-content/uploads/2021/01/photodune-egv2EyZy-creative-office-interior-xl.jpg" class="deskop-mobile-menu-item-image-left deskop-mobile-menu-item-1">
						<img src="/wp-content/uploads/2021/01/photodune-niGzbqeW-detail-of-sustainable-academy-building-instagram-toning-xl.jpg" class="deskop-mobile-menu-item-image-right deskop-mobile-menu-item-1">
					</li>
					<li class="deskop-mobile-menu-item-li deskop-mobile-menu-item-li-2">
						<a href="#" class="deskop-mobile-menu-item deskop-mobile-menu-item-2">
							ABOUT
						</a>
						<img src="/wp-content/uploads/2021/01/photodune-AjAM9gbp-modern-office-interior-xxl.jpg" class="deskop-mobile-menu-item-image-left deskop-mobile-menu-item-2">
						<img src="/wp-content/uploads/2021/01/photodune-egv2EyZy-creative-office-interior-xl.jpg" class="deskop-mobile-menu-item-image-right deskop-mobile-menu-item-2">
					</li>
					<li class="deskop-mobile-menu-item-li deskop-mobile-menu-item-li-3">
						<a href="#" class="deskop-mobile-menu-item deskop-mobile-menu-item-3">
							CONTACT
						</a>
						<img src="/wp-content/uploads/2021/01/photodune-2cinDoin-abstract-architectural-structure-m.jpg" class="deskop-mobile-menu-item-image-background deskop-mobile-menu-item-3">
					</li>
				</ul>
			</div>
		</div>
    </div>
  </div>
</div>




<?php

}



add_action('storefront_header', 'print_desktopmenu_modal_after_storefront_header');
function print_desktopmenu_modal_after_storefront_header () { ?>




<?php

}

