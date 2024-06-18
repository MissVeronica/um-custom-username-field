<?php
/**
 * Plugin Name:     Ultimate Member - Extra Custom Username Field
 * Description:     Extension to Ultimate Member for selecting an extra Registration Custom field for Login.
 * Version:         1.2.0
 * Requires PHP:    7.4
 * Author:          Miss Veronica
 * License:         GPL v2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Author URI:      https://github.com/MissVeronica
 * Text Domain:     ultimate-member
 * Domain Path:     /languages
 * UM version:      2.8.6
 */


if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'UM' ) ) return;

class UM_Custom_Username_Field {

    public $custom_username = '';

    function __construct( ) {

        add_filter( 'um_submit_form_data',   array( $this, 'um_add_user_frontend_submitted_custom_username_field' ), 10, 3 );
        add_filter( 'um_settings_structure', array( $this, 'um_settings_structure_custom_username_field' ), 10, 1 );
    }

    public function um_add_user_frontend_submitted_custom_username_field( $post_form, $mode, $all_cf_metakeys  ) {

        if ( $mode == 'login' && in_array( 'username', $all_cf_metakeys )) {

            $custom_username_field = trim( sanitize_text_field( UM()->options()->get( 'custom_username_field' )));

            if ( ! empty( $custom_username_field ) ) {

                $meta_args = array(
                                    'meta_key'     => $custom_username_field,
                                    'meta_value'   => $post_form['username'],
                                    'meta_compare' => '='
                                );

                $user_query = new WP_User_Query( $meta_args );
                $user_data = $user_query->get_results();

                if ( ! empty( $user_data )) {
                    if ( count( $user_data ) == 1 ) {
                        $user_data = $user_data[0];
                        $post_form['username'] = $user_data->user_login;
                        $post_form['submitted']['username'] = $user_data->user_login;

                    } else {
                        UM()->form()->add_error( 'username', __( 'There are more than one user registered with this ID', 'ultimate-member' ) );
                    }
                }
            }
        }

        return $post_form;
    }

    function um_settings_structure_custom_username_field( $settings_structure ) {

        $settings_structure['appearance']['sections']['registration_form']['form_sections']['custom_username_field']['title']       = __( 'Extra Custom Username Field', 'ultimate-member' );
        $settings_structure['appearance']['sections']['registration_form']['form_sections']['custom_username_field']['description'] = __( 'Plugin version 1.1.0 - tested with UM 2.8.6', 'ultimate-member' );

        $settings_structure['appearance']['sections']['registration_form']['form_sections']['custom_username_field']['fields'][] = array(
            'id'          => 'custom_username_field',
            'type'        => 'text',
            'label'       => __( 'UM meta_key', 'ultimate-member' ),
            'description' => __( 'UM meta_key name to be used as an extra Username field for Login. Examples: um_unique_membership_id or um_unique_account_id', 'ultimate-member' ),
            'size'        => 'small'
        ); 

        return $settings_structure;
    }

}

new UM_Custom_Username_Field();
