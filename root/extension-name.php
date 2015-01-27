<?php
/**
 * {%= title %}
 *
 * {%= description %}
 *
 * @package   {%= safe_name %}
 * @author    {%= author_name %} <{%= author_email %}>
 * @license   GPL-2.0+
 * @link      {%= homepage %}
 * @copyright 2014 {%= author_name %}
 *
 * @wordpress-plugin
 * Plugin Name:       {%= title %}
 * Plugin URI:        {%= homepage %}
 * Description:       {%= description %}
 * Version:           {%= version %}
 * Author:            {%= author_name %}
 * Author URI:        {%= author_url %}
 * Text Domain:       {%= slug %}
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: {%= github_repo %}
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}


class AnsPress_Ext_{%= safe_name %}
{

    /**
     * Class instance
     * @var object
     * @since 1.0
     */
    private static $instance;


    /**
     * Get active object instance
     *
     * @since 1.0
     *
     * @access public
     * @static
     * @return object
     */
    public static function get_instance() {

        if ( ! self::$instance )
            self::$instance = new AnsPress_Ext_{%= safe_name %}();

        return self::$instance;
    }
    /**
     * Initialize the class
     * @since {%= version %}
     */
    public function __construct()
    {
        if( ! class_exists( 'AnsPress' ) )
            return; // AnsPress not installed

        if (!defined('{%= constant %}_DIR'))    
            define('{%= constant %}_DIR', plugin_dir_path( __FILE__ ));

        if (!defined('{%= constant %}_URL'))   
                define('{%= constant %}_URL', plugin_dir_url( __FILE__ ));

        $this->includes();

        // internationalization
        add_action( 'init', array( $this, 'textdomain' ) );

        add_action('ap_admin_menu', array($this, 'admin_menu'));
        add_filter('ap_default_options', array($this, 'ap_default_options') );
        add_action('ap_display_question_metas', array($this, 'ap_display_question_metas' ), 10, 2);
        add_action('ap_before_question_title', array($this, 'ap_before_question_title' ));
        add_action( 'ap_enqueue', array( $this, 'ap_enqueue' ) );

        add_action('ap_ask_form_fields', array($this, 'ask_from_field'), 10, 2);
        add_action('ap_ask_fields_validation', array($this, 'ap_ask_fields_validation'));
        add_action( 'ap_after_new_question', array($this, 'after_new_question'), 10, 2 );
        add_action( 'ap_after_update_question', array($this, 'after_new_question'), 10, 2 );
    }

    public function includes(){
       // require_once( {%= constant %}_DIR . 'file.php' );
    }

    /**
     * Load plugin text domain
     *
     * @since {%= version %}
     *
     * @access public
     * @return void
     */
    public static function textdomain() {

        // Set filter for plugin's languages directory
        $lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';

        // Load the translations
        load_plugin_textdomain( '{%= safe_name %}', false, $lang_dir );

    }
    

    /**
     * Apppend default options
     * @param   array $defaults
     * @return  array           
     * @since   1.0
     */             
    public function ap_default_options($defaults)
    {
        $defaults['enable_categories']  = true;

        return $defaults;
    }

    /**
     * Add {%= title %} menu in wp-admin
     * @return void
     * @since 2.0
     */
    public function admin_menu(){
        //add_submenu_page('anspress', '{%= title %}', '{%= safe_name %}', 'manage_options', 'edit-tags.php?taxonomy=question_category');
    }

    /**
     * Register {%= title %} option tab in AnsPress options
     * @param  array $navs Default navigation array
     * @return array
     * @since {%= version %}
     */
    public function option_navigation($navs){
        $navs['{%= safe_name %}'] =  __('{%= constant %}', '{%= safe_name %}');
        return $navs;
    }

    /**
     * Option fields
     * @param  array  $settings
     * @return string
     * @since {%= version %}
     */
    public function option_fields($settings){
        /*$active = (isset($_REQUEST['option_page'])) ? $_REQUEST['option_page'] : 'general' ;
        if ($active == 'categories') {
            ?>
                <div class="tab-pane" id="ap-categories">       
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><label for="enable_categories"><?php _e('Enable categories', 'ap'); ?></label></th>
                            <td>
                                <input type="checkbox" id="enable_categories" name="anspress_opt[enable_categories]" value="1" <?php checked( true, $settings['enable_categories'] ); ?> />
                                <p class="description"><?php _e('Enable or disable categories system', 'ap'); ?></p>
                            </td>
                        </tr>
                        
                    </table>
                </div>
            <?php
        }*/
        
    }

    /**
     * Append meta display
     * @param  array $metas
     * @param array $question_id        
     * @return array
     * @since {%= version %}
     */
    public function ap_display_question_metas($metas, $question_id)
    {   
        /*if(ap_question_have_category($question_id) && !is_singular('question'))
            $metas['categories'] = ap_question_categories_html(array('label' => __('Posted in ', 'categories_for_anspress')));*/

        return $metas;
    }

    /**
     * Append {%= title %} after question title
     * @param  object $post
     * @return string
     * @since {%= version %}
     */
    public function ap_before_question_title($post)
    {
        /*if(ap_question_have_category())
            echo '<div class="ap-posted-in">' . ap_question_categories_html(array('label' => __('Posted in ', 'categories_for_anspress'))) .'</div>';*/
    }
    /**
     * Enqueue scripts
     * @since {%= version %}
     */
    public function ap_enqueue()
    {
        wp_enqueue_style( '{%= safe_name %}_css', ap_get_theme_url('css/{%= safe_name %}.css', {%= constant %}_URL));
        
    }

    /**
     * add {%= title %} field in ask form
     * @param  array $validate
     * @return void
     * @since {%= version %}
     */
    public function ask_from_field($args, $editing){
        /*global $editing_post;

        if($editing){
            $category = get_the_terms( $editing_post->ID, 'question_category' );
            $catgeory = $category[0]->term_id;
        }

        $args['fields'][] = array(
            'name' => 'category',
            'label' => __('Category', 'ap'),
            'type'  => 'taxonomy_select',
            'value' => ( $editing ? $catgeory :  sanitize_text_field(@$_POST['category'] ))  ,
            'taxonomy' => 'question_category',
            'desc' => __('Select a topic that best fits your question', 'ap'),
            'order' => 6
        );*/

        return $args;
    }

    /**
     * add {%= title %} in validation field
     * @param  array $fields
     * @return array
     * @since  {%= version %}
     */
    public function ap_ask_fields_validation($args){
       /* $args['category'] = array(
            'sanitize' => array('only_int'),
            'validate' => array('required'),
        );*/

        return $args;
    }
    
    /**
     * Things to do after creating a question
     * @param  int $post_id
     * @param  object $post
     * @return void
     * @since {%= version %}
     */
    public function after_new_question($post_id, $post)
    {
        /*global $validate;

        if(empty($validate))
            return;

        $fields = $validate->get_sanitized_fields();

        if(isset($fields['category']))
            wp_set_post_terms( $post_id, $fields['category'], 'question_category' );*/
    }
}

