<?php

/**
 * Plugin Name: SnazzyAdmin WP Admin Theme
 * Plugin URI: https://snazzythemes.com/snazzyadmin
 * Description: Fresh, elegant and snazzy themes for your wordpress Admin. Turn Wordpress Admin into something beautiful. 
 * Version: 1.0.2
 * Author: SnazzyThemes
 * Author URI: https://snazzythemes.com
 * Text domain: snazzy_admin 
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
 
 defined( 'ABSPATH' ) or exit;
 
 // Create a helper function for easy SDK access.
function swat_fs() {
    global $swat_fs;

    if ( ! isset( $swat_fs ) ) {
        // Include Freemius SDK.
        require_once dirname(__FILE__) . '/freemius/start.php';

        $swat_fs = fs_dynamic_init( array(
            'id'                  => '1709',
            'slug'                => 'snazzyadmin-wp-admin-theme',
            'type'                => 'plugin',
            'public_key'          => 'pk_c9284dc7c0aa1720e6f5fb52c47de',
            'is_premium'          => false,
            'has_addons'          => false,
            'has_paid_plans'      => false,
            'menu'                => array(
                'first-path'     => 'plugins.php',
                'account'        => false,
                'contact'        => false,
                'support'        => false,
            ),
        ) );
    }

    return $swat_fs;
}

// Init Freemius.
swat_fs();
// Signal that SDK was initiated.
do_action( 'swat_fs_loaded' );
 
 /**
 * Required functions
 */

class st_snazzy_admin {
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array($this, 'global_scripts'));
        
        add_action( 'admin_head', array($this, 'custom_header_markup'));
        
        add_action( 'admin_post_st_settings_update', array($this, 'settings_update'));
        
        add_action( 'show_user_profile', array($this, 'st_additional_user_fields'));
        
        add_action( 'admin_head', array($this, 'st_dynamic_css'), 10, 1 );
        
        add_action( 'edit_user_profile', array($this, 'st_additional_user_fields'));
        
        add_action( 'user_new_form', array($this, 'st_additional_user_fields'));
        
        add_action( 'personal_options_update', array($this, 'save_additional_user_meta'));
        
        add_action( 'edit_user_profile_update', array($this, 'save_additional_user_meta'));
        
        add_action( 'user_register', array($this, 'save_additional_user_meta'));
        
        add_action( 'login_enqueue_scripts', array($this, 'st_login_styles'));

}
    
    public function global_scripts() {
    wp_enqueue_media();
    wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style('st-default-stylesheet', plugins_url('global/css/default.css', __FILE__));
	wp_enqueue_script('st_admin_scripts', plugins_url('global/js/default.js', __FILE__), array('jquery' , 'wp-color-picker'), null, true);
    }
    
    public function custom_header_markup() {
        echo '<div class="st-preloader"><figure><div class="dot white"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></figure></div>';
        
    }
    
   /**
 * Adds additional user fields
 * more info: http://justintadlock.com/archives/2009/09/10/adding-and-using-custom-user-profile-fields
 */
 
public function st_additional_user_fields( $user ) { ?>
 
    <h3><?php _e( 'Snazzythemes Options', 'snazzy_admin' ); ?></h3>
 
    <table class="form-table add-user-meta">
 
        <tr>
            <th><label for="user_meta_image"><?php _e( 'Snazzy Profile Image', 'snazzy_admin' ); ?></label></th>
            <td>
                <!-- Outputs the image after save -->
                <img id="st_user_img_preview" src="<?php echo esc_url( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" style="width:150px;"><br />
                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <input type="text" name="user_meta_image" id="user_meta_image" value="<?php echo esc_url_raw( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" class="regular-text" />
                <!-- Outputs the save button -->
                <input type='button' class="additional-user-image button-primary" value="<?php _e( 'Upload Image', 'snazzy_admin' ); ?>" id="uploadimage"/><br />
                <span class="description"><?php _e( 'Upload an additional image for your user profile to replace gravatar.', 'snazzy_admin' ); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_cover_image"><?php _e( 'Snazzy Cover Image', 'snazzy_admin' ); ?></label></th>
            <td>
                <!-- Outputs the image after save -->
                <img id="st_cover_img_preview" src="<?php echo esc_url( get_the_author_meta( 'user_cover_image', $user->ID ) ); ?>" style="height:150px;width:auto;"><br />
                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <input type="text" name="user_cover_image" id="user_cover_image" value="<?php echo esc_url_raw( get_the_author_meta( 'user_cover_image', $user->ID ) ); ?>" class="regular-text" />
                <!-- Outputs the save button -->
                <input type='button' class="additional-cover-image button-primary" value="<?php _e( 'Upload Image', 'snazzy_admin' ); ?>" id="uploadimage2"/><br />
                <span class="description"><?php _e( 'Upload cover image for your profile to replace default image', 'snazzy_admin' ); ?></span>
            </td>
        </tr>
        <tr>
			<th><label for="st_primary_color">Primary Color</label></th>

			<td>
				<input type="text" name="st_primary_color" id="st_primary_color" value="<?php echo esc_attr( get_the_author_meta( 'st_primary_color', $user->ID ) ); ?>" class="color-field" /><br />
				<span class="description">Please choose Primary Color for your backend</span>
			</td>
		</tr>
        <tr>
			<th><label for="st_secondary_color">Secondary Color</label></th>

			<td>
				<input type="text" name="st_secondary_color" id="st_secondary_color" value="<?php echo esc_attr( get_the_author_meta( 'st_secondary_color', $user->ID ) ); ?>" class="color-field" /><br />
				<span class="description">Please choose Secondary Color for your backend</span>
			</td>
		</tr>
 
    </table><!-- end form-table -->
<?php } // additional_user_fields
 



