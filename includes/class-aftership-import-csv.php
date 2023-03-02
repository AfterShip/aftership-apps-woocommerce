<?php

/**
 * Class AfterShip_Import_Csv
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * When turned on, PHP will examine the data read by fgets() and file() to see if it is using Unix, MS-Dos or Macintosh line-ending conventions.
 */
ini_set( 'auto_detect_line_endings', true );

class AfterShip_Import_Csv {
	protected $settings;
	protected $options;
	protected $process;
	protected $request;
	protected $step;
	protected $file_url;
	protected $header;
	protected $error;
	protected $index;
	protected $orders_per_request;
	protected $nonce;
	protected $carriers;
	protected $actions;

	public function __construct() {
		$this->actions  = AfterShip_Actions::get_instance();
		$this->options  = get_option( 'aftership_option_name' ) ? get_option( 'aftership_option_name' ) : array();
		$this->carriers = json_decode( file_get_contents( AFTERSHIP_TRACKING_JS . '/couriers.json' ), true );
		add_action( 'admin_menu', array( $this, 'add_menu' ), 19 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_init', array( $this, 'import_csv' ) );
		add_action( 'wp_ajax_aftership_orders_tracking_import', array( $this, 'import_order_tracking' ) );
		add_action(
			'vi_at_importer_scheduled_cleanup',
			array(
				$this,
				'scheduled_cleanup',
			)
		);
		add_action( 'wp_ajax_vi_at_view_log', array( $this, 'generate_log_ajax' ) );
	}

	/**
	 * View import log
	 */
	public function generate_log_ajax() {
		/*Check the nonce*/
		if ( ! current_user_can( 'manage_woocommerce' ) || empty( $_GET['action'] ) || ! check_admin_referer( wp_unslash( $_GET['action'] ) ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'aftership-orders-tracking' ) );
		}
		if ( empty( $_GET['vi_at_file'] ) ) {
			wp_die( esc_html__( 'No log file selected.', 'aftership-orders-tracking' ) );
		}
		$file = urldecode( wp_unslash( wc_clean( $_GET['vi_at_file'] ) ) );
		if ( ! is_file( $file ) ) {
			wp_die( esc_html__( 'Log file not found.', 'aftership-orders-tracking' ) );
		}
		echo( wp_kses_post( nl2br( file_get_contents( $file ) ) ) );
		exit();
	}

	/**html tag attribute
	 *
	 * @param $name
	 * @param bool $set_name
	 *
	 * @return string
	 */
	public static function set( $name, $set_name = false ) {
		return AFTERSHIP_ORDERS_TRACKING_DATA::set( $name, $set_name );
	}

	/**Delete csv file after 24 hours
	 *
	 * @param $attachment_id
	 */
	public function scheduled_cleanup( $attachment_id ) {
		if ( $attachment_id ) {
			wp_delete_attachment( $attachment_id, true );
		}
	}

	public function add_menu() {
		add_submenu_page(
			'aftership-setting-admin',
			'Import Tracking',
			'Import Tracking',
			'manage_woocommerce',
			'aftership-orders-tracking-import-csv',
			array(
				$this,
				'import_csv_callback',
			)
		);
	}

	public function sanitize_text_field( $value ) {
		return sanitize_text_field( urldecode( $value ) );
	}

	/**
	 * Get selected couriers of user
	 *
	 * @return array
	 */
	public function get_user_selected_couriers() {
		$slugs                  = explode( ',', ( isset( $this->options['couriers'] ) ? $this->options['couriers'] : '' ) );
		$user_selected_couriers = array();
		foreach ( $this->carriers as $carrier ) {
			if ( in_array( $carrier['slug'], $slugs, true ) ) {
				$user_selected_couriers[] = array( $carrier['name'], $carrier['slug'] );
			}
		}
		return $user_selected_couriers;
	}

