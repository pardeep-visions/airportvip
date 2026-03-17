<?php 

add_action('storefront_before_footer', 'print_custom_footer_before_storefront_footer', 10);
function print_custom_footer_before_storefront_footer () { ?>

<div class="col-full">
    <div class="custom-footer">
        <h2>Accreditations</h2>
        <div class="custom-footer-grid">

            <?php $images = get_field('accreditations', 'option'); ?> 
            <?php if ($images) : ?> 
                <div class="client-logo-grid">
                    <?php foreach ($images as $image) : ?>
                        <div class="client-logo-grid-item" >
                            <img src="<?php echo $image['sizes']['medium']; ?>">
                        </div>
                    <?php endforeach; ?> 
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php

}