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


CODE MODALE CONTACT FORM 7 POUR INTEGRER DANS UN TEMPLATE PHP
<?php
// Définir le shortcode
$cf7_modale = '[contact-form-7 id="39285c9" title="ModaleContact"]';

// Afficher le formulaire
echo '<div class="contact-form-wrapper">';
echo do_shortcode( $cf7_modale );
echo '</div>';
?>



old nav                 <a href=" ">
                   <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/Logo.png" alt="Logo Mota Photo">
                </a>


//JAVASCRIPT POUR LE BOUTON DE FILTRE DE "CATÉGORIE" DANS LA GALERIE D'ACCUEIL
const category_filter = document.querySelector('.category_filter');
//const selected_category = category_filter.querySelector('.selected_category');
const options_category = category_filter.querySelector('.options_category');
const category_input = category_filter.querySelectorAll('.option_category_input');
const pCategory = selected_category.querySelector('p');

//Au clic sur la div selected_category, on affiche/masque les options de catégorie
selected_category.addEventListener('click', () => {
    options_category.classList.toggle('active');
    options_category.classList.toggle('hide');

    //Au clic sur une option de catégorie, on met à jour le texte de selected_category et on masque les options
    category_input.forEach(option => {
        option.addEventListener('click', () => {
            pCategory.textContent = option.textContent;
            options_category.classList.add('hide');
            options_category.classList.remove('active');
        });
    });
});

//JAVASCRIPT POUR LE BOUTON DE FILTRE DE "FORMAT" DANS LA GALERIE D'ACCUEIL
const format_filter = document.querySelector('.format_filter');
const selected_format = format_filter.querySelector('.selected_format');
const options_format = format_filter.querySelector('.options_format');
const format_input = format_filter.querySelectorAll('.option_format_input');
const pFormat = selected_format.querySelector('p');

//Au clic sur la div selected_format, on affiche/masque les options de formats
selected_format.addEventListener('click', () => {
    options_format.classList.toggle('active');
    options_format.classList.toggle('hide');

    //Au clic sur une option de format, on met à jour le texte de selected_format et on masque les options
    format_input.forEach(option => {
        option.addEventListener('click', () => {
            pFormat.textContent = option.textContent;
            options_format.classList.add('hide');
            options_format.classList.remove('active');
        });
    });
});

//JAVASCRIPT POUR LE BOUTON DE FILTRE DE "TRI DATE" DANS LA GALERIE D'ACCUEIL
const date_filter = document.querySelector('.date_filter');
const selected_date = date_filter.querySelector('.selected_date');
const options_date = date_filter.querySelector('.options_date');
const date_input = date_filter.querySelectorAll('.option_date_input');
const pDate = selected_date.querySelector('p');

//Au clic sur la div selected_date, on affiche/masque les options de date
selected_date.addEventListener('click', () => {
    options_date.classList.toggle('active');
    options_date.classList.toggle('hide');

    //Au clic sur une option de date, on met à jour le texte de selected_date et on masque les options
    date_input.forEach(option => {
        option.addEventListener('click', () => {
            pDate.textContent = option.textContent;
            options_date.classList.add('hide');
            options_date.classList.remove('active');
        });
    });
});

