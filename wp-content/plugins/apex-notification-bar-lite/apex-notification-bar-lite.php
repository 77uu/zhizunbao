<?php defined('ABSPATH') or die('No script kiddies please!');
/*
  Plugin Name: Apex Notification Bar Lite
  Plugin URI:  https://accesspressthemes.com/wordpress-plugins/apex-notification-bar-lite/
  Description: An advanced notification bar plugin used to create attractive single notification bar with specific position for your site.
  Version:     2.0.2
  Author:      AccessPress Themes
  Author URI:  http://accesspressthemes.com
  License:     GPL2
  Domain Path: /languages/
  Text Domain: apexnb-lite
 */

/**
 * Declaration of necessary constants
 * */
defined('APEXNBL_IMAGE_DIR') or define('APEXNBL_IMAGE_DIR', plugin_dir_url(__FILE__) . 'images');
defined('APEXNBL_ICONS_DIR') or define('APEXNBL_ICONS_DIR', plugin_dir_url(__FILE__) . 'images/icon-sets');
defined('APEXNBL_JS_DIR') or define('APEXNBL_JS_DIR', plugin_dir_url(__FILE__) . 'js');
defined('APEXNBL_CSS_DIR') or define('APEXNBL_CSS_DIR', plugin_dir_url(__FILE__) . 'css');
defined('APEXNBL_CLASS_DIR') or define('APEXNBL_CLASS_DIR', dirname(__FILE__) . '/class');
defined('APEXNBL_CLASS_DIR_PAGINATION') or define('APEXNBL_CLASS_DIR_PAGINATION', plugin_dir_url(__FILE__) . 'inc/backend/main_setup/');
defined('APEXNBL_PLUGIN_FILE') or define('APEXNBL_PLUGIN_FILE', __FILE__);
defined('APEXNBL_VERSION') or define('APEXNBL_VERSION', '2.0.2');
defined('APEXNBL_TITLE') or define('APEXNBL_TITLE', 'APEX NOTIFICATION BAR LITE');
defined('APEXNBL_TD') or define('APEXNBL_TD', 'apexnb-lite');
defined('APEXNBL_BXSLIDER_VERSION') or define('APEXNBL_BXSLIDER_VERSION', '4.1.2');
defined('APEXNBL_TICKER_MARQUE_VERSION') or define('APEXNBL_TICKER_MARQUE_VERSION', '2.0.0');
defined('APEXNBL_PAGE_LIMIT') or define('APEXNBL_PAGE_LIMIT', '50');

