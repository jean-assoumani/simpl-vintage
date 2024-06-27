<?php
// Ajouter la fonction pour charger les scripts et styles du thème enfant
function theme_enqueue_styles()
{
    // Enqueue du style parent
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    // Enqueue du style enfant
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}
// Hook pour exécuter la fonction
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

// Masquer toutes les notifications
add_action('admin_head', 'hide_all_admin_notices');

function hide_all_admin_notices()
{
    echo '<style>.notice, .update-nag, .updated, .error, .is-dismissible { display: none !important; }</style>';
}


// Date single article
function ajouter_date_article($content)
{
    // Vérifie si nous sommes sur une page d'article
    if (is_single()) {
        // Récupère la date de l'article avec le format souhaité
        $post_date = get_the_date('d/m/Y');

        // Initialise une variable pour stocker la position de la première balise d'image dans le contenu
        $position_image = strpos($content, '<img');

        // Vérifie si une image est trouvée dans le contenu de l'article
        if ($position_image !== false) {
            // Ajoute la date après l'image dans le contenu de l'article
            $position_image_end = strpos($content, '>', $position_image);
            $date_content = '<p style="text-align: left; padding-top: 10px; color: #c39800;">Le : ' . $post_date . '</p>';
            $content = substr_replace($content, $date_content, $position_image_end + 1, 0);
        }
    }
    return $content;
}
add_filter('the_content', 'ajouter_date_article');
