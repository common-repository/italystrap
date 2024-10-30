<?php

/**
 * Widget API: Widget_Posts class
 *
 * @package ItalyStrap
 * @since 2.0.0
 */

namespace ItalyStrap\Widgets;

if (! defined('ABSPATH') or ! ABSPATH) {
    die();
}

/**
 * Widget Class for post type
 */
class Monster extends Widget
{
    /**
     * Iterator (int).
     *
     * Used to set a unique html id attribute for each
     * widget instance generated by Monster_Widget::widget().
     *
     * @since 0.1
     */
    static $iterator = 1;

    /**
     * Init the constructor
     */
    function __construct()
    {

        /**
         * I don't like this and I have to find a better solution for loading script and style for widgets.
         */
        add_action('admin_enqueue_scripts', [$this, 'upload_scripts']);

        /**
         * Configure widget array.
         *
         * @var array
         */
        $args = [
            // Widget Backend label.
            'label'             => __('ItalyStrap Monster Widgets', 'italystrap'),
            // Widget Backend Description.
            'description'       => __('(Don\'t use this widget because it is in ALPHA version.) Test multiple widgets by ItalyStrap at the same time.', 'italystrap'),
            // 'fields'         => $this->get_widget_fields( require( ITALYSTRAP_PLUGIN_PATH . 'config/posts.php' ) ),
            'control_options'   => ['width' => 450],
            'widget_options'    => ['customize_selective_refresh' => true],
        ];

        /**
         * Create Widget
         */
        $this->create_widget($args);
    }

    /**
     * Dispay the widget content
     *
     * @param  array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param  array $instance The settings for the particular instance of the widget.
     * @return string           Return the output
     */
    public function widget_render($args, $instance)
    {

        $output = '';

        foreach ($this->get_widget_config() as $widget) {
            $_instance = $widget[1] ?? null;

            // $args['before_widget'] = sprintf(
            //  $before_widget,
            //  'italystrap_monster-widget-placeholder-' . self::$iterator,
            //  $this->get_widget_class( $widget[0] )
            // );

            ob_start();
            the_widget('ItalyStrap\\Widget\\' . $widget[0], $_instance, $args);

            $output .= ob_get_contents();
            ob_end_clean();

            self::$iterator++;
        }

        // $this->query->query( $this->get_query_args( $query_args ) );

        // ob_start();

        // include $this->get_template_part();
        // include \ItalyStrap\Core\get_template( '/templates/content-post.php' );

        // wp_reset_postdata();

        // $output = ob_get_contents();
        // ob_end_clean();

        return $output;
    }



    /**
     * Print the Monster widget on the front-end.
     *
     * @uses $wp_registered_sidebars
     * @uses Monster_Widget::$iterator
     * @uses Monster_Widget::get_widget_class()
     * @uses $this->get_widget_config()
     *
     * @since 0.1
     */
    // public function widget( $args, $instance ) {
    //  global $wp_registered_sidebars;

    //  $id = $args['id'];
    //  $args = $wp_registered_sidebars[$id];
    //  $before_widget = $args['before_widget'];

    //  foreach( $this->get_widget_config() as $widget ) {

    //      $_instance = ( isset( $widget[1] ) ) ? $widget[1] : null;

    //      $args['before_widget'] = sprintf(
    //          $before_widget,
    //          'italystrap_monster-widget-placeholder-' . self::$iterator,
    //          $this->get_widget_class( $widget[0] )
    //      );

    //      the_widget( 'ItalyStrap\\Widget\\' . $widget[0], $_instance, $args );

    //      self::$iterator++;
    //  }
 //    }