defined('APEXNBL_LITE_PATH') or define('APEXNBL_LITE_PATH', plugin_dir_path(__FILE__));
defined('APEXNBL_BACKEND_PATH') or define('APEXNBL_BACKEND_PATH', plugin_dir_url(__FILE__) . 'inc/backend/');
defined('APEXNBL_FRONTEND_PATH') or define('APEXNBL_FRONTEND_PATH', plugin_dir_url(__FILE__) . 'inc/frontend/');
defined('APEXNBL_LITE_URL') or define('APEXNBL_LITE_URL', plugin_dir_url(__FILE__)); //plugin directory url
if (!class_exists('APEXNBL_Class')) {

    class APEXNBL_Class {

        var $apexnb_lite_settings;

        /**
         * Initializes the plugin functions 
         */
        public function __construct() {
            $this->apexnb_lite_settings = get_option('apexnb_lite_settings');
            register_activation_hook(__FILE__, array($this, 'apexnb_lite_activation')); // Loads activating the Apex bar plugin
            $this->apexnb_includes_files();
            add_action('plugins_loaded', array($this, 'apexnb_lite_load_textdomain')); //add Load plugin textdomain.
            add_action('admin_menu', array($this, 'apexnb_lite_menu')); //Register The Plugin Menu
            add_action('admin_enqueue_scripts', array($this, 'apexnb_lite_admin_scripts')); //Registration of admin assets
            add_action('admin_post_apexnb_lite_settings_action', array($this, 'apexnb_lite_settings_action')); //recieves the posted values from settings form
            add_action('wp_footer', array($this, 'apexnb_lite_frontend_structure')); //Register The redirect function to frontend
            add_action('wp_enqueue_scripts', array($this, 'apexnb_lite_front_scripts'), 99); //Registration of Frontend assets
            add_action('wp_ajax_subscribe_ajax', array($this, 'apexnb_lite_subscribe_action_callback')); // Registration of subscribe ajax
            add_action('wp_ajax_nopriv_subscribe_ajax', array($this, 'apexnb_lite_subscribe_action_callback')); // Registration of subscribe ajax
            add_action( 'wp_ajax_contact_us_ajax', array($this,'contact_us_action_callback' )); // Registration of contact us ajax
            add_action( 'wp_ajax_nopriv_contact_us_ajax', array($this,'contact_us_action_callback' )); // Registration of contact us ajax
            add_action('template_redirect',array($this,'confirm_notification_subscribe')); // Registration of notification subscribe confirm
            add_action('admin_post_apexnb_lite_restore_default', array($this, 'apexnb_lite_restore_default')); //recieves the posted values from settings form

            add_action( 'admin_init', array( $this, 'redirect_to_site' ), 1 );
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
            add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ) );
        }

        function plugin_row_meta( $links, $file ){
            if ( strpos( $file, 'apex-notification-bar-lite.php' ) !== false ) {
                $new_links = array(
                    'demo' => '<a href="http://demo.accesspressthemes.com/wordpress-plugins/apex-notification-bar-lite" target="_blank"><span class="dashicons dashicons-welcome-view-site"></span>Live Demo</a>',
                    'doc' => '<a href="https://accesspressthemes.com/documentation/apex-notification-bar-lite/" target="_blank"><span class="dashicons dashicons-media-document"></span>Documentation</a>',
                    'support' => '<a href="http://accesspressthemes.com/support" target="_blank"><span class="dashicons dashicons-admin-users"></span>Support</a>',
                    'pro' => '<a href="https://accesspressthemes.com/wordpress-plugins/apex-notification-bar" target="_blank"><span class="dashicons dashicons-cart"></span>Premium version</a>'
                );
                $links = array_merge( $links, $new_links );
            }
            return $links;
        }


        function admin_footer_text( $text ){
          if ( isset( $_GET[ 'page' ] )) {
            if($_GET[ 'page' ] == 'apexnb-lite'){
                $link = 'https://wordpress.org/support/plugin/apex-notification-bar-lite/reviews/#new-post';
                $pro_link = 'https://accesspressthemes.com/wordpress-plugins/apex-notification-bar';
                $text = 'Enjoyed APEX NOTIFICATION BAR LITE? <a href="' . $link . '" target="_blank">Please leave us a ★★★★★ rating</a> We really appreciate your support! | Try premium version of <a href="' . $pro_link . '" target="_blank">APEX NOTIFICATION BAR</a> - more features, more power!';
                   return $text; 
                }
            } else {
                return $text;
            }
        }

      function redirect_to_site(){
            if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'apexlite-doclinks' ) {
                wp_redirect( 'https://accesspressthemes.com/documentation/apex-notification-bar-lite/' );
                exit();
            }
            if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'apexlite-premium' ) {
                wp_redirect( 'https://accesspressthemes.com/wordpress-plugins/apex-notification-bar' );
                exit();
            }
        }

        /*
         * Activating Plugin
         */

        function apexnb_lite_activation() {
           include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
           if (is_plugin_active('apex-notification-bar/apex-notification-bar.php')) {
             wp_die( __( 'You need to deactivate Apex Notification Bar Premium Plugin in order to 
              activate Apex Notification Bar Lite Free plugin. Please deactivate premium one. Your data will not be affected on deactivating.', APEXNBL_TD ) );
           }

            include('inc/backend/activation.php');
            /**
             * Load Default Settings
             * */
            if (!get_option('apexnb_lite_settings')) {
                $apexnb_lite_settings = $this->get_default_settings();
                update_option('apexnb_lite_settings', $apexnb_lite_settings);
            }

            /**
             * Google font save
             * */
            $family = array('ABeeZee', 'Abel', 'Abril Fatface', 'Aclonica', 'Acme', 'Actor', 'Adamina', 'Advent Pro', 'Aguafina Script', 'Akronim', 'Aladin', 'Aldrich', 'Alef', 'Alegreya', 'Alegreya SC', 'Alegreya Sans', 'Alegreya Sans SC', 'Alex Brush', 'Alfa Slab One', 'Alice', 'Alike', 'Alike Angular', 'Allan', 'Allerta', 'Allerta Stencil', 'Allura', 'Almendra', 'Almendra Display', 'Almendra SC', 'Amarante', 'Amaranth', 'Amatic SC', 'Amethysta', 'Amiri', 'Amita', 'Anaheim', 'Andada', 'Andika', 'Angkor', 'Annie Use Your Telescope', 'Anonymous Pro', 'Antic', 'Antic Didone', 'Antic Slab', 'Anton', 'Arapey', 'Arbutus', 'Arbutus Slab', 'Architects Daughter', 'Archivo Black', 'Archivo Narrow', 'Arimo', 'Arizonia', 'Armata', 'Artifika', 'Arvo', 'Arya', 'Asap', 'Asar', 'Asset', 'Astloch', 'Asul', 'Atomic Age', 'Aubrey', 'Audiowide', 'Autour One', 'Average', 'Average Sans', 'Averia Gruesa Libre', 'Averia Libre', 'Averia Sans Libre', 'Averia Serif Libre', 'Bad Script', 'Balthazar', 'Bangers', 'Basic', 'Battambang', 'Baumans', 'Bayon', 'Belgrano', 'Belleza', 'BenchNine', 'Bentham', 'Berkshire Swash', 'Bevan', 'Bigelow Rules', 'Bigshot One', 'Bilbo', 'Bilbo Swash Caps', 'Biryani', 'Bitter', 'Black Ops One', 'Bokor', 'Bonbon', 'Boogaloo', 'Bowlby One', 'Bowlby One SC', 'Brawler', 'Bree Serif', 'Bubblegum Sans', 'Bubbler One', 'Buda', 'Buenard', 'Butcherman', 'Butterfly Kids', 'Cabin', 'Cabin Condensed', 'Cabin Sketch', 'Caesar Dressing', 'Cagliostro', 'Calligraffitti', 'Cambay', 'Cambo', 'Candal', 'Cantarell', 'Cantata One', 'Cantora One', 'Capriola', 'Cardo', 'Carme', 'Carrois Gothic', 'Carrois Gothic SC', 'Carter One', 'Caudex', 'Cedarville Cursive', 'Ceviche One', 'Changa One', 'Chango', 'Chau Philomene One', 'Chela One', 'Chelsea Market', 'Chenla', 'Cherry Cream Soda', 'Cherry Swash', 'Chewy', 'Chicle', 'Chivo', 'Cinzel', 'Cinzel Decorative', 'Clicker Script', 'Coda', 'Coda Caption', 'Codystar', 'Combo', 'Comfortaa', 'Coming Soon', 'Concert One', 'Condiment', 'Content', 'Contrail One', 'Convergence', 'Cookie', 'Copse', 'Corben', 'Courgette', 'Cousine', 'Coustard', 'Covered By Your Grace', 'Crafty Girls', 'Creepster', 'Crete Round', 'Crimson Text', 'Croissant One', 'Crushed', 'Cuprum', 'Cutive', 'Cutive Mono', 'Damion', 'Dancing Script', 'Dangrek', 'Dawning of a New Day', 'Days One', 'Dekko', 'Delius', 'Delius Swash Caps', 'Delius Unicase', 'Della Respira', 'Denk One', 'Devonshire', 'Dhurjati', 'Didact Gothic', 'Diplomata', 'Diplomata SC', 'Domine', 'Donegal One', 'Doppio One', 'Dorsa', 'Dosis', 'Dr Sugiyama', 'Droid Sans', 'Droid Sans Mono', 'Droid Serif', 'Duru Sans', 'Dynalight', 'EB Garamond', 'Eagle Lake', 'Eater', 'Economica', 'Eczar', 'Ek Mukta', 'Electrolize', 'Elsie', 'Elsie Swash Caps', 'Emblema One', 'Emilys Candy', 'Engagement', 'Englebert', 'Enriqueta', 'Erica One', 'Esteban', 'Euphoria Script', 'Ewert', 'Exo', 'Exo 2', 'Expletus Sans', 'Fanwood Text', 'Fascinate', 'Fascinate Inline', 'Faster One', 'Fasthand', 'Fauna One', 'Federant', 'Federo', 'Felipa', 'Fenix', 'Finger Paint', 'Fira Mono', 'Fira Sans', 'Fjalla One', 'Fjord One', 'Flamenco', 'Flavors', 'Fondamento', 'Fontdiner Swanky', 'Forum', 'Francois One', 'Freckle Face', 'Fredericka the Great', 'Fredoka One', 'Freehand', 'Fresca', 'Frijole', 'Fruktur', 'Fugaz One', 'GFS Didot', 'GFS Neohellenic', 'Gabriela', 'Gafata', 'Galdeano', 'Galindo', 'Gentium Basic', 'Gentium Book Basic', 'Geo', 'Geostar', 'Geostar Fill', 'Germania One', 'Gidugu', 'Gilda Display', 'Give You Glory', 'Glass Antiqua', 'Glegoo', 'Gloria Hallelujah', 'Goblin One', 'Gochi Hand', 'Gorditas', 'Goudy Bookletter 1911', 'Graduate', 'Grand Hotel', 'Gravitas One', 'Great Vibes', 'Griffy', 'Gruppo', 'Gudea', 'Gurajada', 'Habibi', 'Halant', 'Hammersmith One', 'Hanalei', 'Hanalei Fill', 'Handlee', 'Hanuman', 'Happy Monkey', 'Headland One', 'Henny Penny', 'Herr Von Muellerhoff', 'Hind', 'Holtwood One SC', 'Homemade Apple', 'Homenaje', 'IM Fell DW Pica', 'IM Fell DW Pica SC', 'IM Fell Double Pica', 'IM Fell Double Pica SC', 'IM Fell English', 'IM Fell English SC', 'IM Fell French Canon', 'IM Fell French Canon SC', 'IM Fell Great Primer', 'IM Fell Great Primer SC', 'Iceberg', 'Iceland', 'Imprima', 'Inconsolata', 'Inder', 'Indie Flower', 'Inika', 'Inknut Antiqua', 'Irish Grover', 'Istok Web', 'Italiana', 'Italianno', 'Jacques Francois', 'Jacques Francois Shadow', 'Jaldi', 'Jim Nightshade', 'Jockey One', 'Jolly Lodger', 'Josefin Sans', 'Josefin Slab', 'Joti One', 'Judson', 'Julee', 'Julius Sans One', 'Junge', 'Jura', 'Just Another Hand', 'Just Me Again Down Here', 'Kadwa', 'Kalam', 'Kameron', 'Kantumruy', 'Karla', 'Karma', 'Kaushan Script', 'Kavoon', 'Kdam Thmor', 'Keania One', 'Kelly Slab', 'Kenia', 'Khand', 'Khmer', 'Khula', 'Kite One', 'Knewave', 'Kotta One', 'Koulen', 'Kranky', 'Kreon', 'Kristi', 'Krona One', 'Kurale', 'La Belle Aurore', 'Laila', 'Lakki Reddy', 'Lancelot', 'Lateef', 'Lato', 'League Script', 'Leckerli One', 'Ledger', 'Lekton', 'Lemon', 'Libre Baskerville', 'Life Savers', 'Lilita One', 'Lily Script One', 'Limelight', 'Linden Hill', 'Lobster', 'Lobster Two', 'Londrina Outline', 'Londrina Shadow', 'Londrina Sketch', 'Londrina Solid', 'Lora', 'Love Ya Like A Sister', 'Loved by the King', 'Lovers Quarrel', 'Luckiest Guy', 'Lusitana', 'Lustria', 'Macondo', 'Macondo Swash Caps', 'Magra', 'Maiden Orange', 'Mako', 'Mallanna', 'Mandali', 'Marcellus', 'Marcellus SC', 'Marck Script', 'Margarine', 'Marko One', 'Marmelad', 'Martel', 'Martel Sans', 'Marvel', 'Mate', 'Mate SC', 'Maven Pro', 'McLaren', 'Meddon', 'MedievalSharp', 'Medula One', 'Megrim', 'Meie Script', 'Merienda', 'Merienda One', 'Merriweather', 'Merriweather Sans', 'Metal', 'Metal Mania', 'Metamorphous', 'Metrophobic', 'Michroma', 'Milonga', 'Miltonian', 'Miltonian Tattoo', 'Miniver', 'Miss Fajardose', 'Modak', 'Modern Antiqua', 'Molengo', 'Molle', 'Monda', 'Monofett', 'Monoton', 'Monsieur La Doulaise', 'Montaga', 'Montez', 'Montserrat', 'Montserrat Alternates', 'Montserrat Subrayada', 'Moul', 'Moulpali', 'Mountains of Christmas', 'Mouse Memoirs', 'Mr Bedfort', 'Mr Dafoe', 'Mr De Haviland', 'Mrs Saint Delafield', 'Mrs Sheppards', 'Muli', 'Mystery Quest', 'NTR', 'Neucha', 'Neuton', 'New Rocker', 'News Cycle', 'Niconne', 'Nixie One', 'Nobile', 'Nokora', 'Norican', 'Nosifer', 'Nothing You Could Do', 'Noticia Text', 'Noto Sans', 'Noto Serif', 'Nova Cut', 'Nova Flat', 'Nova Mono', 'Nova Oval', 'Nova Round', 'Nova Script', 'Nova Slim', 'Nova Square', 'Numans', 'Nunito', 'Odor Mean Chey', 'Offside', 'Old Standard TT', 'Oldenburg', 'Oleo Script', 'Oleo Script Swash Caps', 'Open Sans', 'Open Sans Condensed', 'Oranienbaum', 'Orbitron', 'Oregano', 'Orienta', 'Original Surfer', 'Oswald', 'Over the Rainbow', 'Overlock', 'Overlock SC', 'Ovo', 'Oxygen', 'Oxygen Mono', 'PT Mono', 'PT Sans', 'PT Sans Caption', 'PT Sans Narrow', 'PT Serif', 'PT Serif Caption', 'Pacifico', 'Palanquin', 'Palanquin Dark', 'Paprika', 'Parisienne', 'Passero One', 'Passion One', 'Pathway Gothic One', 'Patrick Hand', 'Patrick Hand SC', 'Patua One', 'Paytone One', 'Peddana', 'Peralta', 'Permanent Marker', 'Petit Formal Script', 'Petrona', 'Philosopher', 'Piedra', 'Pinyon Script', 'Pirata One', 'Plaster', 'Play', 'Playball', 'Playfair Display', 'Playfair Display SC', 'Podkova', 'Poiret One', 'Poller One', 'Poly', 'Pompiere', 'Pontano Sans', 'Poppins', 'Port Lligat Sans', 'Port Lligat Slab', 'Pragati Narrow', 'Prata', 'Preahvihear', 'Press Start 2P', 'Princess Sofia', 'Prociono', 'Prosto One', 'Puritan', 'Purple Purse', 'Quando', 'Quantico', 'Quattrocento', 'Quattrocento Sans', 'Questrial', 'Quicksand', 'Quintessential', 'Qwigley', 'Racing Sans One', 'Radley', 'Rajdhani', 'Raleway', 'Raleway Dots', 'Ramabhadra', 'Ramaraja', 'Rambla', 'Rammetto One', 'Ranchers', 'Rancho', 'Ranga', 'Rationale', 'Ravi Prakash', 'Redressed', 'Reenie Beanie', 'Revalia', 'Rhodium Libre', 'Ribeye', 'Ribeye Marrow', 'Righteous', 'Risque', 'Roboto', 'Roboto Condensed', 'Roboto Mono', 'Roboto Slab', 'Rochester', 'Rock Salt', 'Rokkitt', 'Romanesco', 'Ropa Sans', 'Rosario', 'Rosarivo', 'Rouge Script', 'Rozha One', 'Rubik', 'Rubik Mono One', 'Rubik One', 'Ruda', 'Rufina', 'Ruge Boogie', 'Ruluko', 'Rum Raisin', 'Ruslan Display', 'Russo One', 'Ruthie', 'Rye', 'Sacramento', 'Sahitya', 'Sail', 'Salsa', 'Sanchez', 'Sancreek', 'Sansita One', 'Sarala', 'Sarina', 'Sarpanch', 'Satisfy', 'Scada', 'Scheherazade', 'Schoolbell', 'Seaweed Script', 'Sevillana', 'Seymour One', 'Shadows Into Light', 'Shadows Into Light Two', 'Shanti', 'Share', 'Share Tech', 'Share Tech Mono', 'Shojumaru', 'Short Stack', 'Siemreap', 'Sigmar One', 'Signika', 'Signika Negative', 'Simonetta', 'Sintony', 'Sirin Stencil', 'Six Caps', 'Skranji', 'Slabo 13px', 'Slabo 27px', 'Slackey', 'Smokum', 'Smythe', 'Sniglet', 'Snippet', 'Snowburst One', 'Sofadi One', 'Sofia', 'Sonsie One', 'Sorts Mill Goudy', 'Source Code Pro', 'Source Sans Pro', 'Source Serif Pro', 'Special Elite', 'Spicy Rice', 'Spinnaker', 'Spirax', 'Squada One', 'Sree Krushnadevaraya', 'Stalemate', 'Stalinist One', 'Stardos Stencil', 'Stint Ultra Condensed', 'Stint Ultra Expanded', 'Stoke', 'Strait', 'Sue Ellen Francisco', 'Sumana', 'Sunshiney', 'Supermercado One', 'Sura', 'Suranna', 'Suravaram', 'Suwannaphum', 'Swanky and Moo Moo', 'Syncopate', 'Tangerine', 'Taprom', 'Tauri', 'Teko', 'Telex', 'Tenali Ramakrishna', 'Tenor Sans', 'Text Me One', 'The Girl Next Door', 'Tienne', 'Tillana', 'Timmana', 'Tinos', 'Titan One', 'Titillium Web', 'Trade Winds', 'Trocchi', 'Trochut', 'Trykker', 'Tulpen One', 'Ubuntu', 'Ubuntu Condensed', 'Ubuntu Mono', 'Ultra', 'Uncial Antiqua', 'Underdog', 'Unica One', 'UnifrakturCook', 'UnifrakturMaguntia', 'Unkempt', 'Unlock', 'Unna', 'VT323', 'Vampiro One', 'Varela', 'Varela Round', 'Vast Shadow', 'Vesper Libre', 'Vibur', 'Vidaloka', 'Viga', 'Voces', 'Volkhov', 'Vollkorn', 'Voltaire', 'Waiting for the Sunrise', 'Wallpoet', 'Walter Turncoat', 'Warnes', 'Wellfleet', 'Wendy One', 'Wire One', 'Work Sans', 'Yanone Kaffeesatz', 'Yantramanav', 'Yellowtail', 'Yeseva One', 'Yesteryear', 'Zeyada');
            $apexnb_fonts = get_option('apexnb_fonts');
            if (empty($apexnb_fonts)) {
                update_option('apexnb_fonts', $family);
            }
        }

        /**
         * Returns Default Settings
         */
        public function get_default_settings() {
            $apexnb_lite_settings = array(
                'apexnblite_enable_bar' => '1',
                'apexnblite_enable_mobile' => '1',
                'edn_position' => 'top',
                'edn_notify_on_pages' => 'all_pages',
                'edn_notification_font' => 'Roboto',
                'edn_bgcolor' => '',
                'edn_font_color' => '',
                'edn_bar_type' => '2',
                'edn_bar_template' => '1',
                'edn_social_optons' => '1', //if edn_cp_type == social-icons then this is enable
                'edn_social_heading_text' => '',
                'edn_social_heading_color' => '',
                'icons_details' => array(),
                'edn_right_optons' => '0',
                'edn_cp_type' => '', // text, email-subs,post-title,search-form
                'edn_text_display_mode' => 'static',
                'edn_static' => array(),
                'edn_multi' => array(),
                'edn_subs_choose' => 'subs-c-form', //opt form only custom form
                'edn_subs_custom' => array(), //opt form only custom form data array field
                'edn_recentposts' => array('posts_per_page' => 5,
                    'edn_posttype_value' => 'post',
                    'edn_recentposts_orderby' => 'date',
                    'edn_recentposts_order' => 'desc',
                    'read_more_label' => 'Read More',
                    'read_more_target' => '_blank'
                ), //posts  : recent-posts
                'edn_search_form' => array(),
                'edn_bar_effect_option' => '2',
                'edn_ticker' => array(),
                'edn_slider' => array(),
                'edn_scroll' => array(),
                'edn_visibility' => 'sticky', // alys show as sticky, show-time, hide-time
                'edn_visibility_show_duration' => '10',
                'edn_visibility_hide_duration' => '10',
                'edn_close_button' => 'show-hide', // disable, show-hide,user-can-close
                'show_once' => '0'
            );
            return $apexnb_lite_settings;
        }

        /*
         * Includes All class Files
         */

        public function apexnb_includes_files() {
            /* library */
            require_once APEXNBL_LITE_PATH . 'inc/library/common-model.php';
            require_once APEXNBL_LITE_PATH . 'inc/library/database.php';
        }

        /**
         * Load plugin textdomain.
         *
         * @since 1.0.0
         */
        function apexnb_lite_load_textdomain() {
            load_plugin_textdomain(APEXNBL_TD, false, dirname(plugin_basename(__FILE__)) . '/languages');
        }

        /**
         * Plugin Menu Registration
         * */
        public function apexnb_lite_menu() {
            add_menu_page(__(APEXNBL_TITLE, APEXNBL_TD), __('Apex Notification Bar Lite', APEXNBL_TD), 'manage_options', APEXNBL_TD, array($this, 'main_page'), 'dashicons-microphone');
            add_submenu_page(APEXNBL_TD, __(APEXNBL_TITLE, APEXNBL_TD), __('Apex Notification Bar Lite', APEXNBL_TD), 'manage_options', APEXNBL_TD, array($this, 'main_page'));
            add_submenu_page(APEXNBL_TD, __( 'Documentation',APEXNBL_TD), __( 'Documentation', APEXNBL_TD ), 'manage_options', 'apexlite-doclinks', '__return_false', null, 9 );
            add_submenu_page(APEXNBL_TD, __( 'Check Premium Version', APEXNBL_TD ), __( 'Check Premium Version', APEXNBL_TD ), 'manage_options', 'apexlite-premium', '__return_false', null, 9 );
        }

        /**
         * plugin's main page
         * */
        function main_page() {
            include_once('inc/backend/notify-bar-setup/main_page.php');
        }

        /*
         * Registration of admin assets 
         */

        public function apexnb_lite_admin_scripts() {
            if (isset($_GET['page']) && $_GET['page'] == APEXNBL_TD) {

                $edn_pro_script_variable = array('icon_preview' => __('Icon Preview', APEXNBL_TD),
                    'icon_link' => __('Icon Link', APEXNBL_TD),
                    'icon_link_target' => __('Icon Link Target', APEXNBL_TD),
                    'icon_delete_confirm' => __('Are you sure you want to delete this icon from this list?', APEXNBL_TD),
                    'ajax_url' => admin_url() . 'admin-ajax.php',
                    'ajax_nonce' => wp_create_nonce('edn-ajax-nonce'),
                    'saving_msg' => __('Saving Data.', APEXNBL_TD),
                    'saved_msg' => __('Saved Data.', APEXNBL_TD),
                    'icon_collapse' => __('Collapse All', APEXNBL_TD),
                    'icon_expand' => __('Expand All', APEXNBL_TD),
                    'notification_bar_message' => __('Notification Message', APEXNBL_TD),
                    'link_but_text_label' => __('Link Button Text', APEXNBL_TD),
                    'link_but_url_label' => __('Link Button URL', APEXNBL_TD),
                    'link_but_target' => __('Link Target', APEXNBL_TD),
                    'name_label' => __('Name Label', APEXNBL_TD),
                    'email_label' => __('Email Label', APEXNBL_TD),
                    'name_required_label' => __('Name Required', APEXNBL_TD),
                    'email_required_label' => __('Email Required', APEXNBL_TD),
                    'msg_required_label' => __('Message Required', APEXNBL_TD),
                    'message_label' => __('Message Label', APEXNBL_TD),
                    'send_to_email_label' => __('Send To Email', APEXNBL_TD),
                    'name_placeholder_label' => __('Name Placeholder', APEXNBL_TD),
                    'email_placeholder_label' => __('Email Placeholder', APEXNBL_TD),
                    'message_placeholder_label' => __('Message Placeholder', APEXNBL_TD),
                    'name_error_message_label' => __('Name Error Message', APEXNBL_TD),
                    'email_error_message_label' => __('Email Error Message', APEXNBL_TD),
                    'msg_error_label' => __('Message Error Message', APEXNBL_TD),
                    'validemail_error_message_label' => __('Valid Email Error Message', APEXNBL_TD),
                    'success_message' => __('Success Message', APEXNBL_TD),
                    'send_fail_message' => __('Fail Email Message', APEXNBL_TD),
                    'contact_form7_label' => __('Contact Form 7 Shortcode', APEXNBL_TD),
                    'ajaxurl' => admin_url() . 'admin-ajax.php',
                    'ajaxnonce' => wp_create_nonce('edn-admin-ajax-nonce'));

                /**
                 * Backend CSS
                 * */
                wp_enqueue_style('apexnb-admin-style', APEXNBL_CSS_DIR . '/backend/backend.css', array(), APEXNBL_VERSION);
                wp_enqueue_style('apexnb-fontawesome-css', APEXNBL_CSS_DIR . '/font-awesome/font-awesome.min.css', false, APEXNBL_VERSION);
                wp_enqueue_style('wp-color-picker'); //for including color picker css
                /**
                 * Backend JS
                 * */
                wp_enqueue_script('apexnb-notification-bar-pro-webfont', APEXNBL_JS_DIR . '/backend/webfont.js');
                wp_enqueue_style('apexnb-custom-select-css', APEXNBL_CSS_DIR . '/backend/jquery.selectbox.css', array(), APEXNBL_VERSION);
                wp_enqueue_script('apexnb-custom-select-js', APEXNBL_JS_DIR . '/backend/jquery.selectbox-0.2.min.js', array('jquery'), APEXNBL_VERSION);
                wp_enqueue_script('apexnb-colorpicker-alphajs', APEXNBL_JS_DIR . '/backend/wp-color-picker-alpha.js', array('jquery'), APEXNBL_VERSION);
                wp_enqueue_script('apexnb-admin-script', APEXNBL_JS_DIR . '/backend/backend.js', array('jquery', 'jquery-ui-tabs', 'jquery-ui-sortable', 'wp-color-picker', 'jquery-ui-core'), APEXNBL_VERSION);
                wp_localize_script('apexnb-admin-script', 'edn_pro_script_variable', $edn_pro_script_variable); //localization of php variable in edn-pro-admin-js
            }
        }

        /**
         *  Saves settings to database
         * */
        public function apexnb_lite_settings_action() {
            global $wpdb; // this is how you get access to the database
            if (!empty($_POST) && wp_verify_nonce($_POST['apexnb_lite_nonce_field'], 'apexnb-lite-nonce')) {
                if (isset($_POST['settings_submit_btn'])) {
                    include_once('inc/backend/save-settings.php');
                } else if (isset($_POST['remove_subs'])) {
                    $table_name = $wpdb->prefix . 'apexnb_subscriber';
                    if (isset($_POST['rem'])) {
                        $si_id = array_map('sanitize_text_field', $_POST['rem']);
                        if (!$si_id == '') {
                            foreach ($si_id as $id) {
                                $wpdb->delete($table_name, array('id' => intval($id)), array('%d'));
                                wp_redirect(admin_url('admin.php?page=apexnb-lite&delete_message=1'));
                            }
                        } else {
                            wp_redirect(admin_url('admin.php?page=apexnb-lite&failed_message=1'));
                        }
                    } else {
                        wp_redirect(admin_url('admin.php?page=apexnb-lite&nodata=1'));
                    }
                } else if (isset($_POST['export_subs'])) {
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-disposition: attachment; filename='subscribers_" . date('YmdHis') . ".csv");
                    $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "apexnb_subscriber");
                    echo "Email, Date\r\n";
                    if (count($results)) {
                        foreach ($results as $row) {
                            $datee = $row->date;
                            echo $row->email . ", " . $datee . "\r\n";
                        }
                    } else {
                        $Error = $wpdb->print_error();
                        die("The following error was found: $Error");
                    }

                    exit;
                }
            } else {
                die('No script kiddies please!');
            }
        }

        /**
         * Function to redirect to notification bar 
         */
        public function apexnb_lite_frontend_structure() {
            include_once( 'inc/frontend/frontend.php' );
        }

        /**
         * Registration of Frontend assets 
         * */
        public function apexnb_lite_front_scripts() {

            // Subscribe Custom Form
            $success = __('Thank you for subscribing us.', APEXNBL_TD);
            $but_email_error_message = __('Please enter a valid email address.', APEXNBL_TD);
            $but_check_to_conform = __('Please check your mail to confirm.', APEXNBL_TD);
            $but_already_subs = __('You have already subscribed.', APEXNBL_TD);
            $but_sending_fail = __('Confirmation sending fail.', APEXNBL_TD);


            $edn_pro_script_variable = array(
                'success_note' => $success,
                'but_email_error_msg' => $but_email_error_message,
                'already_subs' => $but_already_subs,
                'sending_fail' => $but_sending_fail,
                'check_to_conform' => $but_check_to_conform,
                'ajax_url' => admin_url() . 'admin-ajax.php',
                'ajax_nonce' => wp_create_nonce('edn-front-ajax-nonce'));

            /* Css  Style */
            wp_enqueue_style('apexnb-font-awesome', APEXNBL_CSS_DIR . '/font-awesome/font-awesome.css', APEXNBL_VERSION);
            wp_enqueue_style('apexnb-frontend-style', APEXNBL_CSS_DIR . '/frontend/frontend.css', APEXNBL_VERSION);
            wp_enqueue_style('apexnb-responsive-stylesheet', APEXNBL_CSS_DIR . '/frontend/responsive.css', APEXNBL_VERSION);
            wp_enqueue_style('apexnb-frontend-bxslider-style', APEXNBL_CSS_DIR . '/frontend/jquery.bxslider.css', APEXNBL_VERSION);
            wp_enqueue_style('apexnb-lightbox-style', APEXNBL_CSS_DIR . '/frontend/prettyPhoto.css', false, APEXNBL_VERSION);
            /* JS Script */
            wp_enqueue_script('apexnb-frontend-bxslider-js', APEXNBL_JS_DIR . '/frontend/jquery.bxSlider.js', array('jquery'), APEXNBL_BXSLIDER_VERSION);

            //pretty photo js 
            wp_enqueue_script('apexnb-lightbox-script', APEXNBL_JS_DIR . '/frontend/jquery.prettyPhoto.js', array('jquery'), APEXNBL_VERSION);
            //same for ticker
            wp_enqueue_style('apexnb-frontend-scroller-style', APEXNBL_CSS_DIR . '/frontend/scroll-style.css');
            wp_enqueue_script('apexnb-frontend-scroller-js', APEXNBL_JS_DIR . '/frontend/jquery.scroller.js', array('jquery'), '2');
            wp_enqueue_script('apexnb-actual_scripts', APEXNBL_JS_DIR . '/frontend/jquery.actual.js', array('jquery'), APEXNBL_VERSION);
            wp_enqueue_script('apexnb-frontend-js', APEXNBL_JS_DIR . '/frontend/frontend.js', array('jquery'), APEXNBL_VERSION);
            wp_localize_script('apexnb-frontend-js', 'apexnblite_script_variable', $edn_pro_script_variable); //localization of php variable in edn-pro-frontend-js
        }

        /**
         * Function of subscribe ajax
         * custom subscribe form submission 
         * */
        public function apexnb_lite_subscribe_action_callback() {
            if (wp_verify_nonce($_POST['nonce'], 'edn-front-ajax-nonce')) {

                global $wpdb; // this is how you get access to the database
                $email = sanitize_email($_POST['email']);
                $ednbar = Database_Class::get_bar_data();
               
                $name = '';
                $confirm = sanitize_text_field($_POST['confirm']);
                $sitename = get_bloginfo('name');
                $subject = __("Subscribe Confirmation", APEXNBL_TD);
                $page_id = intval(sanitize_text_field($_POST['page_id']));
                $nonce = wp_create_nonce('newly-created-nonce');
                $date = date("Y-m-d H:i:s");
                $to = $email;
                $act_code = rand(0, 1000);

                $url = esc_url(get_permalink($page_id).'?subs_type=custom&page_idd='.$page_id.'&code='.$act_code.'&edn_subs_nonce_field='.$nonce.'&email='.$email);
                $message = "Thanks for Subscribing! Please Click the <a href='$url' target='_blank'>Confirm</a> link to get confirmed.";
                   

                $site_title = (isset($ednbar['edn_subs_custom']['from_name']) && $ednbar['edn_subs_custom']['from_name'] != '') ? esc_attr($ednbar['edn_subs_custom']['from_name']) : $sitename;
                $femail = (isset($ednbar['edn_subs_custom']['from_email']) && $ednbar['edn_subs_custom']['from_email'] != '') ? esc_attr($ednbar['edn_subs_custom']['from_email']) : "";

                $from = 'From:' . $site_title . ' <' . $femail . '>' . "\r\n";


                // To send HTML mail, the Content-type header must be set
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= $from;

                $table_name = $wpdb->prefix . 'apexnb_subscriber';
                $search_email = $wpdb->get_results(" SELECT * FROM $table_name WHERE email = '$email'");
                if ($confirm == 1) {
                    if ($search_email) {
                        die('aready'); // already subscribe
                        wp_redirect(get_permalink($page_id));
                        exit;
                    } else {
                        $mail = wp_mail($to, $subject, $message, $headers);
                        if ($mail) {
                            die('confirm');
                        } else {
                            die('fail');
                        }
                    }
                } else {
                    if ($search_email) {
                        die('aready'); // aready subscribe
                    } else {
                        $query = $wpdb->insert($table_name, array('email' => $email, 'date' => $date));
                        die('success');
                    }
                }
            } else {
                die('No script kiddies please!');
            }
            wp_die(); // this is required to terminate immediately and return a proper response
        }
        /**
          * Function to notification subscribe conform
          * */
          function confirm_notification_subscribe(){
           if (isset($_GET['edn_subs_nonce_field']) && wp_verify_nonce( $_GET['edn_subs_nonce_field'] ,'newly-created-nonce') ) {
            if(isset($_GET['subs_type']) && $_GET['subs_type']=='custom'){
                
                global $wpdb; // this is how you get access to the database
                $code = sanitize_text_field($_GET['code']);
                $email = sanitize_email($_GET['email']);
                $page_id = intval(sanitize_text_field($_GET['page_idd']));
                $check_valid_email = preg_match(
                            '/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $email
                    );
               $url = trim( get_permalink($page_id), "/" );
               
              if ($check_valid_email) {   
                $table_name = $wpdb->prefix . 'apexnb_subscriber';
                    $search_email = $wpdb->get_results( "SELECT * FROM $table_name WHERE email = '$email'");
                    if($search_email)
                    {
                       wp_redirect( $url.'?mpage=success&message=1' ); exit;
                        
                    }else{
                         $edn_bar_data = Database_Class::get_bar_data();
                        if(isset($edn_bar_data['edn_subs_custom']['thank_text'])){
                            $success = $edn_bar_data['edn_subs_custom']['thank_text'];
                        }else{
                            $success = __('Thank you for subscribing us.',APEXNBL_TD);
                        }
                        $date = date("Y-m-d H:i:s");
                        $wpdb->insert( $table_name, array( 'email' => $email ,'active_code'=>$code, 'date' => $date ) );
                        wp_redirect( $url.'?mpage=success&message=2' ); exit;
                        
                    }
                }else {
                   wp_redirect( $url.'?mpage=success&message=3' ); exit;
               }
            }
          
           }
          }
          
          /**
           * Function of Contact us ajax.
           * */
          public function contact_us_action_callback(){
                if(isset($_POST) && wp_verify_nonce($_POST['nonce'],'edn-front-ajax-nonce')){
                    
                    $name = sanitize_text_field($_POST['name']);
                    $email = sanitize_email($_POST['email']);
                    $formtype = sanitize_text_field($_POST['formtype']);
                    $id_array = sanitize_text_field($_POST['id_array']);
                    $user_message = sanitize_text_field($_POST['message']);
                    $site_name = site_url();
                    $ednbar =  Database_Class::get_bar_data();
                    $to_email = get_option( 'admin_email' );
                    if($formtype == "static"){
                    $to = (isset($ednbar['edn_static']['send_to_mail']) && $ednbar['edn_static']['send_to_mail'] != '')?esc_attr($ednbar['edn_static']['send_to_mail']):$to_email;
                    }else{
                    $to = (isset($ednbar['edn_multiple']['send_to_mail'][$id_array]) && $ednbar['edn_multiple']['send_to_mail'][$id_array] != '')?esc_attr($ednbar['edn_multiple']['send_to_mail'][$id_array]):$to_email;
                    }

                    $message = 'Hi there, <br/><br/>
                    You have got a new visitor at '.$site_name.'<br/><br/> 
                    <strong>Visitor Details :</strong> <br>
                    Name: '.$name.'<br/>
                    Email: '.$email.'<br/>Message: '.$user_message.'<br/><br/> Thank you.';
                     $subject = 'Enquiry from '.$name;
                     $headers  = "X-Mailer: php\n";
                     $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                     $headers .= 'From: '.$name.' <'.$email.'>' . "\r\n\\";
                     $headers .= 'Reply-To: $email' . "\r\n\\";
                     $headers .= 'X-Mailer: PHP/' . phpversion();
                    $mail = wp_mail( $to, $subject, $message, $headers );
                    if($mail){
                        die($mail);   
                    }else{
                        return false;
                    }
                }else{
                    die('No script kiddies please!');
                }
           }

        /**
         * Restores the default 
         */
        public function apexnb_lite_restore_default() {
            $nonce = sanitize_text_field($_REQUEST['_wpnonce']);
            if (!empty($_GET) && wp_verify_nonce($nonce, 'restore-default-nonce')) {
                $apexnb_lite_settings = $this->get_default_settings();
                update_option('apexnb_lite_settings', $apexnb_lite_settings);
                wp_redirect(admin_url() . 'admin.php?page=apexnb-lite&restore-message=1');
            }
        }

        /**
         * Sanitizes Multi Dimensional Array
         * @param array $array
         * @param array $sanitize_rule
         * @return array
         *
         * @since 1.0.0
         */
        public static function sanitize_array($array = array(), $sanitize_rule = array()) {
            if (!is_array($array) || count($array) == 0) {
                return array();
            }

            foreach ($array as $k => $v) {

                if (!is_array($v)) {
                    $default_sanitize_rule = (is_numeric($k)) ? 'text' : 'html';
                    $sanitize_type = isset($sanitize_rule[$k]) ? $sanitize_rule[$k] : $default_sanitize_rule;
                    $array[$k] = APEXNBL_Class::sanitize_value($v, $sanitize_type);
                }
                if (is_array($v)) {
                    $array[$k] = APEXNBL_Class::sanitize_array($v, $sanitize_rule);
                }
            }

            return $array;
        }

        /**
         * Sanitizes Value
         *
         * @param type $value
         * @param type $sanitize_type
         * @return string
         *
         * @since 1.0.0
         */
        public static function sanitize_value($value = '', $sanitize_type = 'text') {
            switch ($sanitize_type) {
                case 'html':
                    $allowed_html = wp_kses_allowed_html('post');
                    return wp_kses($value, $allowed_html);
                    break;
                default:
                    return sanitize_text_field($value);
                    break;
            }
        }

    }

    // class end
    $edn_pro_object = new APEXNBL_Class(); //initialization of plugin
}
 