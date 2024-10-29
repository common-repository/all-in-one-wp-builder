<?php
class VeCore_VeVideo extends Ve_Element implements VE_Element_Interface{
    function __construct(){
        $id_base='ve_video';
        $name='Video';
        $options=array(
            'title'=>'Video',
            'description'=>'Button description',
            'icon_class'=>'fa fa-youtube-play',
            'container'=>false,
            'has_content'=>false,
            'defaults'=>array(),

        );
        parent::__construct($id_base,$name,$options);
    }
    function init(){
        $this->support('CssEditor');
    }
    function element($instance,$content=''){
        $title=$link=$class=$remove_title=$remove_controls=$auto_play='';
        extract( shortcode_atts( array(
            'title' => '',
            'link' => 'https://www.youtube.com/watch?v=pCQUMAD-Jao',
            'size' => ( isset( $content_width ) ) ? $content_width : 500,
            'class' => '',
            'css' => '',
            'auto_play' => '',
            'remove_title' => '',
            'remove_control' => ''

        ), $instance ) );

        $this->addClass($class);

        $video_w = ( isset( $content_width ) ) ? $content_width : 500;
        $video_h = $video_w / 1.61; //1.61 golden ratio
        global $wp_embed;
        /**
         * @var WP_Embed $wp_embed
         */

        if (stripos($link, "youtube.com") !== "false" || stripos($link, "youtu.be") !== false)
        {
            $embed = $this->cookLink($link, $instance, $video_w, $video_h);
        } else

        {
            $embed = $wp_embed->run_shortcode( '[embed width="' . $video_w . '"' . $video_h . ']' . $link . '[/embed]' );
        }

        //echo $embed;die;
        $this->element_title($title);
        $embed=sprintf('<div class="video-container">%s</div>',$embed);
        $this->element_content($embed);


    }
    function cookLink($link, $instance, $video_w, $video_h)
    {
        $remove_title = isset($instance['remove_title']) ? $instance['remove_title'] : "";
        $remove_controls = isset($instance['remove_control']) ? $instance['remove_control'] : "";
        $autoplay = isset($instance['auto_play']) ? $instance['auto_play'] : "";
        $link = "https://www.youtube.com/embed/" . $this->getYTID($link);

        $link .= "?rel=0&modestbranding=1";
        if ($remove_title == "on")
        {
            $link .= "&showinfo=0";
        } else
        {
            $link = str_replace("&showinfo=0", "", $link);
        }

        if ($remove_controls =="on")
        {
            $link.= "&controls=0";
        } else
        {
            $link = str_replace("&controls=0", "", $link);
        }

        if ($autoplay == "on")
        {
            $link .= "&autoplay=1";
        } else
        {
            $link = str_replace("&autoplay=1", "", $link);
        }
        return '<iframe width="'.$video_w.'" height="'.$video_h.'" src="'.$link.'" frameborder="0" allowfullscreen></iframe>';
    }
	function getYTID($link)
	{
		if (stripos("youtu.be", $link) !== false) {
			$id = explode("/", $link);

			if (count($id) > 0) {
				return $id[0];
			}
		}
		preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $link, $result);
//        preg_match('/=[a-zA-Z0-9\\-\\_]*/', $link, $result);
		return str_replace("=", "", $result[1]);
	}

    function form($instance,$content=''){
        $instance=wp_parse_args($instance,array('title'=>'','link'=>'','class'=>'', 'remove_title'=>'', 'remove_control' => '', 'auto_play' => ''));
        $title=esc_attr($instance['title']);
        $video_link=esc_attr($instance['link']);
        $class=esc_attr($instance['class']);
        $remove_title = esc_attr($instance['remove_title']);
        $remove_controls = esc_attr($instance['remove_control']);
        $auto_play = esc_attr($instance['auto_play']);

        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo('Title:'); ?></label> <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('link'); ?>"><?php echo('Video Link:'); ?></label> <input id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $video_link; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('remove_title'); ?>"><?php echo('Remove title?'); ?></label> <input id="<?php echo $this->get_field_id('remove_title'); ?>" name="<?php echo $this->get_field_name('remove_title'); ?>" type="checkbox" <? echo ($remove_title == "" ? "" : "checked"); ?> /></p>

        <p><label for="<?php echo $this->get_field_id('remove_control'); ?>"><?php echo('Remove controls?'); ?></label> <input id="<?php echo $this->get_field_id('remove_control'); ?>" name="<?php echo $this->get_field_name('remove_control'); ?>" type="checkbox" <? echo ($remove_controls == "" ? "" : "checked"); ?>/></p>
        <p><label for="<?php echo $this->get_field_id('auto_play'); ?>"><?php echo('Autoplay?'); ?></label> <input id="<?php echo $this->get_field_id('auto_play'); ?>" name="<?php echo $this->get_field_name('auto_play'); ?>" type="checkbox" <? echo ($auto_play == "" ? "" : "checked"); ?>/></p>
        <p><label for="<?php echo $this->get_field_id('class'); ?>"><?php echo('Extra class:'); ?></label> <input id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo $class; ?>" /></p>

    <?php
    }
}
