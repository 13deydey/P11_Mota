//JAVASCRIPT POUR LE BOUTON DE FILTRE DE "CATÉGORIE" DANS LA GALERIE D'ACCUEIL
const category_filter = document.querySelector('.category_filter');
const selected_category = category_filter.querySelector('.selected_category');
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
//JS POUR RÉCUPÉRER LES POSTS D'UN CUSTOM POST TYPE VIA L'API REST DE WORDPRESS

  fetch('/wp-json/wp/v2/photo?_embed')
  .then(response => response.json())
  .then(data => {
    const gallery = document.querySelector('#gallery');

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
    });

    const galleryItems = document.querySelectorAll('.gallery-item');
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
        infoOverlay.classList.remove('visible');

        // Création de l'overlay
        const overlay = document.createElement('div');
        overlay.classList.add('lightbox-overlay');
        
        // Créer la lightbox dynamiquement au clic
        const lightbox_content = document.createElement('div');
        lightbox_content.classList.add('lightbox');

        lightbox_content.innerHTML = `
            <article class="fleche_prec">
                <i class="fa-solid fa-arrow-left-long"></i>
                <p>Précédente</p>
            </article>
            <article class="previsualisation">
                <img src="${item.dataset.singlephoto}" alt="Photo" />
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

        // Ajouter au body
        document.body.appendChild(overlay);
        document.body.appendChild(lightbox_content);

        // Ajouter classe pour bloquer scroll sur body
        document.body.classList.add('no-scroll');

         // Fermer lightbox au clic sur l'overlay
         overlay.addEventListener('click', () => {
            lightbox_content.remove();
            overlay.remove();
            document.body.classList.remove('no-scroll');
            });
      });
    });
  })
  .catch(error => console.error(error));



  /*
a partir du fetch qui récupère toutes les imgs , récupérer les catégories
faire en sorte qu'il n'y ait pas de doublon sur les catégories
récupérer le code html pour les cat. depuis home.php
utiliser ce code pour pouvoir injecter les cat. en live avec js l.31 à 36, récup 1 option et boucler CF.L32
Attention récupérer toutes les cat. avec AJAX



  */