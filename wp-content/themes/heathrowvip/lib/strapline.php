<?php 

add_action('storefront_header', 'print_something_after_storefront_header');
function print_something_after_storefront_header () { ?>

<div class="strapline">
	<div class="strapline-inner">
		Strapline goes here
	</div>
</div>

<?php

}