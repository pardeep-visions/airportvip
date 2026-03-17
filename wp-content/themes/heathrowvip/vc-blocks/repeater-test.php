<?php
add_action('vc_before_init', 'box_repeater_items_funct2');

function box_repeater_items_funct2()
{
    vc_map(
        array(
            "name" => __("Box Repeater", "my-text-domain"), // Element name
            "base" => "box_repeater", // Element shortcode
            "class" => "box-repeater",
            "category" => __('Content', 'my-text-domain'),
            'params' => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "admin_label" => true,
                    "heading" => __("Headig", "my-text-domain"),
                    "param_name" => "box_repeater_heading",
                    "value" => __("", "my-text-domain"),
                    "description" => __('Add heading here', "my-text-domain")
                ),
                array(
                    'type' => 'param_group',
                    'param_name' => 'box_repeater_items',
                    'params' => array(
                        array(
                            "type" => "attach_image",
                            "holder" => "img",
                            "class" => "",
                            "heading" => __("Image", "my-text-domain"),
                            "param_name" => "box_repeater_items_img",
                            "value" => __("", "my-text-domain"),
                        ),
                        array(
                            "type" => "textarea",
                            "holder" => "div",
                            "class" => "",
                            "admin_label" => true,
                            "heading" => __("Title", "my-text-domain"),
                            "param_name" => "box_repeater_items_title",
                            "value" => __("", "my-text-domain"),
                        ),
                        array(
                            "type" => "textarea",
                            "class" => "",
                            "admin_label" => true,
                            "heading" => __("Description", "my-text-domain"),
                            "param_name" => "box_repeater_items_description",
                            "value" => __("", "my-text-domain"),
                        ),
                    )
                ),
            )
        )
    );
}


add_shortcode('box_repeater', 'box_repeater_funct');
function box_repeater_funct($atts)
{
    ob_start();

    $atts = shortcode_atts(array(
        'box_repeater_heading' => '',
        'box_repeater_items' => '',
    ), $atts, 'box_repeater');

    $heading = $atts['box_repeater_heading'];
    
    $items = vc_param_group_parse_atts($atts['box_repeater_items']); 

    ?>

    <div class="box-repeater">

        <?php echo (!empty($heading)) ? '<h2>' . $heading . '<h2>' : ''; ?>

        <?php if($items): ?>

            <div class="box-repeater-items">

                <?php foreach ($items as  $item) : ?>

                    <div class="item-box">
                        <?php echo wp_get_attachment_image($item['box_repeater_items_img'], 'full'); ?>
                        <div class="info-box">
                            <h2><?php echo $item['box_repeater_items_title']; ?></h2>
                            <p><?php echo $item['box_repeater_items_description']; ?></p>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

    <?php return ob_get_clean();
}