	/**
	 * Upload csv file and preprocess data
	 */
	public function import_csv() {
		global $pagenow;
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		$page = isset( $_GET['page'] ) ? wp_unslash( $this->sanitize_text_field( $_GET['page'] ) ) : '';
		if ( $pagenow === 'admin.php' && $page === 'aftership-orders-tracking-import-csv' ) {
			$this->step     = isset( $_REQUEST['step'] ) ? sanitize_text_field( $_REQUEST['step'] ) : '';
			$this->file_url = isset( $_REQUEST['file_url'] ) ? urldecode_deep( wp_unslash( wc_clean( $_REQUEST['file_url'] ) ) ) : '';

			if ( $this->step == 'mapping' ) {
				if ( is_file( $this->file_url ) ) {
					if ( ( $order_id = fopen( $this->file_url, 'r' ) ) !== false ) {
						$this->header = fgetcsv( $order_id, 0, ',' );
						fclose( $order_id );
						if ( ! count( $this->header ) ) {
							$this->step  = '';
							$this->error = esc_html__( 'Invalid file.', 'aftership-orders-tracking' );
						}
					} else {
						$this->step  = '';
						$this->error = esc_html__( 'Invalid file.', 'aftership-orders-tracking' );
					}
				} else {
					$this->step  = '';
					$this->error = esc_html__( 'Invalid file.', 'aftership-orders-tracking' );
				}
			}

			if ( ! isset( $_POST['_aftership_orders_tracking_import_nonce'] ) || ! wp_verify_nonce( wp_unslash( $this->sanitize_text_field( $_POST['_aftership_orders_tracking_import_nonce'] ) ), 'aftership_orders_tracking_import_action_nonce' ) ) {
				return;
			}
			if ( isset( $_POST['aftership_orders_tracking_import'] ) ) {
				$this->step     = 'import';
				$this->file_url = isset( $_POST['aftership_orders_tracking_file_url'] ) ? wp_unslash( $_POST['aftership_orders_tracking_file_url'] ) : '';
				$this->nonce    = isset( $_POST['_aftership_orders_tracking_import_nonce'] ) ? sanitize_text_field( $_POST['_aftership_orders_tracking_import_nonce'] ) : '';
				$map_to         = array_map(
					array(
						'Aftership_Import_Csv',
						'sanitize_text_field',
					),
					array(
						'order_id'        => 'Order+ID',
						'tracking_number' => 'Tracking+Number',
						'carrier_slug'    => 'Carrier+Slug',
					)
				);

				if ( is_file( $this->file_url ) ) {
					if ( ( $file_handle = fopen( $this->file_url, 'r' ) ) !== false ) {
						$header = fgetcsv( $file_handle, 0, ',' );

						$headers = array(
							'order_id'        => esc_html__( 'Order ID', 'aftership-orders-tracking' ),
							'tracking_number' => esc_html__( 'Tracking Number', 'aftership-orders-tracking' ),
							'carrier_slug'    => esc_html__( 'Carrier Slug', 'aftership-orders-tracking' ),
						);
						$index   = array();
						foreach ( $headers as $header_k => $header_v ) {
							$field_index = array_search( $map_to[ $header_k ], $header );
							if ( $field_index === false ) {
								$index[ $header_k ] = - 1;
							} else {
								$index[ $header_k ] = $field_index;
							}
						}
						$required_fields = array(
							'order_id',
							'tracking_number',
							'carrier_slug',
						);

						foreach ( $required_fields as $required_field ) {
							if ( 0 > $index[ $required_field ] ) {
								wp_safe_redirect( add_query_arg( array( 'vi_at_error' => 1 ), admin_url( 'admin.php?page=aftership-orders-tracking-import-csv&step=mapping&file_url=' . urlencode( $this->file_url ) ) ) );
								exit();
							}
						}

						$this->index = $index;
					} else {
						wp_safe_redirect( add_query_arg( array( 'vi_at_error' => 2 ), admin_url( 'admin.php?page=aftership-orders-tracking-import-csv&file_url=' . urlencode( $this->file_url ) ) ) );
						exit();
					}
				} else {
					wp_safe_redirect( add_query_arg( array( 'vi_at_error' => 3 ), admin_url( 'admin.php?page=aftership-orders-tracking-import-csv&file_url=' . urlencode( $this->file_url ) ) ) );
					exit();
				}
			} elseif ( isset( $_POST['aftership_orders_tracking_select_file'] ) ) {
				if ( ! isset( $_FILES['aftership_orders_tracking_file'] ) ) {
					$error = new WP_Error( 'aftership_orders_tracking_csv_importer_upload_file_empty', esc_html__( 'File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.', 'aftership-orders-tracking' ) );
					wp_die( $error->get_error_messages() );
				} elseif ( ! empty( $_FILES['aftership_orders_tracking_file']['error'] ) ) {
					$error = new WP_Error( 'aftership_orders_tracking_csv_importer_upload_file_error', esc_html__( 'File is error.', 'aftership-orders-tracking' ) );
					wp_die( $error->get_error_messages() );
				} else {
					$import    = $_FILES['aftership_orders_tracking_file'];
					$overrides = array(
						'test_form' => false,
						'mimes'     => array(
							'csv' => 'text/csv',
						),
						'test_type' => true,
					);
					$upload    = wp_handle_upload( $import, $overrides );
					if ( isset( $upload['error'] ) ) {
						wp_die( $upload['error'] );
					}
					// Construct the object array.
					$object = array(
						'post_title'     => basename( $upload['file'] ),
						'post_content'   => $upload['url'],
						'post_mime_type' => $upload['type'],
						'guid'           => $upload['url'],
						'context'        => 'import',
						'post_status'    => 'private',
					);

					// Save the data.
					$id = wp_insert_attachment( $object, $upload['file'] );
					if ( is_wp_error( $id ) ) {
						wp_die( $id->get_error_messages() );
					}
					/*
					 * Schedule a cleanup for one day from now in case of failed
					 * import or missing wp_import_cleanup() call.
					 */
					wp_schedule_single_event( time() + DAY_IN_SECONDS, 'vi_at_importer_scheduled_cleanup', array( $id ) );
					wp_safe_redirect(
						add_query_arg(
							array(
								'step'     => 'mapping',
								'file_url' => urlencode( $upload['file'] ),
							)
						)
					);
					exit();
				}
			} elseif ( isset( $_POST['aftership_orders_tracking_download_carriers_file'] ) ) {
				$filename   = 'aftership-selected-carriers.csv';
				$header_row = array(
					esc_html__( 'Carrier Name', 'aftership-orders-tracking' ),
					esc_html__( 'Carrier Slug', 'aftership-orders-tracking' ),
				);
				// Get user selected carriers
				$data_rows = $this->get_user_selected_couriers();

				$fh = @fopen( 'php://output', 'w' );
				fprintf( $fh, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );
				header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
				header( 'Content-Description: File Transfer' );
				header( 'Content-type: text/csv' );
				header( 'Content-Disposition: attachment; filename=' . $filename );
				header( 'Expires: 0' );
				header( 'Pragma: public' );
				fputcsv( $fh, $header_row );
				foreach ( $data_rows as $data_row ) {
					fputcsv( $fh, $data_row );

				}
				$csvFile = stream_get_contents( $fh );
				fclose( $fh );
				die();
			} elseif ( isset( $_POST['aftership_orders_tracking_download_demo_file'] ) ) {
				$filename   = 'Import file example.csv';
				$header_row = array(
					'order_id'        => esc_html__( 'Order ID', 'aftership-orders-tracking' ),
					'tracking_number' => esc_html__( 'Tracking Number', 'aftership-orders-tracking' ),
					'carrier_slug'    => esc_html__( 'Carrier Slug', 'aftership-orders-tracking' ),
				);
				$data_rows  = array(
					array(
						'111',
						'tracking_number1',
						'dhl-logistics',
					),
					array(
						'112',
						'tracking_number2',
						'dhl-logistics',
					),
					array(
						'113',
						'tracking_number3',
						'dhl-logistics',
					),
				);
				$fh         = @fopen( 'php://output', 'w' );
				fprintf( $fh, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );
				header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
				header( 'Content-Description: File Transfer' );
				header( 'Content-type: text/csv' );
				header( 'Content-Disposition: attachment; filename=' . $filename );
				header( 'Expires: 0' );
				header( 'Pragma: public' );
				fputcsv( $fh, $header_row );
				foreach ( $data_rows as $data_row ) {
					fputcsv( $fh, $data_row );

				}
				$csvFile = stream_get_contents( $fh );
				fclose( $fh );
				die();
			}
		}
	}

