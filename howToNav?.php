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




//GALERIE ACCUEIL DES PHOTOS _ CPT UI 
const gallery = document.querySelector('#gallery');
const loadMoreButton = document.getElementById('load-more-button');
if (gallery){
    //JS POUR RÉCUPÉRER LES POSTS D'UN CUSTOM POST TYPE VIA L'API REST DE WORDPRESS
    fetch('/wp-json/wp/v2/photo?_embed&per_page=8')
    .then(response => response.json())
    .then(data => {

    data.forEach(post => {
        const article = document.createElement('article');
        article.classList.add('gallery-item');
        article.innerHTML = `
        <a href="${post.link}">
            <img src="${post.acf?.singlephoto || ''}" alt="${post.title.rendered}" />
        </a>
        `;

        const info = document.createElement('div');
        info.classList.add('info_overlay');
        info.innerHTML = `
        <img src="wp-content/themes/motaTheme/assets/iconeSurvol/Icon_fullscreen.png" alt="Aperçu lightbox" class="apercu"/>
        <a href="${post.link}">
            <img src="wp-content/themes/motaTheme/assets/iconeSurvol/Icon_eye.png" alt="Plein écran" class="pleinEcran"/>
        </a>
        <div class="infos-content">
            <p>${post.acf?.titre || ''}</p>
            <p>${post.acf?.categories || ''}</p>
        </div>
        `;

        article.appendChild(info);
        gallery.appendChild(article);

        // Stocker les données utiles en dataset pour accès simple
        article.dataset.singlephoto = post.acf?.singlephoto || '';
        article.dataset.reference = post.acf?.reference || '';
        article.dataset.categories = post.acf?.categories || '';
        article.dataset.link = post.link;
    });

    const galleryItems = Array.from(document.querySelectorAll('.gallery-item'));
    galleryItems.forEach(item => {
        const infoOverlay = item.querySelector('.info_overlay');

        item.addEventListener('mouseenter', () => {
        infoOverlay.classList.add('visible');
        });
        item.addEventListener('mouseleave', () => {
        infoOverlay.classList.remove('visible');
        });

        const apercu = item.querySelector('.apercu');
        apercu.addEventListener('click', () => {
        openLightbox(galleryItems.indexOf(item));

        });
    });

    let currentIndex = 0;
    function openLightbox(index) {
        currentIndex = index;

        const item = galleryItems[currentIndex];

        // Mettre à jour la lightbox (overlay et contenu)
        const overlay = document.createElement('div');
        overlay.classList.add('lightbox-overlay');
        document.body.appendChild(overlay);

        let lightbox_content = document.querySelector('.lightbox');
        if (!lightbox_content) {
            lightbox_content = document.createElement('div');
            lightbox_content.classList.add('lightbox');
            document.body.appendChild(lightbox_content);
        }

        lightbox_content.innerHTML = `
            <article class="fleche_prec">
                <i class="fa-solid fa-arrow-left-long"></i>
                <p>Précédente</p>
            </article>
            <article class="previsualisation">
                <a href="${item.dataset.link}">
                    <img src="${item.dataset.singlephoto}" alt="Photo sélectionnée" />
                </a>
                <div class="light_rang2">
                    <p>${item.dataset.reference}</p>
                    <p>${item.dataset.categories}</p>
                </div>
            </article>
            <article class="fleche_suiv">
                <p>Suivante</p>
                <i class="fa-solid fa-arrow-right-long"></i>
            </article>
        `;

        // Bloquer scroll
        document.body.classList.add('no-scroll');

        // Écouteur fermeture overlay
        overlay.addEventListener('click', () => {
            lightbox_content.remove();
            overlay.remove();
            document.body.classList.remove('no-scroll');
        });

        // Navigation précédente
        const precedente = lightbox_content.querySelector('.fleche_prec');
        precedente.addEventListener('click', () => {
            // moyen de boucler en récupérant le modulo de la longueur du tableau CAD le reste de la division
            // si photo n°6, donc élément n°5 pour une longueur de 6, (5-1+6)%6 = 4 donc on revient à l'élément d'avant
            // car 10%6 => 10/6 = 1 reste 4 donc on récupère le 4
            currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
            openLightbox(currentIndex);
        });

        // Navigation suivante
        const suivante = lightbox_content.querySelector('.fleche_suiv');
        suivante.addEventListener('click', () => {
            // moyen de boucler en récupérant le modulo de la longueur du tableau CAD le reste de la division
            //si photo 5, élément n°4 pour une longueur de 5, (4+1)%5 = 0 donc on revient au début
            currentIndex = (currentIndex + 1) % galleryItems.length;
            openLightbox(currentIndex);
        });
    }
    })
    .catch(error => console.error(error));
}
