<?php
/**
 * Plugin Name:     Ultimate Member - Custom Username Field
 * Description:     Extension to Ultimate Member for selecting custom field as Username.
 * Version:         1.0.0
 * Requires PHP:    7.4
 * Author:          Miss Veronica
 * License:         GPL v2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Author URI:      https://github.com/MissVeronica
 * Text Domain:     ultimate-member
 * Domain Path:     /languages
 * UM version:      2.5.0
 */


if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'UM' ) ) return;

class UM_Custom_Username_Field {

    public $custom_username = '';

    function __construct( ) {

        add_filter( 'um_add_user_frontend_submitted', array( $this, 'um_add_user_frontend_submitted_custom_username_field' ), 10, 1 );
        add_filter( 'pre_user_login',                 array( $this, 'pre_user_login_as_custom_username_field' ), 10, 1 );
        add_filter( 'um_settings_structure',          array( $this, 'um_settings_structure_custom_username_field' ), 10, 1 );
    }

    public function um_add_user_frontend_submitted_custom_username_field( $args ) {

        $meta_key = trim( sanitize_text_field( UM()->options()->get( 'custom_username_field' )));

        if ( ! empty( $meta_key ) && isset( $args[$meta_key] ) && ! empty( $args[$meta_key] )) {
            $this->custom_username = trim( sanitize_user( strtolower( remove_accents( $args[$meta_key] ) ), true ));
        }

        return $args;
    }

    public function pre_user_login_as_custom_username_field( $user_login ) {

        if ( ! empty( $this->custom_username ) ) {

            $count = 1;
            $temp_user_login = $this->custom_username;

            while ( username_exists( $temp_user_login ) ) {
                $temp_user_login = $this->custom_username . $count;
                $count++;
            }
            $user_login = $temp_user_login;            
        }

        return $user_login;
    }

    function um_settings_structure_custom_username_field( $settings ) {

        $settings['appearance']['sections']['registration_form']['fields'][] = array(
            'id'      => 'custom_username_field',
            'type'    => 'text',
            'label'   => __( 'Custom Username Field - UM meta_key', 'ultimate-member' ),
            'tooltip' => __( 'UM meta_key name to be used as Username. Examples: first_name or last_name', 'ultimate-member' ),
            'size'    => 'small'
        ); 
   
        return $settings;
    }

}

new UM_Custom_Username_Field();
