<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use YayMail\Page\Source\CustomPostType;
$postID                 = CustomPostType::postIDByTemplate( $this->template );
$emailTextLinkColor     = get_post_meta( $postID, '_yaymail_email_textLinkColor_settings', true ) ? get_post_meta( $postID, '_yaymail_email_textLinkColor_settings', true ) : '#7f54b3';
$borderColor            = isset( $atts['bordercolor'] ) && $atts['bordercolor'] ? 'border-color:' . html_entity_decode( $atts['bordercolor'], ENT_QUOTES, 'UTF-8' ) : 'border-color:inherit';
$textColor              = isset( $atts['textcolor'] ) && $atts['textcolor'] ? 'color:' . html_entity_decode( $atts['textcolor'], ENT_QUOTES, 'UTF-8' ) : 'color:inherit';
$fontFamily             = isset( $atts['fontfamily'] ) && $atts['fontfamily'] ? 'font-family:' . html_entity_decode( $atts['fontfamily'], ENT_QUOTES, 'UTF-8' ) : 'font-family:inherit';
$tracking_page_settings = \ParcelPanel\Models\TrackingSettings::instance()->get_settings();
$DISPLAY_OPTION         = $tracking_page_settings['display_option'];
$TRANSLATIONS           = $tracking_page_settings['tracking_page_translations'];

$SHOW_CARRIER_DETAILS = $DISPLAY_OPTION['carrier_details'];
$SHOW_TRACKING_NUMBER = $DISPLAY_OPTION['tracking_number'];

// $TEXT_TRACK_YOUR_ORDER = esc_html( $TRANSLATIONS[ 'track_your_order' ] );
$TEXT_TRACK_YOUR_ORDER = parcelpanel_text_track_your_order();
$TEXT_ORDER_NUMBER     = $TRANSLATIONS['order_number'];
$TEXT_TRACKING_NUMBER  = $TRANSLATIONS['tracking_number'];
$TEXT_CARRIER          = $TRANSLATIONS['carrier'];
$TEXT_STATUS           = $TRANSLATIONS['status'];
$TEXT_TRACK            = $TRANSLATIONS['track'];
?>
<table class="yaymail_builder_table_items_border yaymail_builder_table_tracking_item" cellspacing="0" cellpadding="6" border="1" style="margin-top:10px;width: 100% !important;<?php echo esc_attr( $borderColor ); ?>" width="100%">

	<thead>
		<tr style="<?php echo esc_attr( $textColor ); ?>">
			<th class="td" scope="col" class="td" style="text-align: left;<?php echo esc_attr( $borderColor ); ?>;<?php echo esc_attr( $fontFamily ); ?>"><?php esc_html_e( $TEXT_ORDER_NUMBER, 'yaymail' ); ?></th>
			<?php if ( $SHOW_TRACKING_NUMBER ) { ?>
			<th class="td" scope="col" class="td" style="text-align: left;<?php echo esc_attr( $borderColor ); ?>;<?php echo esc_attr( $fontFamily ); ?>"><?php esc_html_e( $TEXT_TRACKING_NUMBER, 'yaymail' ); ?></th>
			<?php } ?>
			<?php if ( $SHOW_CARRIER_DETAILS ) { ?>
			<th class="td" scope="col" class="td" style="text-align: left;<?php echo esc_attr( $borderColor ); ?>;<?php echo esc_attr( $fontFamily ); ?>"><?php esc_html_e( $TEXT_CARRIER, 'yaymail' ); ?></th>
			<?php } ?>
			<th class="td" scope="col" class="td" style="text-align: left;<?php echo esc_attr( $borderColor ); ?>;<?php echo esc_attr( $fontFamily ); ?>"><?php esc_html_e( $TEXT_STATUS, 'yaymail' ); ?></th>
			<th class="td" scope="col" class="td" style="text-align: left;<?php echo esc_attr( $borderColor ); ?>;<?php echo esc_attr( $fontFamily ); ?>">&nbsp;</th>
		</tr>
	</thead>

	<tbody style="">
			<tr class="tracking" style="<?php echo esc_attr( $textColor ); ?>">

				<td class="td" data-title="<?php esc_html_e( 'Order Number', 'yaymail' ); ?>" style="text-align: left; padding: 12px;<?php echo esc_attr( $borderColor ); ?>;<?php echo esc_attr( $fontFamily ); ?>">
					<a style="color: <?php echo esc_attr( $emailTextLinkColor ); ?>" href="#" target="_blank"><?php esc_html_e( '#1', 'yaymail' ); ?></a>
				</td>
				<?php if ( $SHOW_TRACKING_NUMBER ) { ?>
				<td class="td" data-title="<?php esc_html_e( 'Tracking Number', 'yaymail' ); ?>" style="text-align: left; padding: 12px;<?php echo esc_attr( $borderColor ); ?>;<?php echo esc_attr( $fontFamily ); ?>">
					<?php esc_html_e( 'yaymail', 'yaymail' ); ?>
				</td>
				<?php } ?>
				<?php if ( $SHOW_CARRIER_DETAILS ) { ?>
				<td class="td" data-title="<?php esc_html_e( 'Carrier', 'yaymail' ); ?>" style="text-align: left; padding: 12px;;<?php echo esc_attr( $borderColor ); ?>;<?php echo esc_attr( $fontFamily ); ?>">&nbsp;</td>
				<?php } ?>
				<td class="td" data-title="<?php esc_html_e( 'Status', 'yaymail' ); ?>" style="text-align: left; padding: 12px;<?php echo esc_attr( $borderColor ); ?>;<?php echo esc_attr( $fontFamily ); ?>">
					<?php esc_html_e( 'yaymail', 'yaymail' ); ?>
				</td>
				<td class="td" style="text-align: center; padding: 12px;<?php echo esc_attr( $borderColor ); ?>;<?php echo esc_attr( $fontFamily ); ?>">
					<a style="color: <?php echo esc_attr( $emailTextLinkColor ); ?>" href="#" target="_blank"><?php esc_html_e( 'Track', 'yaymail' ); ?></a>
				</td>
			</tr>
	</tbody>
</table>
