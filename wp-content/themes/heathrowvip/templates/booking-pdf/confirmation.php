<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$order = $ctx['order'];
$logo  = 'https://www.airportvipservices.co.uk/wp-content/uploads/2022/07/Logo2.jpg';
$passengers = $ctx['passenger_names'] ?? [];
$requests = $ctx['special_requests'] ?? [];
$reservation_rows = $ctx['reservation_rows'] ?? [];
$journey_rows = $ctx['journey_rows'] ?? [];
$booking_rows = $ctx['booking_rows'] ?? [];
$show_greeter   = ! empty( $ctx['show_greeter'] );
$show_chauffeur = ! empty( $ctx['show_chauffeur'] );
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <style>
    body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color:#111; font-size: 11px; }
    .page { padding: 10px 20px; }
    .header { text-align:center; margin-bottom: 14px; }
    .header img { max-width: 190px; height: auto; }
    h2 { font-size: 24px; margin: 14px 0 8px; font-weight: 700; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #333; padding: 7px; vertical-align: top; }
    th { background: #fff; text-align:left; font-weight: 700; }
    .muted { color:#666; font-size: 11px; }
    .section { margin-top: 14px; }
    .two-col { width: 100%; }
    .left-col { width: 72%; display: inline-block; vertical-align: top; }
    .right-col { width: 26%; display: inline-block; vertical-align: top; margin-left: 2%; font-size: 11px; }
    .terms { border: 1px solid #333; padding: 12px; min-height: 180px; color: #666; font-size: 10px; line-height: 1.5; }
    .footer-bar { border: 1px solid #333; margin-top: 10px; font-size: 10px; color: #666; padding: 6px 8px; }
    .payments { text-align:center; margin: 12px 0; color:#666; font-size: 10px; }
    .plain-list { margin: 0; padding-left: 16px; }
    .simple-box { border:1px solid #ddd; background:#fafafa; padding:10px; margin-top:10px; }
    .order-detail-list { margin: 0; padding-left: 14px; }
    .journey-table { table-layout: fixed; }
    .journey-table col.to-col { width: 30%; }
  </style>
</head>
<body>
  <div class="page">
    <div class="header">
      <img src="<?php echo esc_url( $logo ); ?>" alt="Airport VIP" />
      <div class="muted">Booking Confirmation</div>
    </div>

    <div class="two-col section">
      <div class="left-col">
        <h2>Reservations &amp; Contacts</h2>
        <table>
          <tr><th>Service Type</th><th>Start Date</th><th>End Date</th><th>Start Time</th><th>End Time</th><th>Reservation</th></tr>
          <?php if ( ! empty( $reservation_rows ) ) : ?>
            <?php foreach ( $reservation_rows as $rrow ) : ?>
              <tr>
                <td><?php echo esc_html( (string) ( $rrow['service_type'] ?? '—' ) ?: '—' ); ?></td>
                <td><?php echo esc_html( (string) ( $rrow['service_date'] ?? '—' ) ?: '—' ); ?></td>
                <td><?php echo esc_html( (string) ( $rrow['service_end_date'] ?? '—' ) ?: '—' ); ?></td>
                <td><?php echo esc_html( (string) ( $rrow['service_time'] ?? '—' ) ?: '—' ); ?></td>
                <td><?php echo esc_html( (string) ( $rrow['service_end_time'] ?? '—' ) ?: '—' ); ?></td>
                <td><?php echo esc_html( (string) ( $rrow['reservation'] ?? ( '#' . (string) $ctx['order_number'] ) ) ); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td><?php echo esc_html( (string) ( $ctx['service_type'] ?: '—' ) ); ?></td>
              <td><?php echo esc_html( (string) ( $ctx['service_date'] ?: '—' ) ); ?></td>
              <td><?php echo esc_html( (string) ( $ctx['service_end_date'] ?: ( $ctx['service_date'] ?: '—' ) ) ); ?></td>
              <td><?php echo esc_html( (string) ( $ctx['service_time'] ?: '—' ) ); ?></td>
              <td><?php echo esc_html( (string) ( $ctx['service_end_time'] ?: '—' ) ); ?></td>
              <td>#<?php echo esc_html( (string) $ctx['order_number'] ); ?></td>
            </tr>
          <?php endif; ?>
        </table>
      </div>
      <!-- <div class="right-col">
        <p><strong>Phone:</strong> <?php //echo esc_html( (string) ( $ctx['company_phone'] ?? '' ) ); ?></p>
        <p><strong>Email:</strong> <?php //echo esc_html( (string) ( $ctx['company_email'] ?? '' ) ); ?></p>
        <p><strong>Address:</strong> <?php //echo esc_html( (string) ( $ctx['company_address'] ?? '' ) ); ?></p>
      </div> -->
    </div>

    <div class="section">
      <h2>Order Summary</h2>
      <table>
        <tr><th style="width:34%;">Order Number</th><td>#<?php echo esc_html( (string) ( $ctx['order_number'] ?? '—' ) ); ?></td></tr>
        <tr><th>Date</th><td><?php echo esc_html( (string) ( $ctx['order_date_plain'] ?? '—' ) ); ?></td></tr>
        <tr><th>Email</th><td><?php echo esc_html( (string) ( $ctx['order_email'] ?? '—' ) ); ?></td></tr>
        <tr><th>Total</th><td><?php echo wp_kses_post( (string) ( $ctx['order_total'] ?? '—' ) ); ?></td></tr>
        <tr><th>Payment Method</th><td><?php echo esc_html( (string) ( $ctx['order_payment_method'] ?? '—' ) ); ?></td></tr>
      </table>
    </div>

    <div class="section">
      <h2>Journey information</h2>
      <table class="journey-table">
        <colgroup>
          <col />
          <col />
          <col />
          <col />
          <col />
          <col class="to-col" />
          <col />
          <col />
        </colgroup>
        <tr><th>Name</th><th>Number of Passengers</th><th>Number of Bags</th><th>Date</th><th>From</th><th>To</th><th>Start Time</th><th>End Time</th></tr>
        <?php if ( ! empty( $journey_rows ) ) : ?>
          <?php foreach ( $journey_rows as $row ) : ?>
            <tr>
              <td><?php echo esc_html( (string) ( $row['name'] ?? '—' ) ?: '—' ); ?></td>
              <td><?php echo esc_html( (string) ( $row['passenger_count'] ?? '—' ) ?: '—' ); ?></td>
              <td><?php echo esc_html( (string) ( $row['bags'] ?? '—' ) ?: '—' ); ?></td>
              <td><?php echo esc_html( (string) ( $row['journey_date'] ?? '—' ) ?: '—' ); ?></td>
              <td><?php echo esc_html( (string) ( $row['journey_from'] ?? '—' ) ?: '—' ); ?></td>
              <td><?php echo esc_html( (string) ( $row['journey_to'] ?? '—' ) ?: '—' ); ?></td>
              <td><?php echo esc_html( (string) ( $row['start_time'] ?? '—' ) ?: '—' ); ?></td>
              <td><?php echo esc_html( (string) ( $row['end_time'] ?? '—' ) ?: '—' ); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td><?php echo esc_html( (string) ( $ctx['passenger_names'][0] ?? '—' ) ); ?></td>
            <td><?php echo esc_html( (string) ( $ctx['passenger_count'] ?? '—' ) ); ?></td>
            <td><?php echo esc_html( (string) ( $ctx['bags'] ?: '—' ) ); ?></td>
            <td><?php echo esc_html( (string) ( $ctx['journey_date'] ?? ( $ctx['flight_date'] ?: '—' ) ) ); ?></td>
            <td><?php echo esc_html( (string) ( $ctx['journey_from'] ?? '' ) !== '' ? (string) $ctx['journey_from'] : '—' ); ?></td>
            <td><?php echo esc_html( (string) ( $ctx['journey_to'] ?? '' ) !== '' ? (string) $ctx['journey_to'] : '—' ); ?></td>
            <td><?php echo esc_html( (string) ( $ctx['service_time'] ?: ( $ctx['flight_time'] ?: '—' ) ) ); ?></td>
            <td><?php echo esc_html( (string) ( $ctx['service_end_time'] ?: '—' ) ); ?></td>
          </tr>
        <?php endif; ?>
      </table>
    </div>

    <div class="section">
      <h2>Order details</h2>
      <table>
        <tr><th>Product</th><th style="width:25%;">Total</th></tr>
        <?php $items_full = $ctx['order_items_full'] ?? []; ?>
        <?php $hide_order_totals = ! empty( $ctx['hide_order_totals'] ); ?>
        <?php if ( ! empty( $items_full ) ) : foreach ( $items_full as $item_row ) : ?>
          <tr>
            <td><strong><?php echo esc_html( (string) $item_row['product_name'] ); ?> × <?php echo esc_html( (string) $item_row['quantity'] ); ?></strong>
              <?php if ( ! empty( $item_row['meta'] ) ) : ?><ul class="order-detail-list"><?php foreach ( $item_row['meta'] as $mrow ) : ?><li><strong><?php echo esc_html( (string) $mrow['key'] ); ?>:</strong> <?php echo esc_html( (string) $mrow['value'] ); ?></li><?php endforeach; ?></ul><?php endif; ?>
            </td>
            <td><?php echo wp_kses_post( (string) ( $item_row['line_total'] ?? '—' ) ); ?></td>
          </tr>
        <?php endforeach; else : ?>
          <tr><td>—</td><td>—</td></tr>
        <?php endif; ?>
        <?php if ( ! $hide_order_totals ) : ?>
          <tr><th>Subtotal</th><td><?php echo wp_kses_post( (string) ( $ctx['order_subtotal'] ?? '—' ) ); ?></td></tr>
          <tr><th>VAT</th><td><?php echo wp_kses_post( (string) ( $ctx['order_tax'] ?? '—' ) ); ?></td></tr>
          <tr><th>Total</th><td><?php echo wp_kses_post( (string) ( $ctx['order_total'] ?? '—' ) ); ?></td></tr>
        <?php endif; ?>
      </table>
      <div class="simple-box"><strong>Billing address</strong><br/><?php foreach ( ( $ctx['billing_address_lines'] ?? [] ) as $line ) { echo esc_html( (string) $line ) . '<br/>'; } ?></div>
    </div>

    <!-- <div class="section">
      <h2>Booking</h2>
      <?php //if ( ! empty( $booking_rows ) ) : ?>
        <?php //foreach ( $booking_rows as $booking_row ) : ?>
          <div class="simple-box">
            <strong><?php //echo esc_html( (string) ( $booking_row['booking_number'] ?? '' ) ?: '—' ); ?></strong><br/>
            <?php //echo esc_html( (string) ( $booking_row['booking_datetime'] ?? '' ) ?: '—' ); ?><br/>
            Type: <?php //echo esc_html( (string) ( $booking_row['booking_type'] ?? '' ) ?: '—' ); ?><br/>
            Adults: <?php //echo esc_html( (string) ( $booking_row['booking_adults'] ?? '' ) ?: '—' ); ?><br/>
            Children: <?php //echo esc_html( (string) ( $booking_row['booking_children'] ?? '' ) !== '' ? (string) $booking_row['booking_children'] : '0' ); ?>
          </div>
        <?php //endforeach; ?>
      <?php //else : ?>
        <div class="simple-box">
          <strong><?php //echo esc_html( (string) ( $ctx['booking_number'] ?: '—' ) ); ?></strong><br/>
          <?php //echo esc_html( (string) ( $ctx['booking_datetime'] ?: '—' ) ); ?><br/>
          Type: <?php //echo esc_html( (string) ( $ctx['booking_type'] ?: '—' ) ); ?><br/>
          Adults: <?php //echo esc_html( (string) ( $ctx['booking_adults'] ?: '—' ) ); ?><br/>
          Children: <?php //echo esc_html( (string) ( $ctx['booking_children'] !== '' ? $ctx['booking_children'] : '0' ) ); ?>
        </div>
      <?php //endif; ?>
    </div> -->

    <div class="section">
      <h2>Passenger Contacts, Requests &amp; Account holder</h2>
      <table>
        <tr><th>Name</th><th>Phone</th><th>WS Confirmation</th><th>Special Requests</th></tr>
        <tr>
          <td><?php echo esc_html( (string) ( $ctx['passenger_names'][0] ?? '—' ) ); ?></td>
          <td><?php echo esc_html( (string) ( $order->get_billing_phone() ?: '—' ) ); ?></td>
          <td><?php echo esc_html( (string) ( $ctx['order_number'] ?: '—' ) ); ?></td>
          <td><?php if ( ! empty( $requests ) ) : ?><ul class="plain-list"><?php foreach ( $requests as $r ) : ?><li><?php echo esc_html( (string) $r ); ?></li><?php endforeach; ?></ul><?php else : ?>—<?php endif; ?></td>
        </tr>
      </table>
    </div>

    <?php if ( $show_greeter ) : ?>
    <div class="section">
      <h2>Greeter Details</h2>
      <table><tr><th>Name</th><th>Contact</th></tr><tr><td><?php echo esc_html( (string) ( $ctx['greeter_name'] ?: '—' ) ); ?></td><td><?php echo esc_html( (string) ( $ctx['greeter_contact'] ?: '—' ) ); ?></td></tr></table>
    </div>
    <?php endif; ?>

    <?php if ( $show_chauffeur ) : ?>
    <div class="section">
      <h2>Chauffeur Details</h2>
      <table><tr><th>Name</th><th>Contact</th><th>Email</th></tr><tr><td><?php echo esc_html( (string) ( $ctx['chauffeur_name'] ?: 'Tbc.' ) ); ?></td><td><?php echo esc_html( (string) ( $ctx['chauffeur_contact'] ?: 'Tbc.' ) ); ?></td><td><?php echo esc_html( (string) ( $ctx['chauffeur_email'] ?: '—' ) ); ?></td></tr></table>
    </div>
    <?php endif; ?>

    <div class="payments">stripe &nbsp; PayPal &nbsp; VISA &nbsp; AMEX &nbsp; MasterCard &nbsp; Apple Pay</div>
    <div class="section" style="text-align:center;"><img src="<?php echo esc_url( $logo ); ?>" alt="Airport VIP" style="max-width:120px;height:auto;" /><div class="muted"><?php echo esc_html( (string) ( $ctx['terms_title'] ?? 'TERMS AND CONDITIONS' ) ); ?></div></div>
    <!-- <div class="section terms"><?php //echo nl2br( esc_html( (string) ( $ctx['terms_text'] ?? '' ) ) ); ?></div>
    <div class="footer-bar"><img src="<?php //echo esc_url( $logo ); ?>" alt="Airport VIP" style="height:12px;vertical-align:middle;" /> &nbsp; <?php echo esc_html( (string) ( $ctx['company_address'] ?? '' ) ); ?></div> -->
  </div>
</body>
</html>

