<?php
add_action('vc_before_init', 'your_name_linkcardthree');
function your_name_linkcardthree()
{
    vc_map(
        array(
            "name" => __("Link Card Three", "my-text-domain"),
            "base" => "linkcardthree",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "linktitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link", "my-text-domain"),
                    "param_name" => "linklink",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "linkimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                )
            )
        )
    );
}

add_shortcode('linkcardthree', 'linkcardthree_func');
function linkcardthree_func($atts, $content = null, $linktitle = null)
{
    extract(shortcode_atts(array(
        'linkimage' => '',
        'linktitle' => '',
        'linklink' => ''
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($linkimage, 'medium');

ob_start(); ?>

<style>

.link-card--three-image-div {
    position: relative;
    cursor: pointer;
}

.link-card--three-image-div .link-card--three-image-image {
    padding: 0 15px 30px 30px;
    position: relative;
    z-index: 5;
}

.link-card--three-image-div .link-card--three-image-image:before {
    content: '';
    position: absolute;
    top: 30px;
    left: 0;
    right: 45px;
    bottom: 0;
    border: 1px solid #000;
    transition: 0.5s;
}

.link-card--three-image-div:hover .link-card--three-image-image:before {
    border: 4px solid #c9d6ff;
}

.link-card--three-image-div:hover .img:before {
   /* border: 4px solid #c9d6ff;*/
}

.link-card-three img {
    /* border-radius: 20px; */
    overflow: hidden;
}

.link-card--three-title {
    width: 210px !important;
    position: absolute;
    bottom: 0px;
    right: 45px;
    z-index: 3;
    padding: 20px 15px;
    color: #fff;
    text-transform: uppercase;
    font-family: 'Oswald', sans-serif;
    font-weight: 300;
    letter-spacing: 5px;
    font-size: 13px;
    line-height: 1.5em;
    text-align: center;
    background: black;
    z-index: 5;
}

.link-card-three img {
    /*overflow: hidden;*/
}


    </style>


    <a href="<?php echo $linklink; ?>" class="link-card-three">
        <div class="link-card--three-image-div">
            <div class="link-card--three-image-image">
                <img src="<?php echo $imageSrc[0]; ?>">
            </div>
            <div class="link-card--three-title"><?php echo $linktitle; ?></div>
        </div>
    </a>


    <?php return ob_get_clean();
}
