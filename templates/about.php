<?php
/**
 * Template Name: A propos
 */
get_header();
?>

    <main id="a-propos" class="a-propos-main">

    <?php
        // DÉBUT DE LA BOUCLE WORDPRESS 
        //Boucle WordPress est la structure fondamentale 
        // utilisée pour afficher tout contenu dynamique (articles, pages, CPT)
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                
                // AFFICHE LE TITRE DE LA PAGE
                ?>
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                
                <?php
                // AFFICHE LE CONTENU DE L'ÉDITEUR GUTENBERG
                the_content();
                
            endwhile; // Fin de la boucle
        endif; // Fin de la condition
        // 🚨 FIN DE LA BOUCLE WORDPRESS 🚨
        ?>


    </main>

    <?php
get_footer();