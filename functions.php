<?php
function mon_theme_enqueue_styles() {
    wp_enqueue_style(
        'theme-id-style',  // Handle: Un nom pour l'identifier
        get_stylesheet_uri(), // Chemin: style.css à la racine
        array(),
        wp_get_theme()->get('Version')
    );

    //2. ENQUEUE FONTS 
    wp_enqueue_style(
        'theme-fonts',
        get_template_directory_uri() . '/css/font.css',
        array('theme-id-style'),
        '1.0'
    );

    //3. ENQUEUE MAIN CSS
    wp_enqueue_style(
        'theme-main-css',
        get_template_directory_uri() . '/css/main.css',
        array('theme-fonts'),
        '1.0'
    );
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_styles');
?>   

<?php
function mon_theme_register_nav_menus() {
//Enregistre les emplacements de menus personnalisés
    register_nav_menus(
        array(
            'primary' => __( 'Menu Principal', 'motaTheme' ), // 'primary' est le slug (identifiant)
            'footer'  => __( 'Menu Pied de Page', 'motaTheme' )  // Exemple d'un second emplacement
        )
    );
}
add_action( 'after_setup_theme', 'mon_theme_register_nav_menus' );
?>

<?php
// Fichier: functions.php

function mon_theme_charger_modale_contact() {
    // 1. Inclut le contenu de votre template modale
    // Utilisez locate_template pour trouver votre fichier de template modale
    $modale_template = locate_template('modale_contact.php');
    
    if ($modale_template) {
        // Envoie le contenu du template
        load_template($modale_template);
    } else {
        // Optionnel: Gérer le cas où le fichier n'est pas trouvé
        wp_send_json_error('Template de modale introuvable.');
    }

    // 2. Termine l'exécution d'Ajax
    wp_die();
}

// Pour les utilisateurs connectés
add_action('wp_ajax_charger_modale_contact', 'mon_theme_charger_modale_contact'); 
// Pour les utilisateurs non-connectés (visiteurs)
add_action('wp_ajax_nopriv_charger_modale_contact', 'mon_theme_charger_modale_contact');
?>

<?php
// Dans functions.php (à lier à l'action wp_enqueue_scripts)
function mon_theme_enqueue_scripts() {
    wp_enqueue_script('mon-theme-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);

    // Cette fonction rend l'URL Ajax accessible dans le JS sous l'objet 'monThemeAjax'
    wp_localize_script('mon-theme-script', 'monThemeAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('mon_theme_contact_nonce') // Optionnel: pour plus de sécurité
    ));
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_scripts');

//LOGO UPLOAD VIA WP CUSTOMIZER
//ajoute le support du logo personnalisé
function mon_theme_setup() {
    add_theme_support( 'custom-logo', array(
        'height'      => 25, // Hauteur maximale recommandée pour le logo
        'width'       => 400, // Largeur maximale recommandée pour le logo
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );
}
add_action( 'after_setup_theme', 'mon_theme_setup' );

add_action( 'acf/init', 'set_acf_settings' );
function set_acf_settings() {
    acf_update_setting( 'enable_shortcode', true );
}

//CPT PHOTO 
function cptui_register_my_cpts() {

	/**
	 * Post Type: photos.
	 */

	$labels = [
		"name" => esc_html__( "photos", "motaTheme" ),
		"singular_name" => esc_html__( "photo", "motaTheme" ),
		"menu_name" => esc_html__( "Photos", "motaTheme" ),
	];

	$args = [
		"label" => esc_html__( "photos", "motaTheme" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "photo", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "photo", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );

// Expose ACF fields in REST API
function expose_acf_fields_in_rest() {
    register_rest_field('photo', 'acf', array(
        'get_callback' => function($post) {
            return get_fields($post['id']);
        },
        'schema' => null,
    ));
}
add_action('rest_api_init', 'expose_acf_fields_in_rest');