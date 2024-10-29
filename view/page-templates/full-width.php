<?php
/**
 * Template Name: Ve Full Width
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_enqueue_script('jquery'); ?>
    <?php if(!get_theme_support('title-tag')){?>
    <title><?php wp_title();?></title>
    <?php }?>
    <?php wp_head();?>
    <?php
    $post=get_post();
    $background_color=$post->background_color;
    $background_image=$post->background_image;
    $background_style=$post->background_style;
    $background_opacity=$post->background_opacity;
    ?>
    <style type="text/css">
        body{
        <?php if($background_color){
            if($background_opacity){
                list($r,$g,$b)=ve_hex2rgb($background_color);
                printf('background-color:rgba(%s,%s,%s,%s);',$r,$g,$b,$background_opacity);
            }else{
                echo 'background-color:'.$background_color.';';
            }
        }?>
        <?php if($background_image){
            list($background_image_src,$width,$height)=wp_get_attachment_image_src($background_image,'full');
            printf('background-image:url(%s);',$background_image_src);
        }?>
        <?php if($background_style){
            $style_name='';
            switch($background_style) {
                case 'cover':
                $style_name = 'background-size';
                //$val = 'coverage';
                break;
                case 'contain':
                    $style_name = 'background-size';
                    break;
                case 'no-repeat':
                    $style_name='background-repeat';

                    break;
                case 'repeat':
                    $style_name='background-repeat';
                    break;
            }
            if($style_name){
                printf('%s:%s;',$style_name,$background_style);
            }
        }?>
        }
    </style>
    <?php if(!empty($background_image_src)){?>
    <script type="text/javascript">
        (function(){
            var image=new Image();
            image.src="<?php echo $background_image_src;?>";
        })();
    </script>
    <?php }?>

</head>
<body <?php body_class();?>>
<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<?php the_post();
$customStyle='';
if($width=ve_get_post_setting('screen_size')){
    $width = intval($width) - 52;
    $customStyle.='max-width:'.$width.'px;';
}
if($customStyle){
    $customStyle=sprintf(' style="%s"',$customStyle);
}
?>
<div class="ve-container"<?php echo $customStyle;?>>
    <?php the_content();?>
</div>
<?php wp_footer();?>
</body>
</html>
