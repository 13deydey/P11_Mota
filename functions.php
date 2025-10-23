<?php
function mon_theme_styles() {
    // Enregistre et met en file d'attente votre feuille de style principale
    wp_enqueue_style( 
        'mon-style-principal', // Un nom unique (handle) pour votre style
        get_template_directory_uri() . '/style.css', // Le chemin d'accès dynamique
        array(), // Les dépendances (autres styles à charger avant, ici aucun)
        wp_get_theme()->get('Version') // Version pour éviter les problèmes de cache
    );
}
add_action( 'wp_enqueue_scripts', 'mon_theme_styles' );
?>