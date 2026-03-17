<?php
add_action('vc_before_init', 'your_name_flowselectorgridtwo');
function your_name_flowselectorgridtwo()
{
	vc_map(

		array(
			"name" => __("Flow Selector Grid Two", "my-text-domain"),
			"base" => "flowselectorgridtwo",
			"class" => "",
			"category" => __("Content", "my-text-domain"),
			"params" => array(
			)
		)
	);
}

add_shortcode('flowselectorgridtwo', 'flowselectorgridtwo_func');
function flowselectorgridtwo_func($atts, $content = null, $servicetitle)
{ 
    ob_start();
    ?>
<h2 class="flow-selector-grid-title-centre">Choose Service Type</h2>



<div class="flow-selector-grid">
    
    

    <input class="form-check-input flow-selector-grid-input" type="radio" name="flexRadioDefault" id="arrival">
    <label class="form-check-label flow-selector-grid-label" for="arrival">

        <div class="link-card-two-grid">
            <div class="link-card-two-background" style="background: url(/wp-content/uploads/2022/09/man-wants-to-open-a-gasoline-tank-2021-08-28-03-45-00-utc.jpg);">
                <div class="link-card-two-arrow-icon">
                    <span class="material-icons">
                        chevron_right
                    </span>
                </div>
            </div>
            <div class="link-card-two-text">
                <h2 class="link-card-two-title">Arrival</h2>
               
            </div>       
        </div>

    </label>


    <input class="form-check-input flow-selector-grid-input" type="radio" name="flexRadioDefault" id="transit">
    <label class="form-check-label flow-selector-grid-label" for="transit">

        <div class="link-card-two-grid">
            <div class="link-card-two-background" style="background: url(/wp-content/uploads/2022/09/HVIP-0101.jpg);">
                <div class="link-card-two-arrow-icon">
                    <span class="material-icons">
                        chevron_right
                    </span>
                </div>
            </div>
            <div class="link-card-two-text">
                <h2 class="link-card-two-title">Transit</h2>
        
            </div>       
        </div>

    </label>

    <input class="form-check-input flow-selector-grid-input" type="radio" name="flexRadioDefault" id="departure">
    <label class="form-check-label flow-selector-grid-label" for="departure">
        
       

        <div class="link-card-two-grid">
            <div class="link-card-two-background" style="background: url(/wp-content/uploads/2022/08/boarding-scaled.jpg);">
                <div class="link-card-two-arrow-icon">
                    <span class="material-icons">
                        chevron_right
                    </span>
                </div>
            </div>
            <div class="link-card-two-text">
                <h2 class="link-card-two-title">Departure</h2>
                
            </div>       
        </div>


    </label>



    <div class="flow-selector-grid-inputs">
        <div class="flow-selector-grid-input-departure">
            <h2 class="flow-selector-grid-title-centre">Choose Departure Service Level:</h2>
            <div class="flow-selector-grid-inputs-grid lusa-css ">
            
                <a class="price-list--one-link" href="/product/heathrow-departure-bronze"> 
                    <div class="price-list--one price-list--one--<?php the_field('bronze_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('bronze_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>
                        <div class="price-list--one-numb"><?php the_field('bronze_name', 'option'); ?></div>  
                        <h5 class="price-list--one-name"><?php the_field('bronze_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('bronze_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('bronze_fine_print', 'option'); ?>
                        </div>
                        
                    </div>
                </a>

                <a class="price-list--one-link" href="/product/heathrow-departure-silver"> 
                    <div class="price-list--one price-list--one--<?php the_field('silver_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('silver_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>  
                        <div class="price-list--one-numb"><?php the_field('silver_name', 'option'); ?></div>
                        <h5 class="price-list--one-name"><?php the_field('silver_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('silver_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('silver_fine_print', 'option'); ?>
                        </div>
                       
                    </div>
                </a>

                <a class="price-list--one-link" href="/product/heathrow-departure-gold"> 
                    <div class="price-list--one price-list--one--<?php the_field('gold_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('gold_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>  
                        <div class="price-list--one-numb"><?php the_field('gold_name', 'option'); ?></div>
                        <h5 class="price-list--one-name"><?php the_field('gold_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('gold_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('gold_fine_print', 'option'); ?>
                        </div>
                        
                    </div>
                </a>

                <a class="price-list--one-link" href="/product/heathrow-departure-vip-lounge"> 
                    <div class="price-list--one price-list--one--<?php the_field('tarmac_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('tarmac_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>  
                        <div class="price-list--one-numb"><?php the_field('tarmac_name', 'option'); ?></div>
                        <h5 class="price-list--one-name"><?php the_field('tarmac_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('tarmac_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('tarmac_fine_print', 'option'); ?>
                        </div>
                       
                    </div>
                </a>

            </div>
        </div>

        <div class="flow-selector-grid-input-arrival"> 
            <h2 class="flow-selector-grid-title-centre">Choose Arrival Service Level:</h2>
            <div class="flow-selector-grid-inputs-grid lusa-css">
            
                <a class="price-list--one-link" href="/product/heathrow-arrival-bronze"> 
                    <div class="price-list--one price-list--one--<?php the_field('bronze_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('bronze_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>  
                        <div class="price-list--one-numb"><?php the_field('bronze_name', 'option'); ?></div>
                        <h5 class="price-list--one-name"><?php the_field('bronze_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('bronze_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('bronze_fine_print', 'option'); ?>
                        </div>
                        
                    </div>
                </a>

                <a class="price-list--one-link" href="/product/heathrow-arrival-silver"> 
                    <div class="price-list--one price-list--one--<?php the_field('silver_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('silver_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>  
                        <div class="price-list--one-numb"><?php the_field('silver_name', 'option'); ?></div>
                        <h5 class="price-list--one-name"><?php the_field('silver_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('silver_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('silver_fine_print', 'option'); ?>
                        </div>
                       
                    </div>
                </a>

                <a class="price-list--one-link" href="/product/heathrow-arrival-gold"> 
                    <div class="price-list--one price-list--one--<?php the_field('gold_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('gold_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>  
                        <div class="price-list--one-numb"><?php the_field('gold_name', 'option'); ?></div>
                        <h5 class="price-list--one-name"><?php the_field('gold_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('gold_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('gold_fine_print', 'option'); ?>
                        </div>
                        
                    </div>
                </a>

                <a class="price-list--one-link" href="/product/heathrow-arrival-vip-lounge"> 
                    <div class="price-list--one price-list--one--<?php the_field('tarmac_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('tarmac_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>  
                        <div class="price-list--one-numb"><?php the_field('tarmac_name', 'option'); ?></div>
                        <h5 class="price-list--one-name"><?php the_field('tarmac_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('tarmac_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('tarmac_fine_print', 'option'); ?>
                        </div>
                        
                    </div>
                </a>

            </div>
        </div>

        <div class="flow-selector-grid-input-transit">
            <h2 class="flow-selector-grid-title-centre">Choose Transit Service Level:</h2>
            <div class="flow-selector-grid-inputs-grid lusa-css">
            
                <a class="price-list--one-link" href="/product/heathrow-transit-bronze"> 
                    <div class="price-list--one price-list--one--<?php the_field('bronze_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('bronze_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>  
                        <div class="price-list--one-numb"><?php the_field('bronze_name', 'option'); ?></div>
                        <h5 class="price-list--one-name"><?php the_field('bronze_transit_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('bronze_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('bronze_fine_print', 'option'); ?>
                        </div>
                       
                    </div>
                </a>

                <a class="price-list--one-link" href="/product/heathrow-transit-silver"> 
                    <div class="price-list--one price-list--one--<?php the_field('silver_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('silver_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>  
                        <div class="price-list--one-numb"><?php the_field('silver_name', 'option'); ?></div>
                        <h5 class="price-list--one-name"><?php the_field('silver_transit_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('silver_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('silver_fine_print', 'option'); ?>
                        </div>
                        
                    </div>
                </a>

                <a class="price-list--one-link" href="/product/heathrow-transit-gold"> 
                    <div class="price-list--one price-list--one--<?php the_field('gold_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('gold_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>  
                        <div class="price-list--one-numb"><?php the_field('gold_name', 'option'); ?></div>
                        <h5 class="price-list--one-name"><?php the_field('gold_transit_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('gold_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('gold_fine_print', 'option'); ?>
                        </div>
                        
                    </div>
                </a>

                <a class="price-list--one-link" href="/product/heathrow-transit-vip-lounge"> 
                    <div class="price-list--one price-list--one--<?php the_field('tarmac_name', 'option'); ?>">               
                        <img src="<?php $image_id = get_field('tarmac_image', 'option'); echo wp_get_attachment_image_url ($image_id, 'thumbnail'); ?>" alt="">
                        <div class="material-icon"><span class="material-icons">verified</span></div>  
                        <div class="price-list--one-numb"><?php the_field('tarmac_name', 'option'); ?></div>
                        <h5 class="price-list--one-name"><?php the_field('tarmac_transit_title', 'option'); ?></h5>
                        <div class="price-list--one-expanding-hover-line"></div>
                        <div class="price-list--one-description">
                            <?php the_field('tarmac_wysiwyg', 'option'); ?>
                        </div>
                        <div class="price-list--one-small-print">
                            <?php the_field('tarmac_fine_print', 'option'); ?>
                        </div>
                        
                    </div>
                </a>

            </div>
        </div>
    </div>
</div>












    <?php 
    
    return ob_get_clean();
}