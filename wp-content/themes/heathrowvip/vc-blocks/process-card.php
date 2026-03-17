<?php
add_action('vc_before_init', 'your_name_process');
function your_name_process()
{
    vc_map(
        array(
            "name" => __("Process Card", "my-text-domain"),
            "base" => "bartag2",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            'admin_enqueue_js' => array(get_template_directory_uri() . '/vc_extend/bartag.js'),
            'admin_enqueue_css' => array(get_template_directory_uri() . '/vc_extend/bartag.css'),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "processtitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Number", "my-text-domain"),
                    "param_name" => "processnumber",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("SubTitle", "my-text-domain"),
                    "param_name" => "processsubtitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", "my-text-domain"),
                    "param_name" => "processdesc",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "processimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")

                )
            )
        )
    );
}

add_shortcode('bartag2', 'bartag_func2');
function bartag_func2($atts, $content = null, $processtitle = null)
{
    extract(shortcode_atts(array(
        'processimage' => 'processimage',
        'processtitle' => 'processtitle',
        'processsubtitle' => 'processsubtitle',
        'processlink' => 'processlink',
        'processnumber' => 'processnumber',
        'processdesc' => 'processdesc'
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($processimage, 'medium');
    
    ob_start(); ?>

    <div class="process-block">
        <?php if ($imageSrc[0]) { ?>
            <div class="process-block-background" style="background: url(<?php echo $imageSrc[0]; ?>);"></div>
        <?php } ?>
        <div class="process-block-text" >
            <div class="row process-row" >
                <?php if ($processnumber) { ?>
                    <div class="col-2 processnocol" >
                        <h3 class="processno"><?php echo $processnumber; ?></h1>
                    </div>
                <?php } ?>
                <div class="col-10 processtitlecol" >
                    <?php if ($processtitle) { ?>
                        <h1 class="processtitle"><?php echo $processtitle; ?></h1>
                    <?php } ?>
                    <?php if ($processsubtitle) { ?>
                        <h2 class="processsubtitle"><?php echo $processsubtitle; ?></h2>
                    <?php } ?>
                </div>
                <?php if ($processdesc) { ?>
                    <p class="process-desc"><?php echo $processdesc; ?></p>
                <?php } ?>

            </div>
        </div>
    </div>

    <?php return ob_get_clean();
}
