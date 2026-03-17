<?php
add_action('vc_before_init', 'coolsectionheathrow_integrateWithVC');
function coolsectionheathrow_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Display Block heathrow", "my-text-domain"),
            "base" => "displayblockheathrow",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(

                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Content", "my-text-domain"),
                    "param_name" => "content",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write content here.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Background Image", "my-text-domain"),
                    "param_name" => "imageone",
                    "value" => "",
                    "description" => __("Choose background image.", "my-text-domain")
                ),

            )
        )
    );
}

add_shortcode('displayblockheathrow', 'displayblockheathrow_func');
function displayblockheathrow_func($atts, $content)
{

    extract(shortcode_atts(array(
        'imageone' => 'imageone',

    ), $atts));

    $imageoneSRC = wp_get_attachment_image_src($imageone, 'hd');
    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>











    <div class="display-block-heathrow fadebackground" style="background: url(<?php echo $imageoneSRC[0]; ?>)">
        <!--<img class="display-block-heathrow-mobile-image" src="<?php echo $imageoneSRC[0]; ?>">-->
        <div class="display-block-heathrow-inner">
            <div class="display-block-heathrow-booking-form">

<!--
<span class="material-icons">
flight_land
</span>

<span class="material-icons">
event_seat
</span>

<span class="material-icons">
groups
</span>

<span class="material-icons">
handshake
</span>

<span class="material-icons">
waving_hand
</span>

<span class="material-icons">
luggage
</span>

<span class="material-icons">
weekend
</span>

<span class="material-icons">
directions_car
</span>

<span class="material-icons">
local_airport
</span>

<span class="material-icons">
connecting_airports
</span>

<span class="material-icons">
airline_seat_recline_normal
</span>

<span class="material-icons">
airline_seat_recline_extra
</span>

-->

















                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"><span class="material-icons">flight_land</span> Meet & Greet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"> <span class="material-icons">airline_seat_recline_extra</span> VIP Lounge</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"><span class="material-icons">directions_car</span> Chauffeur Services</a>
                    </li>
                </ul><!-- Tab panes -->

                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel tab-panel-7-11">
                        <?php echo do_shortcode('[vip-booking-form]'); ?>	
                    </div>

                    <div class="tab-pane" id="tabs-2" role="tabpanel ">
                                                 
                        <h4>Services</h4>
                        <h1>VIP Lounge</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <p><a href="/vip-lounge-enquiries" class="button">Find out more</a></p>
                        
                    </div>	

                    <div class="tab-pane" id="tabs-3" role="tabpanel ">
                        
                        <h4>Services</h4>
                        <h1>Chauffeur Services</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <p><a href="/chauffer-enquiries" class="button">Find out more</a></p>
                        
                    </div>	
                </div>	


            
            </div>
            <div class="display-block-heathrow-text">
                <?php echo $content; ?>

            </div>
        </div>
    </div>

<?php return ob_get_clean();
}
