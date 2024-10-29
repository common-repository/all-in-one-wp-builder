<?php
class VE_Layout_Manager extends VE_Manager_Abstract{
    var $useVeTemplate=false;
    function _construct(){

    }
    function bootstrap(){
        add_filter('page_template',array($this,'pageTemplate'));
        add_action('wp_head',array($this,'wpHead'),2);
        add_action('wp_head',array($this,'removeAutoP'));
        add_action('wp_head',array($this,'addHeadTags'));
        add_action('wp',array($this,'templateCheck'));
    }
    function addHeadTags(){
        $post=get_post();

        if($post) {
            $post_id = $post->ID;
            $use_ve = get_post_meta($post_id, '_use_ve', true);
            $metas = get_post_meta($post_id,'_ve_metas',true);
            if ($use_ve == '1') {
                if (!empty($metas['post_description']))
                    echo ' <meta name="description" content="'.htmlentities($metas['post_description']).'">'."\n";
                if (!empty($metas['post_tags']))
                    echo ' <meta name="keywords" content="'.htmlentities($metas['post_tags']).'">'."\n";
                if (!empty($metas['facebook_pixel']))
                    echo $metas['facebook_pixel']."\n";


                $robots=array();
                $robots[0]=empty($metas['post_noindex'])?'index':'noindex';
                $robots[1]=empty($metas['post_nofollow'])?'follow':'nofollow';
                $robots=implode(',',$robots);
                echo ' <meta name="robots" content="'.$robots.'">'."\n";

                if (!empty($metas['tracking_code']))
                    echo $metas['tracking_code']."\n";


            }
        }
    }
    function removeWpRobot(){
        remove_action('wp_head','noindex',1);
    }
    function removeAutoP(){
        $post=get_post();
        if($post) {
            $post_id = $post->ID;
            $use_ve = get_post_meta($post_id, '_use_ve', true);
            if ($use_ve == '1') {
                //remove_filter('the_content', 'wpautop');
                //add_filter('the_content', array($this,'nlToBr'));
            }
        }
    }

    function nlToBr($content)
    {
        $content = nl2br($content);
        return $content;
    }
    function templateCheck(){
        $use_ve = get_post_meta(get_the_ID(), '_use_ve', true);
        $page_template=get_page_template_slug();
        if($use_ve&&$page_template==='' || is_ve()){
            $this->useVeTemplate=true;
        }
        if($use_ve){
            $this->removeWpRobot();
        }
    }
    function pageTemplate($template){
        $_template = "full-width.php";
        if($this->useVeTemplate){
            $ve_template=VE_PAGE_TEMPLATE_DIR.'/'.$_template;
            if(file_exists($ve_template)){
                return $ve_template;
            }
        }
        return $template;
    }

    function wpHead(){
        global $wp_styles,$wp_scripts;
        /**
         * @var $wp_styles WP_Styles
         * @var $wp_scripts WP_Scripts
         */
        if($this->useVeTemplate) {
            $theme_style = array();
            foreach ($wp_styles->registered as $handle => $style) {
                if (strpos($style->src, get_stylesheet_directory_uri()) !== false) {
                    $theme_style[] = $handle;
                }

            }
            $wp_styles->dequeue($theme_style);
            $theme_scripts = array();
            foreach ($wp_scripts->registered as $handle => $script) {
                if (strpos($script->src, get_stylesheet_directory_uri()) !== false) {
                    $theme_scripts[] = $handle;
                }
            }
            $wp_scripts->dequeue($theme_scripts);
        }
        //var_dump($wp_styles->queue);
        //wp_enqueue_style();
    }

}