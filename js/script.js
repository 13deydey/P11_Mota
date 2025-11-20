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