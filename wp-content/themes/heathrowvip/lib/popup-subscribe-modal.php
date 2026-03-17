<?php

add_action('storefront_header', 'print_popup_subscribe_modal_after_storefront_header');
function print_popup_subscribe_modal_after_storefront_header()
{ ?>

	<div class="cart-side-modal">
		<div class="cart-side-modal-inner">

			<button type="button" class="btn btn-demo" data-toggle="modal" data-target="#popupsubscribemodal">
				Subscribe Modal
			</button>

		</div>
	</div>



	<div class="container demo">
		<!-- Modal -->
		<div class="modal subscribe-modal fade" id="popupsubscribemodal" tabindex="-1" role="dialog" aria-labelledby="popupsubscribemodalLabel">
			<div class="modal-dialog subscribe-modal-dialog" role="document">
				<div class="modal-content subscribe-modal-content">

					<!--<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="popupsubscribemodalLabel">Your Basket</h4>
				</div>-->

					<div class="modal-body subscribe-modal-body">

						<button type="button" class="close close-subscribe-modal-button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>

						<div class="popup-subscribe-modal">
							<div class="popup-subscribe-modal-image">

							</div>
							<div class="popup-subscribe-modal-text">
								<h1 class="popup-subscribe-title">Subscribe for updates</h1>
								<p class="popup-subscribe-p">Sign up with your email address to recieve news and updates straight to your inbox.</p>

								<div class="popup-subscribe-modal-mailchimp">
									<!-- Begin Mailchimp Signup Form -->
									<link href="//cdn-images.mailchimp.com/embedcode/slim-10_7.css" rel="stylesheet" type="text/css">
									<style type="text/css">
										#mc_embed_signup {
											background: #fff;
											clear: left;
											font: 14px Helvetica, Arial, sans-serif;
										}

										/* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
									We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
									</style>
									<div id="mc_embed_signup">
										<form action="https://squaresocket.us7.list-manage.com/subscribe/post?u=08fc01a537bd1c8449c7fc203&amp;id=ac654f22f9" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
											<div id="mc_embed_signup_scroll">

												<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
												<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
												<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_08fc01a537bd1c8449c7fc203_ac654f22f9" tabindex="-1" value=""></div>
												<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
											</div>
										</form>
									</div>

									<!--End mc_embed_signup-->

								</div>
							</div>
						</div>
					</div>
				</div><!-- modal-content -->
			</div><!-- modal-dialog -->
		</div><!-- modal -->
	</div>


	<script>
		function getCookie(name) {
			var match = document.cookie.match(RegExp('(?:^|;\\s*)' + name + '=([^;]*)'));
			return match ? match[1] : null;
		}

		//Open subscipe modal if not dismissed in last 24h
		jQuery(document).ready(function() {

			var milliseconds_in_a_day = 24 * 3600 * 1000;
			var milliseconds_in_10_seconds = 1000 * 10;

			//Time til popup appears again
			var dismisalTimeout = milliseconds_in_a_day;
			//Timer til popup appears
			var appearTimer = milliseconds_in_10_seconds

			//Fetch popup cookie that holds dismissed timestamp
			var cookie = getCookie('popup_dismissed');

			//If cookie not set, show modal
			if (!cookie) {
				jQuery('.subscribe-modal').addClass('open');
				console.log('Show modal (not dismissed)');
				open_subscibe_modal(appearTimer);

				//If cookie > 24 hours old show
			} else {
				var timeDiff = Date.now() - cookie;

				//Debug
				console.log('Cookie time: ' + cookie);
				console.log('Current time: ' + Date.now());
				console.log('Time diff (ms) :' + timeDiff);
				console.log('Time diff (s) :' + Math.floor(timeDiff / 1000));


				if ((Date.now() - cookie) > dismisalTimeout) {
					console.log('Show modal (timer expired)');
					open_subscibe_modal(appearTimer);
				} else {
					console.log('Do not show modal (dismissed in last 24h)');
				}
			}

			//Close popup and save timestamp
			jQuery('.subscribe-modal.fade').click(function() {
				console.log('close')
				document.cookie = "popup_dismissed=" + Date.now();
			});

		});

		function open_subscibe_modal(appearTimer) {
			setTimeout(function() {

				jQuery('[data-target="#popupsubscribemodal"]').trigger('click');
			}, parseInt(appearTimer));

		}
	</script>



<?php

}
