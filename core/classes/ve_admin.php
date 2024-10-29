<?php
class VE_Admin extends VE_Manager_Abstract{
    var $license;
    function bootstrap(){
        if(!is_ve()){
            add_action('admin_enqueue_scripts',array($this,'loadScriptsWpAdminOnly'));
        }
        if(is_admin()){
            $this->adminHocks();
        }
        $this->license=$this->getVeManager()->get('license');

    }
    function adminHocks(){
        add_action( 'admin_menu', array($this,'buildAdminMenus') );
        add_action('wp_loaded',array($this,'onWpLoaded'));
        add_action('admin_init',array($this,'update'));
    }
    function update(){
        if(isset($_GET['ve-action'])&&$_GET['ve-action']==='logout'){
            $this->license->clear();
            wp_redirect(remove_query_arg('ve-action'));
            die;
        }
        if(isset($_POST['ve-action'])&&$_POST['ve-action']==='login'){
            $email=isset($_POST['email'])?$_POST['email']:'';
            $receipt=isset($_POST['receipt'])?$_POST['receipt']:'';
            $this->license->check($email,$receipt);
            wp_redirect(remove_query_arg('ve-action'));
            die;
        }
    }
    function onWpLoaded(){
        $ve_pages=array('ve-posts','ve-pages');
        if(isset($_GET['page'])){
            if(in_array($_GET['page'],$ve_pages)){
                unset($_GET['post_type']);
                unset($_REQUEST['post_type']);
                unset($_GET['_wp_http_referer']);
                add_filter( 'parse_query', array($this,'posts_filter') );
            }
        }
    }
    function posts_filter( $query ){
        if(is_admin()) {
            $query->query_vars['meta_key'] = '_use_ve';
            $query->query_vars['meta_value'] = '1';
        }

    }
    function loadScriptsWpAdminOnly(){
	    wp_enqueue_script('ve-admin-admin',ve_resource_url(VE_VIEW.'/js/admin/admin.js'),array('jQuery'));
    }
    function buildAdminMenus(){
        add_menu_page( __('AIO WP Builder', 'visual_editor' ),  __( 'AIO WP Builder', 'visual_editor' ), 'manage_categories', 'visual-editor-admin', array($this,'adminDashboard'));

        add_submenu_page( 'visual-editor-admin', __( 'Fonts', 'visual_editor' ), __( 'Fonts', 'visual_editor' ), 'manage_categories', 've-fonts', array($this->getVeManager()->get('FontManager'),'adminPage'));
        //add_submenu_page( 'visual-editor-admin', __( 'Ve Pages', 'visual_editor' ), __( 'Ve Pages', 'visual_editor' ), 'manage_categories', 've-pages', array($this,'adminListPages'));
        //add_submenu_page( 'visual-editor-admin', __( 'Create Page', 'visual_editor' ), __( 'Create Page', 'visual_editor' ), 'manage_categories', 'edit.php?ve_action=ve_inline&post_type=page&post_id=new', null);

        //add_submenu_page( 'visual-editor-admin', __( 'Ve Widgets', 'visual_editor' ), __( 'Ve Widgets', 'visual_editor' ), 'manage_categories', 'edit.php?post_type=ve-widget', null);
        //add_submenu_page( 'visual-editor-admin', __( 'Create Widget', 'visual_editor' ), __( 'Create Widget', 'visual_editor' ), 'manage_categories', 'edit.php?ve_action=ve_inline&post_type=ve-widget&post_id=new', null);

        //add_submenu_page( 'visual-editor-admin', __( 'Ve Popups', 'visual_editor' ), __( 'Ve Popups', 'visual_editor' ), 'manage_categories', 'edit.php?post_type=ve-popup', null);
        //add_submenu_page( 'visual-editor-admin', __( 'Create Popup', 'visual_editor' ), __( 'Create Popup', 'visual_editor' ), 'manage_categories', 'edit.php?ve_action=ve_inline&post_type=ve-popup&post_id=new', null);

        //add_submenu_page( 'visual-editor-admin', __( 'Ve Templates', 'visual_editor' ), __( 'Ve Templates', 'visual_editor' ), 'manage_categories', 'edit.php?post_type=ve-template', null);
        //add_submenu_page( 'visual-editor-admin', __( 'Create Template', 'visual_editor' ), __( 'Create Template', 'visual_editor' ), 'manage_categories', 'edit.php?ve_action=ve_inline&post_type=ve-template&post_id=new', null);
    }
    function adminListPages(){
        $this->_adminListPosts('page');
    }
    function adminListWidgets(){
        $this->_adminListPosts('ve-widget');
    }
    function _adminListPosts($typenow='post'){
        include VE_CORE.'/templates/list-posts.phtml';
    }
    function adminDashboard(){
        $license=$this->license;
        echo '<h1>AIO WP Builder Dashboard</h1>';
        include VE_CORE.'/templates/login.phtml';
    }
}