*<?php
/**
 * Plugin Name:       Redirection Mini Panier
 * Description:       Personnalisez l’URL du lien “Poursuivre mes achats” du mini-panier WooCommerce depuis l’administration.
 * Version:           1.0.0
 * Requires at least: 5.6
 * Requires PHP:      7.4
 * Author:            Troteseil Lucas
 * Author URI: https://bento.me/lucas-tsl
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       redirect-mini-cart-link
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'includes/override-link.php';

// Menu d’options
add_action('admin_menu', function () {
    add_options_page(
        'Lien Mini-Panier',
        'Lien Mini-Panier',
        'manage_options',
        'redirect-mini-cart-link',
        'rmcl_render_admin_page'
    );
});

add_action('admin_init', function () {
    register_setting('rmcl_settings', 'rmcl_cart_redirect_url', [
        'type' => 'string',
        'sanitize_callback' => 'esc_url_raw',
        'default' => ''
    ]);
});

function rmcl_render_admin_page() {
    ?>
    <div class="wrap">
        <h1>Modifier le lien “Poursuivre mes achats”</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('rmcl_settings');
                do_settings_sections('rmcl_settings');
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="rmcl_cart_redirect_url">Nouvelle URL</label></th>
                    <td>
                        <input type="url" name="rmcl_cart_redirect_url" id="rmcl_cart_redirect_url"
                            value="<?php echo esc_attr(get_option('rmcl_cart_redirect_url')); ?>"
                            class="regular-text" placeholder="https://exemple.com/categorie-produit/" />
                        <p class="description">Cette URL remplacera le lien du mini-panier WooCommerce.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

