jQuery(document).ready(function($) {
    var $boutonContact = $('#ouvrir-modale-contact');
    var $modaleContainer = $('#modale-placeholder'); // Un div vide dans le HTML pour recevoir la modale

    $boutonContact.on('click', function(e) {
        e.preventDefault();

        // 1. Vérifie si la modale est déjà chargée
        if ($modaleContainer.find('.modale-ajax').length) {
            $modaleContainer.find('.modale-ajax').fadeIn();
            return; // Sort si déjà chargé
        }

        // 2. Requête Ajax pour charger le contenu
        $.ajax({
            url: monThemeAjax.ajaxurl,
            type: 'post',
            data: {
                action: 'charger_modale_contact', // L'action que vous avez déclarée en PHP
                security: monThemeAjax.nonce      // Optionnel
            },
            beforeSend: function() {
                // Optionnel: Afficher un loader
                $modaleContainer.html('<div class="loading">Chargement...</div>');
            },
            success: function(response) {
                if(response.success === false) {
                     $modaleContainer.html('<p>Erreur de chargement.</p>');
                     return;
                }
                
                // 3. Insérer le contenu de la modale dans le placeholder
                $modaleContainer.html(response);
                
                // 4. Afficher la modale chargée
                $modaleContainer.find('.modale-ajax').fadeIn();

                // IMPORTANT: Réinitialiser CF7 pour qu'il fonctionne après Ajax
                if (typeof wpcf7 !== 'undefined' && wpcf7.init) {
                    wpcf7.init($(response));
                }
            }
        });
    });

    // 5. Fermeture de la modale (via un événement délégué car le contenu est chargé dynamiquement)
    $(document).on('click', '.close-button', function() {
        $('.modale-ajax').fadeOut();
    });
});