	/**Save tracking to database for an order
	 *
	 * @param $order_id
	 * @param $data
	 *
	 * @throws Exception
	 */
	public function import_tracking( $order_id, $data ) {
		if ( $order_id && count( $data ) ) {
			$order = wc_get_order( $order_id );
			if ( $order ) {
				$line_items = $order->get_items();

				$change = 0;
				if ( count( $line_items ) ) {
					// Get item id and quantity of line_item
					$import_line_items = array();
					foreach ( $line_items as  $item_key => $item_val ) {
						$item_data           = $item_val->get_data();
						$import_line_items[] = array(
							'id'       => $item_data['id'],
							'quantity' => $item_data['quantity'],
						);
					}
					// Each order only has one tracking number from CSV
					foreach ( $data as $item ) {
						$post_tracking_params   = array(
							'slug'            => $item['carrier_slug'],
							'tracking_number' => $item['tracking_number'],
							'line_items'      => $import_line_items,
						);
						$updated_order_tracking = $this->actions->post_order_tracking( $order_id, $post_tracking_params );
						if ( count( $updated_order_tracking ) ) {
							$change ++;
						} else {
							// The same order was detected and imported repeatedly
							AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG::log( esc_html__( "Skipped, Imported repeatedly for order #{$order_id}, tracking number: {$item['tracking_number']}", 'aftership-orders-tracking' ) );
						}
					}
				}
				if ( $change > 0 ) {
					AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG::log( esc_html__( "Import tracking successfully for order #{$order_id}", 'aftership-orders-tracking' ) );
				}
			} else {
				// Skip - The store can't find this order
				AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG::log( esc_html__( "Skipped, Can't be found for order #{$order_id}", 'aftership-orders-tracking' ) );
			}
		}
	}

