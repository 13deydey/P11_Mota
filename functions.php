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


//AJAX LOAD MORE POUR LA GALERIE D'ACCUEIL
add_action('wp_ajax_galerie_load_more', 'galerie_load_more_callback');
add_action('wp_ajax_nopriv_galerie_load_more', 'galerie_load_more_callback');

function galerie_load_more_callback() {
    // Vérification du nonce pour la sécurité
    if(
        !isset($_POST['nonce']) or !wp_verify_nonce($_REQUEST['nonce'], 'galerie_load_more')
    ) {
        wp_send_json_error('Nonce invalide', 403);
    }

    // Définir le slug du CPT
    $cpt_slug = 'photo';
    // Initialiser la pagination
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 8;
    // Assurez-vous de récupérer le numéro de page envoyé par JavaScript
    $current_page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $args_slug = [
        'post_type' => $cpt_slug,
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'paged'          => $current_page,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    $cpt_posts = get_posts($args_slug);

    // 2. Requête WP_Query pour la pagination
        //méthode standard de WordPress pour interroger la base de données et récupérer tout type de contenu
    $the_query = new WP_Query($args_slug);
    $output_html = '';

    if ( $the_query->have_posts() ) {
        error_log('Posts trouvés: ' . $the_query->post_count);
        // 3. Boucle et génération du HTML pour chaque post récupéré
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            // Récupération des champs ACF et de génération de la carte photo 
            $single_photo_url = get_field('singlephoto'); 
            $reference = get_field('reference');
            $categories = get_field('categories');
        
            $post_link = get_permalink();
            $post_title = get_the_title();

            // Génération du HTML pour chaque carte photo
            $output_html .= '
            <article class="gallery-item" 
                 data-singlephoto="' . esc_attr($single_photo_url) . '" 
                 data-reference="' . esc_attr($reference) . '" 
                 data-categories="' . esc_attr($categories) . '"
                 data-link="' . esc_url($post_link) . '">
            
                <a href="' . esc_url($post_link) . '">
                    <img src="' . esc_url($single_photo_url) . '" alt="' . esc_attr($post_title) . '" />
                </a>
                
                <div class="info_overlay">
                    <img src="' . get_template_directory_uri() . '/assets/iconeSurvol/Icon_fullscreen.png" alt="Aperçu lightbox" class="apercu"/>
                    
                    <a href="' . esc_url($post_link) . '">
                        <img src="' . get_template_directory_uri() . '/assets/iconeSurvol/Icon_eye.png" alt="Plein écran" class="pleinEcran"/>
                    </a>
                    
                    <div class="infos-content">
                        <p>' . esc_html($reference) . '</p>
                        <p>' . esc_html($categories) . '</p>
                    </div>
                </div>
            </article>';
        }
        wp_reset_postdata();
    }else{error_log('Aucun post trouvé avec ces arguments.');}

    // 4. Retour de la Réponse AJAX
    wp_send_json_success([
        //Transmet la chaîne HTML générée par PHP (les nouvelles cartes photos) au JavaScript.
        'html' => $output_html,
        'max_pages' => $the_query->max_num_pages,
        'current_page' => $current_page,
    ]);
    
    die();
}