/**
* Saves additional user fields to the database
*/
public function save_additional_user_meta( $user_id ) {
 
    // only saves if the current user can edit user profiles
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
 
    update_user_meta( $user_id, 'user_meta_image', esc_url($_POST['user_meta_image']) );
    update_user_meta( $user_id, 'user_cover_image', esc_url($_POST['user_cover_image']) );
    update_user_meta( $user_id, 'st_primary_color', sanitize_hex_color($_POST['st_primary_color']) );
    update_user_meta( $user_id, 'st_secondary_color', sanitize_hex_color($_POST['st_secondary_color']) );
}

public function st_dynamic_css() {
    $current_user = wp_get_current_user();
    $cover_photo = get_user_meta( $current_user->ID, 'user_cover_image', true );
    $color_scheme = get_user_meta( $current_user->ID, 'st_primary_color', true );
    $sec_color_scheme = get_user_meta( $current_user->ID, 'st_secondary_color', true );
	echo '<style>';
	if( filter_var( $cover_photo, FILTER_VALIDATE_URL ) ) {
	echo 'body.loading-complete:after {
	            background-image: url('. esc_url( $cover_photo ) .');
	            
	        }
	        ';    
    }
    if(strpos($color_scheme, '#') !== false) {
	echo '.wp-core-ui .button-primary, #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, #adminmenu li.current a.menu-top, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, .folded #adminmenu li.current.menu-top, .folded #adminmenu li.wp-has-current-submenu,
	        #adminmenu div.wp-menu-name:hover,
            #adminmenu .current div.wp-menu-name,
            #adminmenu .wp-menu-open div.wp-menu-name,
            .wrap .wp-heading-inline+.page-title-action {
	            background-color: '. $color_scheme .';
	            
	        }
	        body a,
	        #wpadminbar .quicklinks .menupop ul li .ab-item, #wpadminbar .quicklinks .menupop ul li a strong, #wpadminbar .quicklinks .menupop.hover ul li .ab-item, #wpadminbar .shortlink-input, #wpadminbar.nojs .quicklinks .menupop:hover ul li .ab-item,
	        #adminmenu .wp-submenu a,
	        #adminmenu .opensub .wp-submenu li.current a, #adminmenu .wp-submenu li.current, #adminmenu .wp-submenu li.current a, #adminmenu .wp-submenu li.current a:focus, #adminmenu .wp-submenu li.current a:hover, #adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a {
	            color: '. $color_scheme .';
	            }';    
    }
    if(strpos($sec_color_scheme, '#') !== false) {
	echo 'body a:active, body a:hover,
	        #adminmenu .wp-submenu a:focus, #adminmenu .wp-submenu a:hover, #adminmenu a:hover, #adminmenu li.menu-top > a:focus {
                color: '. $sec_color_scheme .';
            }
            .wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover,
            .wp-core-ui .button-primary.active, .wp-core-ui .button-primary.active:focus, .wp-core-ui .button-primary.active:hover, .wp-core-ui .button-primary:active {
              background-color: '. $sec_color_scheme .';
            }';    
    }
	 echo '</style>';  
}
function st_login_styles() { 
    $cover_photoL = get_user_meta( $current_user->ID, 'user_cover_image', true );
    echo '<style>
            body.login {
               background-image: url('. plugins_url('global/img/bg-2.png', __FILE__) .'); 
            }
            body.login form#loginform {
                background: rgba(255,255,255,0.15);
            }
            body.login #backtoblog a, body.login #nav a {
                text-decoration: none;
                color: #fff;
            }
            body.login form#loginform input#user_login, body.login form#loginform input#user_pass {
                background: rgba(255,255,255,0.4);
                border: none;
                color: #fff;
            }
            body.login form#loginform label {
                color: #fff;
            }
          </style>';
}
}

$st_snazzy_admin = new st_snazzy_admin();


add_filter( 'get_avatar', 'slug_get_avatar', 10, 5 );
function slug_get_avatar( $avatar, $id_or_email, $size, $default, $alt ) {

   
    if( ! is_numeric( $id_or_email ) ){
        return $avatar;
    }

    //Find URL of saved avatar in user meta
    $saved = get_user_meta( $id_or_email, 'user_meta_image', true );
    //check if it is a URL
    if( filter_var( $saved, FILTER_VALIDATE_URL ) ) {
        //return saved image
        return sprintf( '<img src="%s"/>', esc_url( $saved ) );
    }

    //return normal
    return $avatar;

}
