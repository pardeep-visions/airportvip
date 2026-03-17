<?php 
/**
 * @package MC_Export_Bookings_WC_to_CSV
 * @version 1.0.2
 */

/**
*
* Escape is someone tries to access directly
*
**/
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
* Main plugin class
*
* @since 1.0
**/
if ( !class_exists( 'MC_Export_Bookings' ) ) {
	class MC_Export_Bookings {
		
		/**
		* Class contructor
		*
		* @since 1.0
		**/
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'mc_wcb_csv_register_script' ) );
			add_action( 'wp_ajax_mc_wcb_find_booking', array( $this, 'mc_wcb_find_booking' ) );
			add_action( 'wp_ajax_mc_wcb_export', array( $this, 'mc_wcb_export' ) );		
			add_action( 'wp_ajax_update_sales_reports', array( $this, 'update_sales_reports' ) );		
		}

		public function mc_wcb_csv_register_script( $hook ) {
			// Load only on export bookings pages
	        if( $hook != 'wc_booking_page_export-bookings-to-csv' ) {
	            return;
	        }

			wp_register_script( 'mc-wcb-script', MC_WCB_CSV . 'assets/mc-wcb-script.js', array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'mc-wcb-script' );
			wp_localize_script( 'mc-wcb-script', 'mc_wcb_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'security' => wp_create_nonce( 'mc-wcb-nonce' ) ) );
			
			wp_register_style('mc-wcb-css', MC_WCB_CSV . 'assets/mc-wcb-css.css');
			wp_enqueue_style( 'mc-wcb-css' );
		}

		/**
		* Add administration menus
		*
		* @since 0.1
		**/
		public function add_admin_pages() {
			add_submenu_page( 
	            'edit.php?post_type=wc_booking', 
	            __( 'Export bookings', 'export-bookings-to-csv' ),
	            __( 'Export bookings', 'export-bookings-to-csv' ),
	            'manage_options', 
	            'export-bookings-to-csv', 
	            array( $this,'mc_wcb_main_screen') 
	        );
		}

		/**
		* Main plugin screen 
		*/
		public function mc_wcb_main_screen() {		
		
			$args = array(
			    'post_type' => 'product',
			    'posts_per_page' => -1,
			    'tax_query' => array(
		    		array(
		    			'taxonomy' => 'product_type',
		    			'field'    => 'slug',
		    			'terms'    => 'booking',
		    		),
		    	),
			);
			$products = get_posts($args);
			// Query all products for display them in the select in the backoffice
			?>
			<div class="wrap">
				<h1 class="wp-heading-inline"><?php esc_html_e( 'Export bookings' , 'export-bookings-to-csv' ); ?></h1>
				<div class="mc-wcb-export-box postbox">
					<form method="post" name="csv_exporter_form" action="" enctype="multipart/form-data">
						<?php wp_nonce_field( 'export-bookings-bookings_export', '_wpnonce-export-bookings' ); ?>
						<h2>1. <?php esc_html_e( 'Select from which product to export bookings :', 'export-bookings-to-csv' ); ?></h2>
						
						<label for="mc-wcb-product-select"><?php esc_html_e( 'Product : ', 'export-bookings-to-csv' ); ?></label>
						<select name="mc-wcb-product-select" id="mc-wcb-product-select">
							<option value=""><?php esc_html_e( 'Select a product', 'export-bookings-to-csv' ); ?></option>
							<?php foreach($products as $product) {?>
								<option value="<?php echo $product->ID;?>" name="event"><?php echo $product->post_title; ?></option>
							<?php }?>
						</select>
						<div class="mc-wcb-dates">
							<label for="mc-wcb-dates"><?php esc_html_e( 'Filter by bookings dates : ', 'export-bookings-to-csv' ); ?></label>
							<input type="checkbox" name="mc-wcb-dates" id="mc-wcb-dates">
							<div class="mc-wcb-date-picker">
								<label for="mc_wcv_start_date"><?php esc_html_e( 'Start', 'export-bookings-to-csv' ); ?> :</label>
								    <input type="date" id="mc_wcv_start_date" name="mc_wcv_start_date" value="<?php echo date('Y-m-d') ; ?>" />
								<label for="mc_wcv_end_date"><?php esc_html_e( 'End', 'export-bookings-to-csv' ); ?> :</label>
								    <input type="date" id="mc_wcv_end_date" name="mc_wcv_end_date" value="<?php echo date('Y-m-d') ; ?>" />
							</div>
						</div>
						  <div class="mc-wcb-status">
			                <label for="mc-wcb-status"><?php esc_html_e( 'Filter by booking status : ', 'export-bookings-to-csv' ); ?></label>
			                <select name="mc-wcb-status" id="mc-wcb-status">
			                    <option value=""><?php esc_html_e( 'Select a status', 'export-bookings-to-csv' ); ?></option>
			                    <option value="confirmed"><?php esc_html_e( 'Confirmed', 'export-bookings-to-csv' ); ?></option>
			                    <option value="paid"><?php esc_html_e( 'Paid', 'export-bookings-to-csv' ); ?></option>
			                    <option value="complete"><?php esc_html_e( 'Complete', 'export-bookings-to-csv' ); ?></option>
			                    <!-- Add other statuses as needed -->
			                </select>
			            </div>
						<input type="submit" name="mc-wcb-fetch" id="mc-wcb-fetch" class="button button-secondary" value="<?php esc_html_e( 'Search bookings', 'export-bookings-to-csv' ); ?>" />
						<div class="mc-wcb-response">
							<img src="<?php echo MC_WCB_CSV ?>img/loader.svg" class="mc-wcb-loader"/>
							<div class="mc-wcb-result"></div>
						</div>
						<div class="mc-wcb-export">
							<h2>2. <?php esc_html_e( 'Click on "export" to generate CSV file :', 'export-bookings-to-csv' ); ?></h2>
							<input type="submit" name="mc-wcb-submit" id="mc-wcb-submit" class="button button-primary" value="<?php esc_html_e( 'Export', 'export-bookings-to-csv' ); ?>" />
						</div>
						<div class="mc-wcb-export-result">
							<p><?php esc_html_e( 'Be patient, export is in progress, please do not close this page.' , 'export-bookings-to-csv' ); ?></p>
							<p><?php esc_html_e( 'A download link will be displayed below at the end of the process.' , 'export-bookings-to-csv' ); ?></p>
						</div>
						<div class="mc-wcb-download">
							<h2>3. <?php esc_html_e( 'Download your file :', 'export-bookings-to-csv' ); ?></h2>
							<a href="#" class="mc-wcb-link"><?php _e( 'Download', 'export-bookings-to-csv' ); ?></a>
						</div>
					</form>
				</div>
				<?php
				$exports_list = $this->mc_wcb_list_exports();
				if ( $exports_list ) {
				?>
					<div class="mc-wcb-exports-list postbox">
						<?php 					
						$upload_dir = wp_upload_dir();
						echo '<h2>' . __( 'Your previous exports :', 'export-bookings-to-csv' ) . '</h2>';
						echo '<ul>';
						foreach ( $exports_list as $file ) {
							echo '<li><a href="' . $upload_dir['baseurl'] . '/woocommerce-bookings-exports/' . $file . '" class="mc-wcb-link"><span class="dashicons dashicons-download"></span>' . $file . '</a></li>';
						}
						echo '</ul>';
						?>
					</div>
				<?php } ?>  
			</div>
			<?php 
		}

		/**
		* mc_wcb_list_exports
		* List exports in uploads/woocommerce-bookings-exports/ folder
		* @since 1.0.2
		*/
		public function mc_wcb_list_exports() {
			$upload_dir = wp_upload_dir();
			$files  = @scandir( $upload_dir['basedir'] . '/woocommerce-bookings-exports' );

			$result = array();

			if ( ! empty( $files ) ) {

				foreach ( $files as $key => $value ) {

					if ( ! in_array( $value, array( '.', '..' ) ) ) {
						if ( ! is_dir( $value ) && strstr( $value, '.csv' ) ) {
							$result[ sanitize_title( $value ) ] = $value;
						}
					}
				}
			}

			return $result;
		}

	 
		/**
		 * Get bookings by status and optionally by product ID
		 * @since 1.0.2
		 * @param $data_search array
		 * @return $bookings_ids array
		 */
		public function mc_wcb_get_bookings( $data_search ) {

		    if ( $data_search ) {

		        $booking_data = new WC_Booking_Data_Store();

		        $args = array(
		            'order_by' => 'start_date',
		            'limit'    => -1,
		        );

		        if ( isset( $data_search['product_id'] ) && !empty( $data_search['product_id'] ) ) {
		            $args['object_id']   = $data_search['product_id'];
		            $args['object_type'] = 'product';
		        }

		        if ( isset( $data_search['date_start'] ) && !empty( $data_search['date_start'] ) ) {
		            $args['date_after'] = strtotime( $data_search['date_start'] );
		        }

		        if ( isset( $data_search['date_end'] ) && !empty( $data_search['date_end'] ) ) {
		            $args['date_before'] = strtotime( $data_search['date_end'] );
		        }

		        if ( isset( $data_search['status'] ) && !empty( $data_search['status'] ) ) {
		            $args['status'] = array($data_search['status']);
		        } else {
		            $args['status'] = array( 'confirmed', 'paid', 'complete' , 'unpaid' , 'cancelled' ); 
		        }

		        $bookings_ids = $booking_data->get_booking_ids_by( $args ); 

		        return $bookings_ids;
		    }

		    return false;
		}



		 
		/**
			* mc_wcb_find_booking
			* Find booking when select a product
			* @since 1.0.2
			**/
			public function mc_wcb_find_booking() {
			    $query_data = $_GET;
			    $data = array();

			    // Verify nonce
			    if ( ! wp_verify_nonce( $_GET['security'], 'mc-wcb-nonce' ) ) {
			        $error = -1;
			        wp_send_json_error( $error );
			        exit;
			    }

			    $data_search = array();

			    if ( isset( $_GET['selected_product_id'] ) && !empty( $_GET['selected_product_id'] ) ) {
			        $data_search['product_id'] = $_GET['selected_product_id'];
			    }

			    if ( isset( $_GET['date_start'] ) && !empty( $_GET['date_start'] ) ) {
			        $data_search['date_start'] = $_GET['date_start'];
			    }

			    if ( isset( $_GET['date_end'] ) && !empty( $_GET['date_end'] ) ) {
			        $data_search['date_end'] = $_GET['date_end'];
			    }

			    if ( isset( $_GET['booking_status'] ) && !empty( $_GET['booking_status'] ) ) {
			        $data_search['status'] = $_GET['booking_status'];
			    }

			    if ( ! class_exists( 'WC_Booking_Data_Store' ) ) {
			        $error = array(
			            'code'    => 0,
			            'message' => __( 'Can\'t find WC_Booking_Data_Store class.', 'export-bookings-to-csv' ),
			        );
			        wp_send_json_error( $error );
			        exit;
			    }

			    $bookings_ids = $this->mc_wcb_get_bookings( $data_search );

			    if ( $bookings_ids ) {
			        $booking_count = count( $bookings_ids );
			        $data['message'] = sprintf( __( '<b>%d</b> booking(s) found.', 'export-bookings-to-csv' ), $booking_count );
			        wp_send_json_success( $data );
			    } else {
			        $data['message'] = __( 'No booking(s) found for the given criteria.', 'export-bookings-to-csv' );
			        wp_send_json_error( $data );
			    }

			    wp_die();
			} 

		/**
		* mc_wcb_export
		* Contruct PHP data array for CSV export
		*
		* @since 0.1
		**/	

		public function mc_wcb_export() {

			    // Verify nonce
			    if ( ! wp_verify_nonce( $_GET['security'], 'mc-wcb-nonce' ) ) {
			        $error = -1;
			        wp_send_json_error( $error );
			        exit;
			    }

			    $data_search = array();

			    if ( isset( $_GET['selected_product_id'] ) && !empty( $_GET['selected_product_id'] ) ) {
			        $data_search['product_id'] = $_GET['selected_product_id'];
			    }

			    if ( isset( $_GET['date_start'] ) && !empty( $_GET['date_start'] ) ) {
			        $data_search['date_start'] = $_GET['date_start'];
			    }

			    if ( isset( $_GET['date_end'] ) && !empty( $_GET['date_end'] ) ) {
			        $data_search['date_end'] = $_GET['date_end'];
			    }

			    // Add filter by booking status
			    if ( isset( $_GET['booking_status'] ) && !empty( $_GET['booking_status'] ) ) {
			        $data_search['status'] = $_GET['booking_status'];
			    }

			    if ( ! class_exists( 'WC_Booking_Data_Store' ) ) {
			        $error = array(
			            'code'    => 0,
			            'message' => __( 'Can\'t find WC_Booking_Data_Store class.', 'export-bookings-to-csv' ),
			        );
			        wp_send_json_error( $error );
			        exit;
			    }

			    $bookings_ids = $this->mc_wcb_get_bookings( $data_search );

			    if ( $bookings_ids ) {
			        $product_slug = isset($data_search['product_id']) ? get_post_field( 'post_name', $data_search['product_id'] ) : 'all-products';
			        $file_name = $product_slug . '-' . date('d-m-Y-h-i');

			        $data = array();

			        foreach ( $bookings_ids as $booking_id ) {
			            $booking = new WC_Booking( $booking_id );

			            $product_name = $booking->get_product()->get_title();

			            $resource = $booking->get_resource();
			            $booking_resource = $resource ? $resource->post_title : 'N/A';

			            $start_date = $booking->get_start() ? date( 'd-m-Y H:i', $booking->get_start() ) : 'N/A';
			            $end_date = $booking->get_end() ? date( 'd-m-Y H:i', $booking->get_end() ) : 'N/A';

			            $person_count = $booking->get_persons_total() ?: '0';

			            $order = $booking->get_order();
			            if ( $order ) {
			                $customer_name = $order->get_billing_first_name() ?: 'N/A';
			                $customer_last_name = $order->get_billing_last_name() ?: 'N/A';
			                $customer_mail = $order->get_billing_email() ?: 'N/A';
			                $customer_phone = $order->get_billing_phone() ?: 'N/A';
			                $price = $order->get_total() ?: 'N/A';
			            } else {
			                $customer_name = $customer_last_name = $customer_mail = $customer_phone = $price = 'N/A';
			            }

			            $status = $booking->get_status() ?: 'N/A'; // Fetch booking status

			            if ( $start_date && $end_date ) {
			                $data[] = array(
			                    $booking_id, $product_name, $start_date, $end_date, $booking_resource,
			                    $customer_name, $customer_last_name, $customer_mail, $customer_phone, $price,
			                    $person_count, $status // Add status to the data array
			                );
			            }
			        }

			        if ( $data && is_array( $data ) && !empty( $data ) ) {
			            $delimiter = apply_filters( 'mc_wcb_csv_delimiter', ';' );
			            $file_url = $this->array_to_csv_download( $data, $file_name, $delimiter );

			            if ( $file_url ) {
			                $json['file_url'] = $file_url;
			                wp_send_json_success( $json );
			            }
			        }
			    } else {
			        $error['message'] =  __( 'No booking(s) found for the given criteria.', 'export-bookings-to-csv' );
			        wp_send_json_error( $error );
			    }

			    wp_die();
			}

		
		/**
		* array_to_csv_download
		* Process PHP array to CSV file
		* @param $data array
		* @param $filename string
		* @param $delimiter string
		* @return $file_url string
		* @since 1.0.0
		*/
		function array_to_csv_download( $data, $filename, $delimiter ) {

			ob_start();
			$upload_dir = wp_upload_dir();
			//$f = fopen( 'php://output', 'w');
			$f = fopen( $upload_dir['basedir'] . '/woocommerce-bookings-exports/' . $filename . '.csv', 'w' );
			$header = array( 
	            __( 'Booking ID', 'export-bookings-to-csv' ), 
	            __( 'Product', 'export-bookings-to-csv' ), 
	            __( 'Start', 'export-bookings-to-csv' ), 
	            __( 'End', 'export-bookings-to-csv' ), 
	            __( 'Ressource', 'export-bookings-to-csv' ), 
	            __( 'Last name', 'export-bookings-to-csv' ), 
	            __( 'First name', 'export-bookings-to-csv' ), 
	            __( 'Email', 'export-bookings-to-csv' ), 
	            __( 'Phone', 'export-bookings-to-csv' ), 
	            __( 'Paid price', 'export-bookings-to-csv' ),
	            __( 'Persons', 'export-bookings-to-csv' ),
	            __( 'Status', 'export-bookings-to-csv' )
	        );
			fputcsv($f, $header, $delimiter);
			// loop over the input array
			foreach ($data as $line) { 
				// generate csv lines from the inner arrays
				fputcsv($f, $line, $delimiter); 
			}
			fclose($f);

			$file_url = $upload_dir['baseurl'] . '/woocommerce-bookings-exports/' . $filename . '.csv';

			return $file_url;
		}

	 	public function update_sales_reports() {

			//echo "<pre>"; print_r($_POST); die;
		    // Get start and end dates from AJAX request
		    $start_date = isset($_POST['start_date']) ? sanitize_text_field($_POST['start_date']) : '';
		    $end_date = isset($_POST['end_date']) ? sanitize_text_field($_POST['end_date']) : '';

		    // Buffer the output (instead of directly echoing)
		    ob_start();

		    // Display updated sales reports based on provided dates
		    echo '<div id="sales-by-date-report">';
		    display_sales_by_date_report($start_date, $end_date);
		    echo '</div>';

		    echo '<div id="sales-by-product-report">';
		    display_sales_by_product_report($start_date, $end_date);
		    echo '</div>';

		    // Get buffered output and send as response
		    $response = ob_get_clean();
		    echo $response;

		    // Always use die() or exit() at the end of the AJAX callback function
		    die();
		}


	} 
	
	global $mc_wcb_csv;
	
	if ( ! isset( $mc_wcb_csv ) ) {

	    $mc_wcb_csv = new MC_Export_Bookings();

	}
}