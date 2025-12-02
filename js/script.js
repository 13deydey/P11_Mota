//GALERIE ACCUEIL DES PHOTOS _ CPT UI 
let currentPage = 1;
const postsPerPage = 8;
const gallery = document.querySelector('#gallery');
const loadMoreButton = document.querySelector('.load_more_button');

// Fonction pour gérer le chargement (initial ou suivant)
function loadPhotos(pageNumber) {
    //Utilisation de l'API REST pour TOUTES les requêtes
    const restUrl = `/wp-json/wp/v2/photo?_embed&per_page=${postsPerPage}&page=${pageNumber}`;
    if (loadMoreButton) {
        loadMoreButton.disabled = true;
        loadMoreButton.textContent = 'Chargement...';
    }
    fetch(restUrl)
    .then(response => {
        //Récupérer le total des pages (X-WP-TotalPages) dans le header
        //parseInt pour convertir en nombre entier en JS
        const totalPages = parseInt(response.headers.get('X-WP-TotalPages'));
        if (loadMoreButton) {
            loadMoreButton.dataset.totalPages = totalPages;
        }
        return response.json();
    })
    .then(data => {
        if (!data.length && currentPage === 1) {
            // Aucun post trouvé au total
            gallery.innerHTML = '<p>Aucune photo trouvée.</p>';
            return;
        }

        // Boucle pour afficher les articles
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

        //Mise à jour de la page courante
        currentPage++;
        if (loadMoreButton) {
            loadMoreButton.disabled = false;
            loadMoreButton.textContent = 'Charger plus';

            //Masquer le bouton si dernière page atteinte
            const totalPages = parseInt(loadMoreButton.dataset.totalPages);
            if (currentPage > totalPages) {
                loadMoreButton.style.display = 'none';
            }
        }
        //Réinitialiser les écouteurs de la lightbox
        initGalleryListeners();
    })
    .catch(error => {
        console.error("Erreur de chargement des photos:", error);
        if (loadMoreButton) {
            loadMoreButton.textContent = 'Erreur de chargement';
        }
    });
}


let currentIndex = 0;
const galleryItems = [];

