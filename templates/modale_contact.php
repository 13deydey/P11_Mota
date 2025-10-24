NAV POUR WP NAV D'APRÈS GEMINI - DANS HEADER 
<nav id="site-navigation" class="nav_menu" role="navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary', // L'identifiant (slug) que vous avez déclaré dans functions.php
                'container'      => false,     // Ne pas envelopper le menu dans un div (utilise directement <ul>)
                'menu_class'     => 'main-menu', // La classe CSS appliquée au <ul> du menu
                'depth'          => 2,         // Niveau de profondeur autorisé (ex: 2 pour sous-menus)
            ) );
            ?>
</nav>

FONCTION INTÉGRANT LE WP NAV DANS FUNCTIONS.PHP
<?php
function mon_theme_register_nav_menus() {
Enregistre les emplacements de menus personnalisés
    register_nav_menus(
        array(
            'primary' => __( 'Menu Principal', 'motaTheme' ), // 'primary' est le slug (identifiant)
            'footer'  => __( 'Menu Pied de Page', 'motaTheme' )  // Exemple d'un second emplacement
        )
    );
}
add_action( 'after_setup_theme', 'mon_theme_register_nav_menus' );
?>