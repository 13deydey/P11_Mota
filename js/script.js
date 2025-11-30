

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

  // Met à jour le champ de référence dans le formulaire
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

  /*
a partir du fetch qui récupère toutes les imgs , récupérer les catégories
faire en sorte qu'il n'y ait pas de doublon sur les catégories
récupérer le code html pour les cat. depuis home.php
utiliser ce code pour pouvoir injecter les cat. en live avec js l.31 à 36, récup 1 option et boucler CF.L32
Attention récupérer toutes les cat. avec AJAX
  */
fetch('/wp-json/wp/v2/photo?_embed')
.then(response => response.json())
.then(data => {
//TEST AVEC COPILOT POUR RÉCUPÉRER LES CATÉGORIES UNIQUES ????? HOW DOES IT WORK ????
    const selected_category = document.querySelector('.selected_category p');
    selected_category.textContent = 'Catégories';
    const optionsCategoryContainer = document.querySelector('.options_category');
    const categoriesSet = new Set();

    // Récupérer les catégories uniques
    data.forEach(post => {
        if (post.acf?.categories) {
            categoriesSet.add(post.acf.categories);
        }
    });

    // Créer et injecter les options de catégorie
    categoriesSet.forEach(category => {
        const optionDiv = document.createElement('div');
        optionDiv.classList.add('option_category_input');
        optionDiv.setAttribute('data-value', category);
        optionDiv.textContent = category;
        optionsCategoryContainer.appendChild(optionDiv);
    });

    //TRY TO CHECK COMPANION HELP AND EXPLANATION BUT DOESN'T WORK AS EXPECTED
    //const categories = post.acf?.categories;
    //BECAUSE POST ISN'T DEFINED IN THIS SCOPE, WE NEED TO COLLECT CATEGORIES FROM ALL POSTS
    //POST IS DEFINED IN LINE 184 IN THE FOREACH LOOP
    //const categorieSet = new Set(categories);
    //console.log(categorieSet); // Set(3) {"portrait", "nature", "studio"}
    //console.log(categories);
})
.catch(error => console.error(error));
