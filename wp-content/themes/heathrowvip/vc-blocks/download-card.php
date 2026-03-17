<?php
add_action('vc_before_init', 'downloadcard_integrateWithVC');
function downloadcard_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Download Card", "my-text-domain"),
            "base" => "downloadcard",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "servicetitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", "my-text-domain"),
                    "param_name" => "servicedesc",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __( 'Attach File', 'wpbe' ),
                    'param_name' => 'file_picker',
                    'value' => '',
                    'description' => __('Upload file', 'wpbe'),
                ),
            )
        )
    );
}

add_shortcode('downloadcard', 'downloadcard_func');
function downloadcard_func($atts, $content = null, $servicetitle)
{
    extract(shortcode_atts(array(
        'servicetitle' => '',
        'file_picker' => '',
        'servicedesc' => ''
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    $url = wp_get_attachment_url( $file_picker );
    $filetitle = get_the_title( $file_picker );
    $date = get_the_date('M d, Y', $file_picker);
    $filesize = filesize( get_attached_file( $file_picker ) );
    $filesizeoutput = size_format($filesize, 0);

    ob_start(); ?>
      
    <div class="download-card"> 
        <div class="download-card-content">
            <div class="download-card-meta">
                <p><span class="download-card-meta-desc"><span class="material-icons">description</span> (<?php echo $filesizeoutput; ?>)</span> <span class="download-card-meta-date"><span class="material-icons">date_range</span> <?php echo $date; ?></span></p>
            </div>
            <div class="download-card-content-text">
                <?php if ($servicetitle) { ?>
                    <h2 class="download-card-title"><?php echo $servicetitle; ?></h1>
                <?php } ?>
                <?php if ($servicedesc) { ?>
                    <p class="download-card-desc"><?php echo $servicedesc; ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="download-card-button">
            <a class="button download-card-button" href="<?php echo $url; ?>" download>Download</a>
        </div>
    </div>

    <?php return ob_get_clean();
}