/**
 * Get everything running
 *
 * @since 1.0
 *
 * @access private
 * @return void
 */

function anspress_ext_{%= safe_name %}() {
    $anspress_ext_{%= safe_name %} = new AnsPress_Ext_{%= safe_name %}();
}
add_action( 'plugins_loaded', 'anspress_ext_{%= safe_name %}' );

/**
 * Register activatin hook
 * @return void
 * @since  1.0
 */
function activate_{%= safe_name %}(){
    // create and check for categories base page
    
    /*$page_to_create = array('question_categories' => __('Categories', 'categories_for_anspress'), 'question_category' => __('Category', 'categories_for_anspress'));

    foreach($page_to_create as $k => $page_title){
        // create page
        
        // check if page already exists
        $page_id = ap_opt("{$k}_page_id");
        
        $post = get_post($page_id);

        if(!$post){
            
            $args['post_type']          = "page";
            $args['post_content']       = "[anspress_{$k}]";
            $args['post_status']        = "publish";
            $args['post_title']         = $page_title;
            $args['comment_status']     = 'closed';
            $args['post_parent']        = ap_opt('questions_page_id');
            
            // now create post
            $new_page_id = wp_insert_post ($args);
        
            if($new_page_id){
                $page = get_post($new_page_id);
                ap_opt("{$k}_page_slug", $page->post_name);
                ap_opt("{$k}_page_id", $page->ID);
            }
        }
    }*/
}
register_activation_hook( __FILE__, 'activate_{%= safe_name %}'  );
