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



                //GALERIE ACCUEIL DES PHOTOS _ CPT UI 
//JS POUR RÉCUPÉRER LES POSTS D'UN CUSTOM POST TYPE VIA L'API REST DE WORDPRESS
fetch('/wp-json/wp/v2/photo?_embed')
  .then(response => response.json())
  .then(data => {
    const gallery = document.querySelector('#gallery');

    data.forEach(post => {
      // Créer un article avec l'image
      const article = document.createElement('article');
      article.classList.add('gallery-item');
      article.innerHTML = `
        <a href="${post.link}">
          <img src="${post.acf && post.acf.singlephoto ? post.acf.singlephoto : ''}" alt="${post.title.rendered}"/>
        </a>
      `;

      // Créer la div info_overlay, vide et cachée initialement
      const info = document.createElement('div');
      info.classList.add('info_overlay');  // Créez la classe en CSS avec opacité 0 par défaut
      info.innerHTML = `
        <img src="wp-content/themes/motaTheme/assets/iconeSurvol/Icon_fullscreen.png" alt="Aperçu lightbox" class="apercu"/>
        <a href="${post.link}">
            <img src="wp-content/themes/motaTheme/assets/iconeSurvol/Icon_eye.png" alt="Plein écran" class="pleinEcran"/>
        </a>
        <div class="infos-content">
            <p> ${post.acf?.titre || ''}</p>
            <p>${post.acf?.categories || ''}</p>
        </div>
      `;

      const lightbox = document.createElement('div');
      lightbox.classList.add('lightbox');
      lightbox.innerHTML =`
          <div class="light_rang1">
              <article class="fleche_prec">
                  <img src="fleche"/>
                  <p>Précédente</p>
              </article>
              <img src="${post.acf && post.acf.singlephoto ? post.acf.singlephoto : ''}"/>
              <article class="fleche_suiv">
                  <p>Suivante</p>
                  <img src="fleche"/>
              </article>
          </div>
          <div class="light_rang2">
              <p>${post.acf?.reference || ''}</p>
              <p>${post.acf?.categories || ''}</p>
          </div>
        `;

      article.appendChild(info);

      gallery.appendChild(article);

      //élément à intégrer ultérieurement ou simplement à récupérer pour les filtres
      //<p>TYPE : ${post.acf?.type || ''}</p>
      //<p>ANNÉE : ${post.acf?.date || ''}</p>
      //<p>FORMAT : ${post.acf?.format || ''}</p>

    });

    // Maintenant que tous les éléments sont dans le DOM, ajoutez les écouteurs
    const galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach(item => {
      const infoOverlay = item.querySelector('.info_overlay');

      item.addEventListener('mouseenter', () => {
        infoOverlay.classList.add('visible');
        console.log('Survol détecté');
      });

      item.addEventListener('mouseleave', () => {
        infoOverlay.classList.remove('visible');
      });
    });

    const apercus = document.querySelectorAll('.apercu')
    apercus.forEach(apercu=>{
      const lightbox_content = item.querySelectory('.lightbox');

        apercu.addEventListener('click', () =>{
            lightbox_content.classList.add('visible');
        });
    });

  })
  .catch(error => console.error(error));




        // Création de l'overlay
        const overlay = document.createElement('div');
        overlay.classList.add('lightbox-overlay');

        // Création de la lightbox
        const lightbox = document.createElement('div');
        lightbox.classList.add('lightbox');
        lightbox.innerHTML = `
        <div class="light_rang1">
            <article class="fleche_prec">
              <img src="path/to/fleche_prec.png" alt="Précédente"/>
              <p>Précédente</p>
            </article>
            <img src="${item.dataset.singlephoto}" alt="Photo" />
            <article class="fleche_suiv">
              <p>Suivante</p>
              <img src="path/to/fleche_suiv.png" alt="Suivante" />
            </article>
          </div>
          <div class="light_rang2">
            <p>${item.dataset.reference}</p>
            <p>${item.dataset.categories}</p>
          </div>
        `;

        // Ajout de l'overlay et lightbox au body
        document.body.appendChild(overlay);
        document.body.appendChild(lightbox);

        // Ajouter classe pour bloquer scroll sur body
        document.body.classList.add('no-scroll');

        // Fermer lightbox au clic sur l'overlay
        overlay.addEventListener('click', () => {
        lightbox.remove();
        overlay.remove();
        document.body.classList.remove('no-scroll');
        });
