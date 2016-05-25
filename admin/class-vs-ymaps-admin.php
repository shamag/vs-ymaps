<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       no
 * @since      1.0.0
 *
 * @package    Vs_Ymaps
 * @subpackage Vs_Ymaps/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vs_Ymaps
 * @subpackage Vs_Ymaps/admin
 * @author     shamag <otbacmhe@gmail.com>
 */
class Vs_Ymaps_Admin
{
    protected $data = array(
        'name' => 'maps',
        'title' => 'maps',
        'center_x' => "23.0000",
        'center_y' => "23.0000",
        'zoom' => "18",
       
    );
    protected $attr_names=['iconContent','latitude','balloonContentHeader','longitude','balloonContentBody','hintContent','legendContent','hintContent'];
    protected $placemark_count=10;
    protected $option_name = 'ym';
    protected $option_name_pl = 'ym_pl';
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action('admin_menu', array($this, 'mt_add_pages'));


// action function for above hook


    }

    function mt_add_pages()
    {
        register_setting('ym_options', $this->option_name, array($this, 'validate'));
        register_setting('ym_placemarks', $this->option_name_pl, array($this, 'validatePl'));
        add_menu_page('top', 'Yandex Maps', 8, __FILE__, array($this, 'mt_ym_options'));
        add_submenu_page(__FILE__, 'placemarks', 'placemarks', 8, 'sub-page', array($this, 'mt_ym_placemarks'));


        
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */

    public function validate($input)
    {

        $valid = array();
        $valid['name'] = sanitize_text_field($input['name']);
        $valid['title'] = sanitize_text_field($input['title']);
        $valid['center_x'] = sanitize_text_field($input['center_x']);
        $valid['center_y'] = sanitize_text_field($input['center_y']);
        $valid['zoom'] = sanitize_text_field($input['zoom']);
        $valid['placemarks_num'] = sanitize_text_field($input['placemarks_num']);

        if (strlen($valid['name']) == 0) {
            add_settings_error(
                'name',
                'name_texterror',
                'Please enter a valid name',
                'error'
            );
            $valid['name'] = $this->data['name'];
        }
        if (strlen($valid['title']) == 0) {
            add_settings_error(
                'title',
                'title_texterror',
                'Please enter a title',
                'error'
            );

            $valid['title'] = $this->data['title'];
        }
        if (strlen($valid['center_x']) == 0 and strlen($valid['center_y']) == 0) {
            add_settings_error(
                'center',
                'center_texterror',
                'Please enter coords',
                'error'
            );


            $valid['center_x'] = $this->data['center_x'];
            $valid['center_y'] = $this->data['center_y'];
        }
        if (strlen($valid['zoom']) == 0) {
            add_settings_error(
                'zoom',
                'zoom_texterror',
                'Please enter zoom',
                'error'
            );

            $valid['zoom'] = $this->data['zoom'];
        }
        if (strlen($valid['placemarks_num']) == 0) {
            add_settings_error(
                'placemarks_num',
                'placemarks_num_texterror',
                'Please enter placemarks_num',
                'error'
            );

            $valid['zoom'] = $this->data['zoom'];
        }


        return $valid;
    }

    public function validatePl($input)
    {

        $valid = array();
        $plName=$this->option_name_pl;
        $valid[0]=array(
            'iconContent'=>'icocontent',
            'latitude'=>58.602685,
            'balloonContentHeader'=>'балунхедер',
            'longitude'=>49.679009,
            'balloonContentBody'=> 'балунбоди',
            'hintContent'=>'подсказка',
            'legendContent'=>'legendContent'


        );
        $names=$this->attr_names;
        $func=function($value) use (&$valid,$names,$plName){
            $fnames =function($val) use(&$valid,$value,$plName){
                $valid[$value][$val]=$_POST[$plName.$val.($value+1)];
            };
            array_map($fnames,$names);

            return 0;
        };


        array_map($func,range(0,9));
      

        return $valid;
    }


    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Vs_Ymaps_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Vs_Ymaps_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/vs-ymaps-admin.css', array(), $this->version, 'all');

    }

    public function mt_ym_options()
    {
        $options = get_option($this->option_name);
        ?>
        <div class="wrap">
            <h2>Yandex maps settings </h2>
            <form method="post" action="options.php">
                <?php settings_fields('ym_options'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">name</th>
                        <td><input type="text" name="<?php echo $this->option_name ?>[name]"
                                   value="<?php echo $options['name']; ?>"/></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Title:</th>
                        <td><input type="text" name="<?php echo $this->option_name ?>[title]"
                                   value="<?php echo $options['title']; ?>"/></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Latitude</th>
                        <td><input type="text" name="<?php echo $this->option_name ?>[center_x]"
                                   value="<?php echo $options['center_x']; ?>"/></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"> Longitude</th>
                        <td><input type="text" name="<?php echo $this->option_name ?>[center_y]"
                                   value="<?php echo $options['center_y']; ?>"/></td>
                    </tr>


                    <tr valign="top">
                        <th scope="row">zoom:</th>
                        <td><input type="text" name="<?php echo $this->option_name ?>[zoom]"
                                   value="<?php echo $options['zoom']; ?>"/></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Number of placemarks</th>
                        <td><input type="text" name="<?php echo $this->option_name ?>[placemarks_num]"
                                   value="<?php echo $options['placemarks_num']; ?>"/></td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>"/>
                </p>
            </form>
        </div>;
    <?php }


    public function mt_ym_placemarks()
    {
        $options = get_option($this->option_name_pl);
        $mainopt=get_option($this->option_name);
        $pl_number=$this->placemark_count;
        if ((isset($mainopt['placemarks_num']))&&(ctype_digit($mainopt['placemarks_num'])&&(intval($mainopt['placemarks_num'])>0)))
            $pl_number=intval($mainopt['placemarks_num']);
        ?>
        <div class="wrap">
            <h2>Yandex maps settings </h2>
            <form method="post" action="options.php">
                <?php settings_fields('ym_placemarks'); ?>

                <table class="form-table">
                   
                <?php for ($i = 1; $i <= $pl_number; $i++) {
                        $html='';
                        $html.= '<tr >';
                        $html.= '<td colspan="2">Placemark '.$i.'</td>';
                        $html.='</tr>';
                        $html.='<tr valign="top">';
                        $html.='<th scope="row">iconContent</th>';
                        $html.='<td><input type="text" name="'.$this->option_name_pl.'iconContent'.$i.'" value="'.$options[$i-1]['iconContent'].'"/></td></tr>';
                        $html.='<tr><th scope="row">balloonContentHeader</th>';
                        $html.='<td><input type="text" name="'.$this->option_name_pl.'balloonContentHeader'.$i.'" value="'.$options[$i-1]['balloonContentHeader'].'"/></td>';
                        $html.='</tr>';
                        $html.='<tr valign="top">';
                        $html.='<th scope="row">balloonContentBody</th>';
                        $html.='<td><input type="text" name="'.$this->option_name_pl.'balloonContentBody'.$i.'" value="'.$options[$i-1]['balloonContentBody'].'"/></td></tr>';
                        $html.='<tr valign="top">';
                        $html.='<th scope="row">legendContent</th>';
                        $html.='<td><input type="text" name="'.$this->option_name_pl.'legendContent'.$i.'" value="'.$options[$i-1]['legendContent'].'"/></td></tr>';
                        $html.='<tr valign="top">';
                        $html.='<th scope="row">hintContent</th>';
                        $html.='<td><input type="text" name="'.$this->option_name_pl.'hintContent'.$i.'" value="'.$options[$i-1]['hintContent'].'"/></td></tr>';
                        $html.='<tr valign="top">';
                        $html.='<th scope="row">Latitude</th>';
                        $html.='<td><input type="text" name="'.$this->option_name_pl.'latitude'.$i.'" value="'.$options[$i-1]['latitude'].'"/></td></tr>';
                        $html.='<tr valign="top">';
                        $html.='<th scope="row">longitude</th>';
                        $html.='<td><input type="text" name="'.$this->option_name_pl.'longitude'.$i.'" value="'.$options[$i-1]['longitude'].'"/></td></tr>';
                        echo $html;
                 };
                    
                    ?>
                    
                </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>"/>
                </p>
            </form>
        </div>;
    <?php }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Vs_Ymaps_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Vs_Ymaps_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/vs-ymaps-admin.js', array('jquery'), $this->version, false);

    }

}
