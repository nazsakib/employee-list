<?php

/*
 * Plugin Name: Employee List
 * Plugin URI: https://sakibsnaz.vercel.app/
 * Description: Employee list of an organization.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Sakib MD Nazmush
 * Author URI: https://sakibsnaz.vercel.app/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: employee-list
 * Domain Path: /languages
 */

class Employee
{
    public function __construct()
    {
        add_action('init', array($this, 'employee_default_init'));
        add_action('add_meta_boxes', array($this, 'employee_metabox_callback'));
        add_action('save_post', array($this, 'employee_metabox_save'));
        add_action('admin_enqueue_scripts', array($this, 'jquery_ui_tabs'));
    }

    public function jquery_ui_tabs()
    {
        wp_enqueue_script('jquery-ui-tabs', array('jquery'));
        wp_enqueue_script('employee-script', PLUGINS_URL('js/custom.js', __FILE__), array('jquery', 'jquery-ui-tabs'));
        wp_enqueue_style('employee-style', PLUGINS_URL('css/style.css', __FILE__));
    }

    public function employee_default_init()
    {
        $labels = array(
            'name' => _x('Employee', 'Employee admin menu name', 'employee-list'),
            'singular_name' => _x('Employee', 'Employee admin singular name', 'employee-list'),
            'menu_name' => _x('Employee', 'Admin Menu text', 'employee-list'),
            'name_admin_bar' => _x('Employee', 'Add New on Toolbar', 'employee-list'),
            'add_new' => __('Add New', 'employee-list'),
            'add_new_item' => __('Add New Employee', 'employee-list'),
            'new_item' => __('New Employee', 'employee-list'),
            'edit_item' => __('Edit Employee', 'employee-list'),
            'view_item' => __('View Employee', 'employee-list'),
            'all_items' => __('All Employee', 'employee-list'),
            'search_items' => __('Search Employee', 'employee-list'),
            'parent_item_colon' => __('Parent Employee:', 'employee-list'),
            'not_found' => __('No Employee found.', 'employee-list'),
            'not_found_in_trash' => __('No Employee found in Trash.', 'employee-list'),
            'featured_image' => _x('Employee Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'employee-list'),
            'set_featured_image' => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'employee-list'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'employee-list'),
            'use_featured_image' => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'employee-list'),
            'archives' => _x('Employee archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'employee-list'),
            'insert_into_item' => _x('Insert into Employee', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'employee-list'),
            'uploaded_to_this_item' => _x('Uploaded to this Employee', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'employee-list'),
            'filter_items_list' => _x('Filter Employee list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'employee-list'),
            'items_list_navigation' => _x('Employee list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'employee-list'),
            'items_list' => _x('Employee list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'employee-list'),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'employee'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'menu_icon' => 'dashicons-groups',
            'supports' => array('title', 'editor', 'thumbnail'),
        );

        register_post_type('employee_list', $args);

        // taxonomy

        $labels = array(
            'name' => _x('Employee Types', 'taxonomy general name', 'employee-list'),
            'singular_name' => _x('Employee Type', 'taxonomy singular name', 'employee-list'),
            'search_items' => __('Search Employee Types', 'employee-list'),
            'all_items' => __('All Employee Types', 'employee-list'),
            'parent_item' => __('Parent Employee Type', 'employee-list'),
            'parent_item_colon' => __('Parent Employee Type:', 'employee-list'),
            'edit_item' => __('Edit Employee Type', 'employee-list'),
            'update_item' => __('Update Employee Type', 'employee-list'),
            'add_new_item' => __('Add New Employee Type', 'employee-list'),
            'new_item_name' => __('New Employee Type Name', 'employee-list'),
            'menu_name' => __('Employee Type', 'employee-list'),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'type'),
        );

        register_taxonomy('employee_type', array('employee_list'), $args);


    }

    // metabox function

    public function employee_metabox_callback()
    {
        add_meta_box('employee-info', 'Employee Information', array($this, 'employee_information'), 'employee_list', 'normal', 'high');
    }
    public function employee_information()
    {

        $value = get_post_meta(get_the_id(), 'employee-info', true);

        ?>

        <div id="tabs">
            <ul>
                <li><a href="#personal">Personal Information</a></li>
                <li><a href="#official">Official Information</a></li>
                <li><a href="#academic">Academic Information</a></li>
                <li><a href="#experience">Experiences</a></li>
            </ul>
            <div id="personal">
                <p><label for="father">Father's Name: </label></p>
                <p><input type="text" id="father" value="" name="father"></p>
                <p><label for="mother">Mother's Name: </label></p>
                <p><input type="text" id="mother" value="" name="mother"></p>
                <p>
                    Select your gender: <br>
                    <input type="radio" name="gender" value="male" id="male">
                    <label for="male"> Male</label> <br>
                    <input type="radio" name="gender" value="female" id="female">
                    <label for="female"> Female</label>
                </p>
            </div>
            <div id="official">
                <p><label for="designation">Designation: </label></p>
                <p><input type="text" id="designation" value="" name="designation"></p>
                <p><label for="salary">Salary: </label></p>
                <p><input type="text" id="salary" value="" name="salary"></p>
                <p><label for="running-year">Running Year: </label></p>
                <p><input type="text" id="running-year" value="" name="running-year"></p>
            </div>
            <div id="academic">
                <p><label for="ssc">SSC: </label></p>
                <p><input type="text" id="ssc" value="" name="ssc"></p>
                <p><label for="hsc">HSC: </label></p>
                <p><input type="text" id="hsc" value="" name="hsc"></p>
                <p><label for="hons">Undergraduate: </label></p>
                <p><input type="text" id="hons" value="" name="hons"></p>
            </div>
            <div id="experience">
                <p><label for="job">Previous Job: </label></p>
                <p><input type="text" id="job" value="" name="job"></p>
                <p><label for="year-xp">Year of Experience: </label></p>
                <p><input type="text" id="year-xp" value="" name="year-xp"></p>
            </div>
        </div>

    <?php }

    public function employee_metabox_save($post_id)
    {
        $designation = $_POST['designation'];
        update_post_meta($post_id, 'employee-info', $designation);
    }
}


$employee = new Employee();

?>