// Fonction pour ouvrir la lightbox
function openLightbox(index) {
    currentIndex = index;
    
    //si overlay existe déjà, le supprimer avant d'en créer un nouveau
    if(document.querySelector('.lightbox-overlay')){
        document.querySelector('.lightbox-overlay').remove();
    }

    const overlay = document.createElement('div');
    overlay.classList.add('lightbox-overlay');
    if(overlay){overlay.remove();} // Supprimer l'overlay précédent s'il existe
    document.body.appendChild(overlay);

    const item = galleryItems[currentIndex];

    // Mettre à jour la lightbox (overlay et contenu)

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

// Fonction pour initialiser les écouteurs sur tous les articles (nouveaux et anciens)
function initGalleryListeners() {
    galleryItems.length = 0; // Réinitialiser le tableau
    Array.from(document.querySelectorAll('.gallery-item')).forEach(item => galleryItems.push(item));
    galleryItems.forEach(item => {
        const infoOverlay = item.querySelector('.info_overlay');

        // C'est ici que vous vérifiez si l'écouteur n'est pas déjà là (bonne pratique)
        if (!item.dataset.listenersAdded) { 
            // 1. Écouteurs de survol
            item.addEventListener('mouseenter', () => {
                infoOverlay.classList.add('visible');
            });
            item.addEventListener('mouseleave', () => {
                infoOverlay.classList.remove('visible');
            });

            // 2. Écouteur d'ouverture Lightbox
            const apercu = item.querySelector('.apercu');
            apercu.addEventListener('click', () => {
                // Trouver l'index de l'élément dans le tableau global
                const index = galleryItems.indexOf(item); 
                openLightbox(index);
            });
            item.dataset.listenersAdded = true; // Marquer l'élément comme initialisé
        }    
    });
}

// Initialisation du chargement des photos
if (gallery) {
    // 1. Chargement Initial (Page 1)
    loadPhotos(currentPage); 
}

if (loadMoreButton) {
    // 2. Écouteur du Bouton (Charge la page suivante)
    loadMoreButton.addEventListener('click', function(e) {
        e.preventDefault();
        // Le bouton appelle la fonction pour la page actuelle qui est maintenant (1+1=2)
        loadPhotos(currentPage); 
    });
}


//MODALE DE CONTACT AVEC RÉFÉRENCE PHOTO PRÉ-REMPLIE
// Modale et overlay créés une fois
const modaleContact = document.createElement('section');
modaleContact.classList.add('modale-contact');
modaleContact.innerHTML = `
  <div class="modale-content">
    <div class="titre">CONTACT</div>
    <form>
      <article>
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" required />
      </article>
      <article>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required />
      </article>
      <article>
        <label for="reference">Ref. Photo :</label>
        <input type="text" id="reference" name="reference" required />
      </article>
      <article>
        <label for="message">Message :</label>
        <input type="text" id="message" name="message" class="messageLong"/>
      </article>
      <button type="submit" class="submit-button">Envoyer</button>
    </form>
  </div>
`;
document.body.appendChild(modaleContact);

const overlay = document.createElement('div');
document.body.appendChild(overlay);

// Fonctions ouverture / fermeture
// La fonction openModale s'exécute avec un paramètre optionnel : la référence de la photo
function openModale(photoReference = '') {
  modaleContact.classList.add('visible');
  overlay.classList.add('lightbox-overlay');
  document.body.classList.add('no-scroll');

  // Met à jour le champ de référence SELON FORMULAIRE CONTACT FORM 7
  // 1. Récupère le champ de référence DOM pour l'employer en JavaScript
  const referenceInput = modaleContact.querySelector('#reference');
    // 2. Met à jour la valeur du champ avec la référence de la photo prise en paramètre de la fonction
  referenceInput.value = photoReference;
}
function closeModale() {
  modaleContact.classList.remove('visible');
  overlay.classList.remove('lightbox-overlay');
  document.body.classList.remove('no-scroll');
}
// Fermer au clic sur overlay
overlay.addEventListener('click', closeModale);
// Gestion du bouton de la page des photos
const contactButton = document.querySelector('.contact_cta');
if (contactButton) contactButton.addEventListener('click', function(event) {
    event.preventDefault(); // Stoppe la navigation/soumission

    //ref récupérée depuis l'attribut data-reference du bouton dans le template single-photo.php
    const ref = this.getAttribute('data-reference');
    console.log('Référence photo :', ref);
    openModale(ref); // Ouvre la modale avec la référence de la photo
});
// Gestion du lien "Contact" dans le menu WordPress
const menuContact = document.querySelector('#menu-item-87 a');
menuContact.addEventListener('click', function(event) {
    //Stoppe la navigation vers la page de contact
    event.preventDefault(); 
    //lance l'ouverture de la modale sans référence de photo comme paramètre
    openModale();
});

//RÉPÉTER LE TITRE "CONTACT" DANS LA MODALE
    const titreModale = modaleContact.querySelector('.titre');
    const texte = "Contact";
    const repeatedText5 = texte.repeat(5);  // répète 5 fois
    const repeatedText7 = texte.repeat(7);  // répète 7 fois
titreModale.innerHTML = `
    <span class="repeat5">${repeatedText5}</span>
    <span class="repeat7">  ${repeatedText7}</span>
`;

//JAVASCRIPT ET AJAX POUR LES FLECHES PREC/SUIV DU PREVISUALISER DES SINGLE PHOTO PAGES
const previewImage = document.querySelector('.preview_image');
// récupérer l'URL actuelle à JavaScript
const currentPhotoUrl = "<?php echo esc_js($current_photo_url); ?>";

if (previewImage){
    fetch('/wp-json/wp/v2/photo?_embed')
    .then(response => response.json())
    .then(data => {
      const previewPrec = document.querySelector('.preview_arrow');
      const previewNext = document.querySelector('.next_arrow');
    
      let indexPhoto = 0;
      const photoLinks = []; 

        // Fonction pour mettre à jour l'image de prévisualisation
      function updatePreview() {
        if (photoLinks.length === 0) return;
        
        // Met à jour la source de l'image
        previewImage.src = photoLinks[indexPhoto].image;
        // Met à jour le lien de la prévisualisation
        previewImage.dataset.permalink = photoLinks[indexPhoto].permalink;
        }
      
      // --- 1. Remplir le tableau photoLinks (ACF sécurisé) ---
      data.forEach(post => {
        // ACF configuré pour retourner l'URL de l'image directement       
        const imageUrl = post.acf?.singlephoto || '';
        // Récupère le lien du post pour la redirection au clic sur l'image de prévisualisation
        const postPermalink = post.link;

        if (imageUrl&&postPermalink) {
        // Insère l'url de l'image actuelle dans le tableau photoLinks ; chaque fois que la boucle s'exécute
          photoLinks.push({
            image: imageUrl,
            link: postPermalink
          });   
        }
        });

      // --- 2. Déterminer l'Index de Départ ---
            // 1. Chercher l'index de l'URL du post CPT actuellement chargé
            const startingIndex = photoLinks.findIndex(url => url === currentPhotoUrl);
            // 2. Si l'URL est trouvée dans le tableau, on commence là. Sinon, on commence à 0.
            if (startingIndex !== -1) {
                indexPhoto = startingIndex;
            }

      // --- 3. Initialiser la Prévisualisation ---
            // Vérifie que le tableau n'est pas vide avant d'appeler updatePreview
            // évite de rester sur une image vide car on ne lui a fourni aucune source
        if (photoLinks.length > 0) {
            updatePreview(); 
        }
        
      // --- 4. Écouteurs d'Événements (Précédent) ---
      previewPrec.addEventListener('click', () => {
          if (photoLinks.length === 0) return;
          console.log('Photo actuelle index AVNAT :', indexPhoto);
          // Si l'index actuel est supérieur à 0 (pas la première photo)
          if (indexPhoto > 0) {
              indexPhoto--; 
          }else{
              indexPhoto = photoLinks.length - 1; // Aller à la dernière photo
          }
          updatePreview();
          console.log('Photo actuelle index APRÈS :', indexPhoto);
      });
      // --- 5. Écouteurs d'Événements (Suivant) ---
      previewNext.addEventListener('click', () => {
          if (photoLinks.length === 0) return;
          console.log('Photo actuelle index :', indexPhoto);
          // Si l'index actuel est inférieur à la taille totale du tableau moins 1 (pas la dernière photo)
          if (indexPhoto < photoLinks.length - 1) {
              indexPhoto++;
          }else{
              indexPhoto = 0; // Revenir à la première photo
          }
          updatePreview();
            console.log('Photo actuelle index APRÈS :', indexPhoto);
      });

      // --- 6. Écouteur d'Événements (Clic sur l'Image de Prévisualisation) ---
      previewImage.addEventListener('click', () => {
        // S'assurer que le tableau n'est pas vide
        if (photoLinks.length === 0) return;
        // Récupérer le lien de la photo actuelle
        const targetLink = photoLinks[indexPhoto].link;
        // Redirige vers la page de la photo actuelle
        if (targetLink) {
            window.location.href = targetLink;
        }        
      });
    });
}



//AJAX POUR RÉCUPÉRER LES CATÉGORIES UNIQUES DE PHOTOS ET LES INJECTER DANS LE FILTRE CATÉGORIE DE LA GALERIE

  /*
a partir du fetch qui récupère toutes les imgs , récupérer les catégories
faire en sorte qu'il n'y ait pas de doublon sur les catégories
récupérer le code html pour les cat. depuis home.php
utiliser ce code pour pouvoir injecter les cat. en live avec js l.31 à 36, récup 1 option et boucler CF.L32
Attention récupérer toutes les cat. avec AJAX
  */
//fetch('/wp-json/wp/v2/photo?_embed')
//.then(response => response.json())
//.then(data => {
//TEST AVEC COPILOT POUR RÉCUPÉRER LES CATÉGORIES UNIQUES ????? HOW DOES IT WORK ????
    //const selected_category = document.querySelector('.selected_category p');
    //selected_category.textContent = 'Catégories';
    //const optionsCategoryContainer = document.querySelector('.options_category');
    //const categoriesSet = new Set();

    // Récupérer les catégories uniques
    //data.forEach(post => {
    //    if (post.acf?.categories) {
    //        categoriesSet.add(post.acf.categories);
    //    }
    //});

    // Créer et injecter les options de catégorie
    //categoriesSet.forEach(category => {
    //    const optionDiv = document.createElement('div');
    //    optionDiv.classList.add('option_category_input');
    //    optionDiv.setAttribute('data-value', category);
    //    optionDiv.textContent = category;
    //    optionsCategoryContainer.appendChild(optionDiv);
    //});

    //TRY TO CHECK COMPANION HELP AND EXPLANATION BUT DOESN'T WORK AS EXPECTED
    //const categories = post.acf?.categories;
    //BECAUSE POST ISN'T DEFINED IN THIS SCOPE, WE NEED TO COLLECT CATEGORIES FROM ALL POSTS
    //POST IS DEFINED IN LINE 184 IN THE FOREACH LOOP
    //const categorieSet = new Set(categories);
    //console.log(categorieSet); // Set(3) {"portrait", "nature", "studio"}
    //console.log(categories);
//})
//.catch(error => console.error(error));