    /**
     * Widgets (array).
     *
     * Numerically indexed array of Pre-configured widgets to
     * display in every instance of a Monster widget. Each entry
     * requires two values:
     *
     * 0 - The name of the widget's class as registered with register_widget().
     * 1 - An associative array representing an instance of the widget.
     *
     * @uses Monster_Widget::get_text()
     *
     * This list can be altered by using the `monster-widget-config` filter.
     *
     * @return array Widget configuration.
     * @since 0.1
     */
    public function get_widget_config()
    {

        $widgets = [
            // array(
            //  'Carousel',
            //  array(
            //      'title'     => __( 'Bootstrap Carousel', 'italystrap' ),
            //      'ids'       => '1,2,3',
            //  )
            // ),
            ['Posts', ['title'    => __('ItalyStrap Posts', 'italystrap')]],
            ['VCard', ['title' => __('ItalyStrap VCard', 'italystrap')]],
        ];

        return apply_filters('italystrap_monster_widget_config', $widgets);
    }

    /**
     * Get the html class attribute value for a given widget.
     *
     * @uses $wp_widget_factory
     *
     * @param string $widget The name of a registered widget class.
     * @return string Dynamic class name a given widget.
     *
     * @since 0.1
     */
    public function get_widget_class($widget)
    {
        global $wp_widget_factory;

        $widget_obj = '';
        if (isset($wp_widget_factory->widgets[$widget])) {
            $widget_obj = $wp_widget_factory->widgets[$widget];
        }

        if (! is_a($widget_obj, 'WP_Widget')) {
            return '';
        }

        if (! isset($widget_obj->widget_options['classname'])) {
            return '';
        }

        return $widget_obj->widget_options['classname'];
    }

    /**
     * Widget Breaker Text.
     *
     * Used to populate the Text widget with html designed
     * to "break" out of the sidebar.
     *
     * The "monster-widget-get-text" filter can be used
     * to modify the output.
     *
     * @since 0.1
     */
    public function get_text()
    {
        $html = [];

        $html[] = '<strong>' . __('Large image: Hand Coded', 'italystrap') . '</strong>';
        $html[] = '<img src="' . esc_url(plugin_dir_url(__FILE__) . 'images/bikes.jpg') . '" alt="" class="size-large img-responsive">';

        $html[] = '<strong>' . __('Large image: linked in a caption', 'italystrap') . '</strong>';
        $html[] = '<div class="wp-caption alignnone"><a href="#"><img src="' . esc_url(plugin_dir_url(__FILE__) . 'images/bikes.jpg') . '" class="size-large img-responsive" height="720" width="960" alt=""></a><p class="wp-caption-text">' . __('This image is 960 by 720 pixels.', 'italystrap') . ' ' . convert_smilies(':)') . '</p></div>';

        $html[] = '<strong>' . __('Meat!', 'italystrap') . '</strong>';
        $html[] = __('Hamburger fatback andouille, ball tip bacon t-bone turkey tenderloin. Ball tip shank pig, t-bone turducken prosciutto ground round rump bacon pork chop short loin turkey. Pancetta ball tip salami, hamburger t-bone capicola turkey ham hock pork belly tri-tip. Biltong bresaola tail, shoulder sausage turkey cow pork chop fatback. Turkey pork pig bacon short loin meatloaf, chicken ham hock flank andouille tenderloin shank rump filet mignon. Shoulder frankfurter shankle pancetta. Jowl andouille short ribs swine venison, pork loin pork chop meatball jerky filet mignon shoulder tenderloin chicken pork.', 'italystrap');

        $html[] = '<strong>' . __('Smile!', 'italystrap') . '</strong>';
        $html[] = convert_smilies(';)') . ' ' . convert_smilies(':)') . ' ' . convert_smilies(':-D');

        $html[] = '<strong>' . __('Select Element with long value', 'italystrap') . '</strong>';

        $html[] = '<form method="get" action="/">';
        $html[] = '<select name="monster-widget-just-testing">';
        $html[] = '<option value="0">' . __('First', 'italystrap') . '</option>';
        $html[] = '<option value="1">' . __('Second', 'italystrap') . '</option>';
        $html[] = '<option value="2">' . __('Third', 'italystrap') . ' OMG! How can one option contain soooo many words? This really is a lot of words.</option>';
        $html[] = '</select>';
        $html[] = '</form>';

        $html = implode("\n", $html);

        return apply_filters('monster-widget-get-text', $html);
    }
} // Class.
