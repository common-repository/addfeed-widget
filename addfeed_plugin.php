<?php
/**
* Plugin Name: AddFeed订阅按钮 Widget
* Plugin URI: http://addfeed.cn
* Description: 适合中文网站的"订阅到"按钮，可放在侧栏Widget中。请进入：外观》小工具》拖放到侧栏
* Version: 1.0.1
*
* Author: 高飞
* Author URI: http://addfeed.cn/blog/
*/


if ( !defined('WP_CONTENT_URL') ) 
    define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content'); 
if ( !defined('WP_CONTENT_DIR') ) 
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' ); 
// Guess the location 
$addfeed_plugin_path = WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__)); 
$addfeed_plugin_url = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)); 
//$addfeed_plugin_url = WP_CONTENT_URL.'/plugins/addfeed-widget';

add_action( 'widgets_init', 'addfeed_load_widgets' );

function addfeed_load_widgets() {
	register_widget( 'addfeed_widget' );
}

class addfeed_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function addfeed_widget() { 
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'addfeed', 'description' => __('AddFeed: 适合中文博客的订阅按钮Widget.', 'addfeed') );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'addfeed-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'addfeed-widget', __('AddFeed订阅按钮', 'addfeed'), $widget_ops, $control_ops );
	}

	/**
	 * display the widget
	 */
	function widget( $args, $instance ) {
		extract( $args ); 

		$title = apply_filters('widget_title', $instance['title'] );
		$addfeed_url = isset( $instance['addfeed_url'] ) ? $instance['addfeed_url'] : get_bloginfo_rss('rss2_url');
		$addfeed_img = $instance['addfeed_img'];
		if ($addfeed_img!='') $addfeed_img = '<img src="'. $addfeed_img .'" alt="" align="absmiddle" />';
		$addfeed_event = isset( $instance['addfeed_event'] ) ? $instance['addfeed_event'] : "mouseover";

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display widget content. */
		echo '<script type="text/javascript" src="http://china-addthis.googlecode.com/svn/trunk/addfeed.js" charset="UTF-8"></script><span class="addfeed_cn"><a e="'. $addfeed_event .'" href="'. $addfeed_url .'" title="订阅我吧">'. $addfeed_img .'</a></span>';

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['addfeed_url'] = strip_tags( $new_instance['addfeed_url'] );
		$instance['addfeed_img'] = $new_instance['addfeed_img'];
		$instance['addfeed_img2'] = strip_tags( $new_instance['addfeed_img2'] );
		if ($instance['addfeed_img']=='manu' && $instance['addfeed_img2']!='') $instance['addfeed_img']=$instance['addfeed_img2'];
		$instance['addfeed_event'] = $new_instance['addfeed_event'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) {
		global $addfeed_plugin_url;
		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'addfeed_url' => get_bloginfo_rss('rss2_url'),'addfeed_img' => $addfeed_plugin_url."/f1.gif", 'addfeed_img2' => "",'addfeed_event' => 'mouseover' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?>(选填)</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'addfeed_url' ); ?>"><?php _e('Feed Url:', 'addfeed'); ?>(必须以http://等开头)</label>
			<input id="<?php echo $this->get_field_id( 'addfeed_url' ); ?>" name="<?php echo $this->get_field_name( 'addfeed_url' ); ?>" value="<?php echo $instance['addfeed_url']; ?>" style="width:100%;" />
		</p>

		<p>
			<label><?php _e('图片样式:', 'addfeed'); ?></label><br />
			<input name="<?php echo $this->get_field_name( 'addfeed_img' ); ?>" type="radio" value="<?php echo $addfeed_plugin_url; ?>/f1.gif"<?php if ($instance['addfeed_img']==$addfeed_plugin_url.'/f1.gif' || $instance['addfeed_img']=='') echo ' checked="checked"'; ?> /><img src="<?php echo $addfeed_plugin_url; ?>/f1.gif" alt="" /><br />
			<input name="<?php echo $this->get_field_name( 'addfeed_img' ); ?>" type="radio" value="<?php echo $addfeed_plugin_url; ?>/f2.gif"<?php if ($instance['addfeed_img']==$addfeed_plugin_url.'/f2.gif') echo ' checked="checked"'; ?> /><img src="<?php echo $addfeed_plugin_url; ?>/f2.gif" alt="" /><br />
			<input name="<?php echo $this->get_field_name( 'addfeed_img' ); ?>" type="radio" value="<?php echo $addfeed_plugin_url; ?>/f4.gif"<?php if ($instance['addfeed_img']==$addfeed_plugin_url.'/f4.gif') echo ' checked="checked"'; ?> /><img src="<?php echo $addfeed_plugin_url; ?>/f4.gif" alt="" />&nbsp; 
			<input name="<?php echo $this->get_field_name( 'addfeed_img' ); ?>" type="radio" value="<?php echo $addfeed_plugin_url; ?>/f5.gif"<?php if ($instance['addfeed_img']==$addfeed_plugin_url.'/f5.gif') echo ' checked="checked"'; ?> /><img src="<?php echo $addfeed_plugin_url; ?>/f5.gif" alt="" /><br />
			<input name="<?php echo $this->get_field_name( 'addfeed_img' ); ?>" type="radio" value="manu"<?php if ($instance['addfeed_img']=='manu') echo ' checked="checked"'; ?> />自定义图片:<br />
			<input id="<?php echo $this->get_field_id( 'addfeed_img2' ); ?>" name="<?php echo $this->get_field_name( 'addfeed_img2' ); ?>" value="<?php echo $instance['addfeed_img2']; ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'addfeed_event' ); ?>"><?php _e('触发事件类型:', 'addfeed'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'addfeed_event' ); ?>" name="<?php echo $this->get_field_name( 'addfeed_event' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'mouseover' == $instance['addfeed_event'] ) echo 'selected="selected"'; ?> value="mouseover">mouseover(鼠标移动到图标上)</option>
				<option <?php if ( 'click' == $instance['addfeed_event'] ) echo 'selected="selected"'; ?> value="click">click(鼠标点击)</option>
			</select>
		</p>


	<?php
	}
}

?>