	/**Handle ajax import
	 *
	 * @throws Exception
	 */
	public function import_order_tracking() {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'message' => esc_html__( 'You do not have permission.', 'aftership-orders-tracking' ),
				)
			);
		}

		$file_url           = isset( $_POST['file_url'] ) ? stripslashes( $_POST['file_url'] ) : '';
		$start              = isset( $_POST['start'] ) ? absint( sanitize_text_field( $_POST['start'] ) ) : 0;
		$ftell              = isset( $_POST['ftell'] ) ? absint( sanitize_text_field( $_POST['ftell'] ) ) : 0;
		$total              = isset( $_POST['total'] ) ? absint( sanitize_text_field( $_POST['total'] ) ) : 0;
		$step               = isset( $_POST['step'] ) ? sanitize_text_field( $_POST['step'] ) : '';
		$index              = isset( $_POST['vi_at_index'] ) ? array_map( 'intval', $_POST['vi_at_index'] ) : array();
		$orders_per_request = isset( $_POST['orders_per_request'] ) ? absint( sanitize_text_field( $_POST['orders_per_request'] ) ) : 1;

		switch ( $step ) {
			case 'check':
				if ( is_file( $file_url ) ) {
					if ( ( $file_handle = fopen( $file_url, 'r' ) ) !== false ) {
						$header = fgetcsv( $file_handle, 0, ',' );
						unset( $header );

						$count = 1;
						while ( ( $item = fgetcsv( $file_handle, 0, ',' ) ) !== false ) {
							$count ++;
						}
						$total = $count;
						fclose( $file_handle );
						AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG::create_plugin_cache_folder();
						if ( $total > 1 ) {
							if ( $total > $start ) {
								AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG::log( esc_html__( 'Start importing tracking', 'aftership-orders-tracking' ) );
								wp_send_json(
									array(
										'status'  => 'success',
										'total'   => $total,
										'message' => '',
									)
								);
							} else {
								AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG::log( esc_html__( "Error: Start at row must be smaller than {($total-1)}", 'aftership-orders-tracking' ) );
								wp_send_json(
									array(
										'status'  => 'error',
										'total'   => $total,
										'message' => esc_html__( "Start at row must be smaller than {($total-1)}", 'aftership-orders-tracking' ),
									)
								);
							}
						} else {
							AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG::log( esc_html__( 'No data', 'aftership-orders-tracking' ) );
							wp_send_json(
								array(
									'status'  => 'error',
									'total'   => $total,
									'message' => esc_html__( 'No data', 'aftership-orders-tracking' ),
								)
							);
						}
					} else {
						wp_send_json(
							array(
								'status'  => 'error',
								'message' => esc_html__( 'Invalid file.', 'aftership-orders-tracking' ),
							)
						);
					}
				} else {
					wp_send_json(
						array(
							'status'  => 'error',
							'message' => esc_html__( 'Invalid file.', 'aftership-orders-tracking' ),
						)
					);
				}
				break;
			case 'import':
				if ( is_file( $file_url ) ) {
					if ( ( $file_handle = fopen( $file_url, 'r' ) ) !== false ) {
						$header = fgetcsv( $file_handle, 0, ',' );
						unset( $header );
						$count      = 0;
						$orders     = array();
						$order_data = array();
						$order_id   = '';
						$ftell_2    = 0;
						if ( $ftell > 0 ) {
							fseek( $file_handle, $ftell );
						} elseif ( $start > 1 ) {
							for ( $i = 0; $i < $start; $i ++ ) {
								$buff = fgetcsv( $file_handle, 0, ',' );
								unset( $buff );
							}
						}
						while ( ( $item = fgetcsv( $file_handle, 0, ',' ) ) !== false ) {
							$count ++;
							$order_id_1      = $item[ $index['order_id'] ];
							$tracking_number = $item[ $index['tracking_number'] ];
							$carrier_slug    = $item[ $index['carrier_slug'] ];
							$start ++;
							$ftell_1 = ftell( $file_handle );
							// Check if has value for required fields
							if ( empty( $order_id_1 ) || empty( $carrier_slug ) || empty( $tracking_number ) ) {
								$ftell_2 = $ftell_1;
								// If exist empty, skip
								continue;
							}
							// set time limit
							vi_at_set_time_limit();
							if ( ! in_array( $order_id_1, $orders ) ) {
								/*create previous order*/
								$this->import_tracking( $order_id, $order_data );
								if ( count( $orders ) < $orders_per_request ) {
									$order_id   = $order_id_1;
									$orders[]   = $order_id;
									$order_data = array(
										array(
											'tracking_number' => $tracking_number,
											'carrier_slug' => $carrier_slug,
										),
									);

								} else {
									fclose( $file_handle );
									wp_send_json(
										array(
											'status'  => 'success',
											'orders'  => $order_data,
											'start'   => $start - 1,
											'ftell'   => $ftell_2,
											'ftell_1' => $ftell_1,
											'ftell_2' => $ftell_2,
											'percent' => intval( 100 * ( $start ) / $total ),
										)
									);
								}
							} else {
								$order_data[] = array(
									'tracking_number' => $tracking_number,
									'carrier_slug'    => $carrier_slug,
								);
							}
							unset( $item );
							$next_item = fgetcsv( $file_handle, 0, ',' );
							if ( false === $next_item ) {
								/*create previous order*/
								$this->import_tracking( $order_id, $order_data );
								fclose( $file_handle );
								AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG::log( esc_html__( 'Finish importing tracking', 'aftership-orders-tracking' ) );

								AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG::log( esc_html__( 'Import tracking from CSV completed', 'aftership-orders-tracking' ) );
								wp_send_json(
									array(
										'status'  => 'finish',
										'message' => esc_html__( 'Import completed', 'aftership-orders-tracking' ),
										'start'   => $start,
										'percent' => intval( 100 * ( $start ) / $total ),
									)
								);
							} else {
								$count ++;
								$order_id_2      = $next_item[ $index['order_id'] ];
								$tracking_number = $next_item[ $index['tracking_number'] ];
								$carrier_slug    = $next_item[ $index['carrier_slug'] ];
								$start ++;
								$ftell_2 = ftell( $file_handle );
								if ( empty( $order_id_2 ) || empty( $carrier_slug ) || empty( $tracking_number ) ) {
									continue;
								}

								if ( ! in_array( $order_id_2, $orders ) ) {
									/*create previous order*/
									$this->import_tracking( $order_id, $order_data );
									if ( count( $orders ) < $orders_per_request ) {
										$order_id   = $order_id_2;
										$orders[]   = $order_id;
										$order_data = array(
											array(
												'tracking_number' => $tracking_number,
												'carrier_slug'    => $carrier_slug,
											),
										);
									} else {
										fclose( $file_handle );
										wp_send_json(
											array(
												'status'  => 'success',
												'orders'  => $order_data,
												'start'   => $start - 1,
												'ftell'   => $ftell_1,
												'ftell_2' => $ftell_2,
												'ftell_1' => $ftell_1,
												'percent' => intval( 100 * ( $start ) / $total ),
											)
										);
									}
								} else {
									$order_data[] = array(
										'tracking_number' => $tracking_number,
										'carrier_slug'    => $carrier_slug,
									);
								}
								unset( $next_item );
							}
						}
						$this->import_tracking( $order_id, $order_data );
						fclose( $file_handle );
						AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG::log( esc_html__( 'Finish importing tracking', 'aftership-orders-tracking' ) );

						AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG::log( esc_html__( 'Import tracking from CSV completed', 'aftership-orders-tracking' ) );
						wp_send_json(
							array(
								'status'  => 'finish',
								'message' => esc_html__( 'Import completed', 'aftership-orders-tracking' ),
								'start'   => $start,
								'percent' => intval( 100 * ( $start ) / $total ),
							)
						);
					} else {
						wp_send_json(
							array(
								'status'  => 'error',
								'message' => esc_html__( 'Invalid file.', 'aftership-orders-tracking' ),
							)
						);
					}
				} else {
					wp_send_json(
						array(
							'status'  => 'error',
							'message' => esc_html__( 'Invalid file.', 'aftership-orders-tracking' ),
						)
					);
				}

				break;
			default:
				wp_send_json(
					array(
						'status'  => 'error',
						'message' => esc_html__( 'Invalid data.', 'aftership-orders-tracking' ),
						'start'   => $start,
						'percent' => 0,
					)
				);
		}
	}

	public function admin_enqueue_scripts() {
		global $pagenow;
		$page = isset( $_REQUEST['page'] ) ? sanitize_text_field( $_REQUEST['page'] ) : '';
		if ( $pagenow === 'admin.php' && $page === 'aftership-orders-tracking-import-csv' ) {
			wp_enqueue_script( 'aftership-tracking-semantic-ui-form', AFTERSHIP_TRACKING_IMPORT_JS . 'form.min.js', array( 'jquery' ) );
			wp_enqueue_style( 'aftership-tracking-semantic-ui-form', AFTERSHIP_TRACKING_IMPORT_CSS . 'form.min.css' );
			wp_enqueue_script( 'aftership-tracking-semantic-ui-progress', AFTERSHIP_TRACKING_IMPORT_JS . 'progress.min.js', array( 'jquery' ) );
			wp_enqueue_style( 'aftership-tracking-semantic-ui-progress', AFTERSHIP_TRACKING_IMPORT_CSS . 'progress.min.css' );
			wp_enqueue_style( 'aftership-tracking-semantic-ui-segment', AFTERSHIP_TRACKING_IMPORT_CSS . 'segment.min.css' );
			wp_enqueue_style( 'aftership-tracking-semantic-ui-button', AFTERSHIP_TRACKING_IMPORT_CSS . 'button.min.css' );
			wp_enqueue_style( 'aftership-tracking-semantic-ui-message', AFTERSHIP_TRACKING_IMPORT_CSS . 'message.min.css' );
			wp_enqueue_style( 'aftership-tracking-semantic-ui-icon', AFTERSHIP_TRACKING_IMPORT_CSS . 'icon.min.css' );
			wp_enqueue_style( 'aftership-tracking-semantic-ui-step', AFTERSHIP_TRACKING_IMPORT_CSS . 'step.min.css' );
			wp_enqueue_script( 'aftership-orders-tracking-import', AFTERSHIP_TRACKING_IMPORT_JS . 'import-csv.js', array( 'jquery' ), AFTERSHIP_VERSION );
			wp_enqueue_style( 'aftership-orders-tracking-import', AFTERSHIP_TRACKING_IMPORT_CSS . 'import-csv.css', '', AFTERSHIP_VERSION );
			wp_localize_script(
				'aftership-orders-tracking-import',
				'aftership_orders_tracking_import_params',
				array(
					'url'                => admin_url( 'admin-ajax.php' ),
					'step'               => $this->step,
					'file_url'           => $this->file_url,
					'nonce'              => $this->nonce,
					'vi_at_index'        => $this->index,
					'orders_per_request' => isset( $_POST['aftership_orders_tracking_orders_per_request'] ) ? absint( sanitize_text_field( $_POST['aftership_orders_tracking_orders_per_request'] ) ) : '1',
					'custom_start'       => isset( $_POST['aftership_orders_tracking_custom_start'] ) ? sanitize_text_field( $_POST['aftership_orders_tracking_custom_start'] ) : 1,
					'required_fields'    => array(
						'order_id'        => esc_html__( 'Order ID', 'aftership-orders-tracking' ),
						'tracking_number' => esc_html__( 'Tracking Number', 'aftership-orders-tracking' ),
						'carrier_slug'    => esc_html__( 'Carrier Slug', 'aftership-orders-tracking' ),
					),
				)
			);
		}
	}

	/**
	 * Import csv UI
	 */
	public function import_csv_callback() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Import Tracking From CSV file', 'aftership-orders-tracking' ); ?></h2>
			<?php
			$steps_state = array(
				'start'   => '',
				'mapping' => '',
				'import'  => '',
			);
			if ( $this->step == 'mapping' ) {
				$steps_state['start']   = '';
				$steps_state['mapping'] = 'active';
				$steps_state['import']  = 'disabled';
			} elseif ( $this->step == 'import' ) {
				$steps_state['start']   = '';
				$steps_state['mapping'] = '';
				$steps_state['import']  = 'active';
			} else {
				$steps_state['start']   = 'active';
				$steps_state['mapping'] = 'disabled';
				$steps_state['import']  = 'disabled';
			}
			?>
			<div class="vi-ui segment">
				<div class="vi-ui steps fluid">
					<div class="step <?php echo esc_attr( $steps_state['start'] ); ?>">
						<i class="upload icon"></i>
						<div class="content">
							<div class="title"><?php esc_html_e( 'Select file', 'aftership-orders-tracking' ); ?></div>
						</div>
					</div>
					<div class="step <?php echo esc_attr( $steps_state['mapping'] ); ?>">
						<i class="exchange icon"></i>
						<div class="content">
							<div class="title"><?php esc_html_e( 'Mapping', 'aftership-orders-tracking' ); ?></div>
						</div>
					</div>
					<div class="step <?php echo esc_attr( $steps_state['import'] ); ?>">
						<i class="refresh icon <?php echo esc_attr( self::set( 'import-icon' ) ); ?>"></i>
						<div class="content">
							<div class="title"><?php esc_html_e( 'Import', 'aftership-orders-tracking' ); ?></div>
						</div>
					</div>
				</div>
				<?php
				if ( isset( $_REQUEST['vi_at_error'] ) ) {
					$file_url = isset( $_REQUEST['file_url'] ) ? urldecode( wp_unslash( wc_clean( $_REQUEST['file_url'] ) ) ) : '';
					?>
					<div class="vi-ui negative message">
						<div class="header">
							<?php
							switch ( $_REQUEST['vi_at_error'] ) {
								case 1:
									esc_html_e( 'Please set mapping for all required fields', 'aftership-orders-tracking' );
									break;
								case 2:
									if ( $file_url ) {
										echo wp_kses_post( __( "Can not open file: <strong>{$file_url}</strong>", 'aftership-orders-tracking' ) );
									} else {
										esc_html_e( 'Can not open file', 'aftership-orders-tracking' );
									}
									break;
								default:
									if ( $file_url ) {
										echo wp_kses_post( __( "File not exists: <strong>{$file_url}</strong>", 'aftership-orders-tracking' ) );
									} else {
										esc_html_e( 'File not exists', 'aftership-orders-tracking' );
									}
							}
							?>
						</div>
					</div>
					<?php
				}
				if ( $this->error ) {
					?>
					<div class="vi-ui negative message">
						<div class="header">
							<?php echo esc_html( $this->error ); ?>
						</div>
					</div>
					<?php
				}
				switch ( $this->step ) {
					case 'mapping':
						?>
						<form class="<?php echo esc_attr( self::set( 'import-container-form' ) ); ?> vi-ui form"
							  method="post"
							  enctype="multipart/form-data"
							  action="
							  <?php
								echo esc_attr(
									remove_query_arg(
										array(
											'step',
											'file_url',
											'vi_at_error',
										)
									)
								)
								?>
							  ">
							<?php
							wp_nonce_field( 'aftership_orders_tracking_import_action_nonce', '_aftership_orders_tracking_import_nonce' );

							?>
							<div class="vi-ui segment">
								<table class="form-table">
									<thead>
									<tr>
										<th><?php esc_html_e( 'Column name', 'aftership-orders-tracking' ); ?></th>
										<th><?php esc_html_e( 'Map to field', 'aftership-orders-tracking' ); ?></th>
									</tr>
									</thead>
									<tbody>
									<?php
									$required_fields = array(
										'order_id',
										'tracking_number',
										'carrier_slug',
									);
									$headers         = array(
										'order_id'        => esc_html__( 'Order ID', 'aftership-orders-tracking' ),
										'tracking_number' => esc_html__( 'Tracking Number', 'aftership-orders-tracking' ),
										'carrier_slug'    => esc_html__( 'Carrier Slug', 'aftership-orders-tracking' ),
									);
									$description     = array(
										'order_id'        => '',
										'tracking_number' => '',
										'carrier_slug'    => '',
									);
									foreach ( $headers as $header_k => $header_v ) {
										?>
										<tr>
											<td>
												<select id="<?php echo esc_attr( self::set( $header_k ) ); ?>"
														class="vi-ui fluid dropdown"
														disabled="disabled"
														name="<?php echo esc_attr( self::set( 'map_to', true ) ); ?>[<?php echo esc_attr( $header_k ); ?>]">
													<?php
													foreach ( $this->header as $file_header ) {
														$selected = '';
														if ( strpos( strtolower( $file_header ), strtolower( $header_v ) ) !== false ) {
															$selected = 'selected';
														}
														?>
														<option value="<?php echo esc_attr( urlencode( $file_header ) ); ?>"<?php echo esc_attr( $selected ); ?>><?php echo esc_html( $file_header ); ?></option>
														<?php
													}
													?>
												</select>
											</td>
											<td>
												<?php
												$label = $header_v;
												if ( in_array( $header_k, $required_fields ) ) {
													$label .= '<strong>(*Required)</strong>';
												}
												?>
												<label for="<?php echo esc_attr( self::set( $header_k ) ); ?>"><?php echo wp_kses_post( $label ); ?></label>
											</td>
										</tr>
										<?php
										if ( ! empty( $description[ $header_k ] ) ) {
											?>
											<tr class="description">
												<td colspan="2">
													<div class="vi-ui blue small message">
														<div class="list"><?php echo esc_html( $description[ $header_k ] ); ?></div>
													</div>
												</td>
											</tr>
											<?php
										}
									}
									?>
									</tbody>
								</table>
							</div>
							<input type="hidden" name="aftership_orders_tracking_file_url"
								   value="<?php echo esc_attr( $this->file_url ); ?>">
							<p>
								<input type="submit" name="aftership_orders_tracking_import"
									   class="vi-ui primary button <?php echo esc_attr( self::set( 'import-continue' ) ); ?>"
									   value="<?php echo esc_attr( 'Import', 'aftership-orders-tracking' ); ?>">
							</p>
						</form>
						<?php
						break;
					case 'import':
						?>
						<div>
							<div class="vi-ui indicating progress standard <?php echo esc_attr( self::set( 'import-progress' ) ); ?>">
								<div class="label"><?php esc_html_e( 'Import tracking numbers', 'aftership-orders-tracking' ); ?></div>
								<div class="bar">
									<div class="progress"></div>
								</div>
							</div>
						</div>
						<?php
						break;
					default:
						?>
						<form class="<?php echo esc_attr( self::set( 'import-container-form' ) ); ?> vi-ui form"
							  method="post"
							  enctype="multipart/form-data">
							<?php
							wp_nonce_field( 'aftership_orders_tracking_import_action_nonce', '_aftership_orders_tracking_import_nonce' );
							?>
							<div class="vi-ui positive message <?php echo esc_attr( self::set( 'import-container' ) ); ?>">
								<div class="header">
									<label for="<?php echo esc_attr( self::set( 'import-file' ) ); ?>"><?php esc_html_e( 'Select csv file to import', 'aftership-orders-tracking' ); ?></label>
								</div>
								<ul class="list">
									<li><?php echo wp_kses_post( __( 'Your csv file should have following columns:<strong>Order id</strong>, <strong>Tracking number</strong>, <strong>Carrier slug</strong>.', 'aftership-orders-tracking' ) ); ?></li>
									<li>
										<?php echo wp_kses_post( __( '<strong>Carrier slug</strong>: slug of an carrier defined in plugin settings, get <strong>selected Carrier slug list</strong> by ', 'aftership-orders-tracking' ) ); ?>
										<input type="submit"
											   class="vi-ui button green vi-aftership-orders-tracking-download-carriers-file"
											   name="aftership_orders_tracking_download_carriers_file"
											   value="<?php echo esc_attr( 'Download File', 'aftership-orders-tracking' ); ?>">
										<?php printf( wp_kses_post( __( 'If you can not find your carrier, please go to <a target="_blank" href="%s">Plugin settings</a> to Add Carrier', 'aftership-orders-tracking' ) ), esc_url( admin_url( 'admin.php?page=aftership-setting-admin' ) ) ); ?>
									</li>
									<li>
										<?php esc_html_e( 'Each tracking number, carrier slug of an order will be set for every product line item of that order', 'aftership-orders-tracking' ); ?>
										<input type="submit"
											   class="vi-ui button olive vi-aftership-orders-tracking-download-demo-file"
											   name="aftership_orders_tracking_download_demo_file"
											   value="<?php echo esc_attr( 'Download Demo', 'aftership-orders-tracking' ); ?>">
									</li>
								</ul>
							</div>
						</form>
						<form class="<?php echo esc_attr( self::set( 'import-container-form' ) ); ?> vi-ui form"
							  method="post"
							  enctype="multipart/form-data">
							<?php
							wp_nonce_field( 'aftership_orders_tracking_import_action_nonce', '_aftership_orders_tracking_import_nonce' );

							?>
							<div class="<?php echo esc_attr( self::set( 'import-container' ) ); ?>">
								<div>
									<input type="file" name="aftership_orders_tracking_file"
										   id="<?php echo esc_attr( self::set( 'import-file' ) ); ?>"
										   class="<?php echo esc_attr( self::set( 'import-file' ) ); ?>"
										   accept=".csv"
										   required>
								</div>
							</div>
							<p><input type="submit" name="aftership_orders_tracking_select_file"
									  class="vi-ui primary button <?php echo esc_attr( self::set( 'import-continue' ) ); ?>"
									  value="<?php echo esc_attr( 'Continue', 'aftership-orders-tracking' ); ?>">
							</p>
						</form>
						<?php
						$logs     = array( 'import_tracking', 'debug' );
						$log_html = '';
						foreach ( $logs as $log ) {
							if ( is_file( AFTERSHIP_TRACKING_CACHE . "{$log}.txt" ) ) {
								ob_start();
								self::print_log_html( array( AFTERSHIP_TRACKING_CACHE . "{$log}.txt" ) );
								$log_html .= ob_get_clean();
							}
						}
				}
				?>
			</div>
			<?php
			if ( isset( $log_html ) && $log_html ) {
				?>
				<div class="vi-ui segment">
					<h3><?php esc_html_e( 'Import tracking logs', 'aftership-orders-tracking' ); ?></h3>
					<?php
					echo wp_kses_post( $log_html );
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}

	/**
	 * @param $logs
	 */
	public static function print_log_html( $logs ) {
		if ( is_array( $logs ) && count( $logs ) ) {
			foreach ( $logs as $log ) {
				?>
				<p>
					<a target="_blank" rel="nofollow" class="vi-ui button olive vi-aftership-orders-tracking-download-demo-file"
					   href="
					   <?php
						echo esc_url(
							add_query_arg(
								array(
									'action'     => 'vi_at_view_log',
									'vi_at_file' => urlencode( $log ),
									'_wpnonce'   => wp_create_nonce( 'vi_at_view_log' ),
								),
								admin_url( 'admin-ajax.php' )
							)
						)
						?>
					   "><?php esc_html_e( 'View Logs', 'aftership-orders-tracking' ); ?>
					</a>
				</p>
				<?php
			}
		}
	}

}
