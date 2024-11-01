<?php
/*
Plugin Name: Video Chat
Plugin URI: http://www.camamba.com/free_chat_applet.php
Description: A free video chat for your Wordpress
Version: 1.1.4
Author: Thomas Auge
Author URI: http://www.camamba.com/
License: GPLv3
*/

/*  Copyright 2012  Thomas Auge  (email : webmaster@camamba.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


function camambaChatBlock($args)
{
	?>
<script type="text/javascript">
	
function openVideochat() {
	if (document.getElementById('CMBuser')) var user = document.getElementById('CMBuser').value;
	var lang = 'english';
	if (document.getElementById('CMBgender')) var gender = document.getElementById('CMBgender').options[document.getElementById('CMBgender').selectedIndex].value;
	if (document.getElementById('CMBage')) var age = document.getElementById('CMBage').value;

	var roomid = "<?php echo get_option('roomName', str_replace(array('http://', 'www.'), array('', ''), $_SERVER['SERVER_NAME'])); ?>";

	user = user.replace(/[\<\>]/g, '');
	age = age.replace(/[\<\>]/g, '');
	gender = gender.replace(/[\<\>]/g, '');

	var form = document.createElement('form');
	form.setAttribute('method', 'post');
	form.setAttribute('action', 'http://www.camamba.com/webcam_window_v4e.php');
	form.setAttribute('target', 'CamambaExt');

	var fUser = document.createElement('input');
	fUser.setAttribute('type', 'hidden');
	fUser.setAttribute('name', 'user');
	fUser.setAttribute('value', user);
	form.appendChild(fUser);

	var fLang = document.createElement('input');
	fLang.setAttribute('type', 'hidden');
	fLang.setAttribute('name', 'lang');
	fLang.setAttribute('value', lang);
	form.appendChild(fLang);

	var fAge = document.createElement('input');
	fAge.setAttribute('type', 'hidden');
	fAge.setAttribute('name', 'setage');
	fAge.setAttribute('value', age);
	form.appendChild(fAge);

	var fGender = document.createElement('input');
	fGender.setAttribute('type', 'hidden');
	fGender.setAttribute('name', 'setgender');
	fGender.setAttribute('value', gender);
	form.appendChild(fGender);

	var fRoom = document.createElement('input');
	fRoom.setAttribute('type', 'hidden');
	fRoom.setAttribute('name', 'setroom');
	fRoom.setAttribute('value', roomid);
	form.appendChild(fRoom);

	<?php
	if (!get_option('camambaChatBgImg'))
	{
	?>
	var fBgColor = document.createElement('input');
	fBgColor.setAttribute('type', 'hidden');
	fBgColor.setAttribute('name', 'themeBackground');
	fBgColor.setAttribute('value', '<?php echo get_option('camambaChatBg', "000044"); ?>');
	form.appendChild(fBgColor);
	<?php
	}
	?>

	var fFontColor = document.createElement('input');
	fFontColor.setAttribute('type', 'hidden');
	fFontColor.setAttribute('name', 'fontColor');
	fFontColor.setAttribute('value', '<?php echo get_option('camambaFontColor', "cccccc"); ?>');
	form.appendChild(fFontColor);
	<?php
	if (get_option('camambaChatBgImg'))
	{
	?>
	var fBgImg = document.createElement('input');
	fBgImg.setAttribute('type', 'hidden');
	fBgImg.setAttribute('name', 'bgImage');
	fBgImg.setAttribute('value', '<?php echo get_option('camambaChatBgImg', ""); ?>');
	form.appendChild(fBgImg);
	<?php
	}
	?>
	var fCam = document.createElement('input');
	fCam.setAttribute('type', 'hidden');
	fCam.setAttribute('name', 'camImage');
	fCam.setAttribute('value', '<?php echo get_option('camambaCamBg', "http://www.camamba.com/chatConfig/camBGext.jpg"); ?>');
	form.appendChild(fCam);
	<?php
	if (get_option('camambaLogoImg', ""))
	{
	?>
	var fLogo = document.createElement('input');
	fLogo.setAttribute('type', 'hidden');
	fLogo.setAttribute('name', 'logoImage');
	fLogo.setAttribute('value', '<?php echo get_option('camambaLogoImg', ""); ?>');
	form.appendChild(fLogo);
	<?php
	}
	?>
	<?php
	if (is_admin()) { ?>
	if (document.getElementById('CMBadmin')) {
		var admval = document.getElementById('CMBadmin').value;
		var fAdm = document.createElement('input');
		fAdm.setAttribute('type', 'hidden');
		fAdm.setAttribute('name', 'adm');
		fAdm.setAttribute('value', admval);
		form.appendChild(fAdm);
	}
	<?php
	}
	?>
       
	document.body.appendChild(form);

	var h = screen.height - 100;
	var w = screen.width - 20;
	if (h>800) h = 800;
	if (w>1200) w = 1200;
	camwindow = window.open('', 'CamambaExt','resizable,width='+w+',height='+h);

	form.submit();

	camwindow.focus();
}
</script>
	<?php
	if (!is_admin()) { 
		echo $args['before_widget'];
		echo $args['before_title']; ?>Video Chat<?php echo $args['after_title'];
	}
	?>
    <div style='text-align: center; width: 165px; font-size: 0.8em;'>
        <div style="text-align: center; padding-bottom: 5px;">
				<?php
				// Check for available user name
				global $current_user;
				get_currentuserinfo();
				if ($current_user AND $current_user->display_name) {
				?>
				<input type='hidden' id='CMBuser' value="<?php echo $current_user->display_name; ?>">
				<?php } else { ?>
				<input style="font-size: 1em; width: 130px; margin-top: 4px;" name='CMBuser' type='text' id='CMBuser' maxlength='50' value='<?php echo "Guest ".rand(100, 999);?>'><br>
				<?php } ?>
				<div style="margin-top: 4px;">
					<select style="font-size: 1em; width: 60px;" id='CMBgender' name='CMBgender'>
						<option value='male'>male</option>
						<option value='female'>female</option>
					</select>, age <input style="font-size: 1em;" type='text' id='CMBage' name='CMBage' size='2' maxlength='2' value='99'>
				</div>
				<?php
				if (is_admin()) { ?>
					Moderator Password:<br><input style="font-size: 1em; width: 120px;" name='CMBadmin' type='password' id='CMBadmin' maxlength='30' value=''>
				<?php
				}
				?>
        </div>
        <input onClick=javascript:openVideochat() type='button' value='Enter Video Chat' style='width: 130px;' class="button">
		 <?php if (get_option('camambaPowered')) { ?><div style="text-align: center; font-size: 0.9em;"><a href='http://www.camamba.com/'>Webcam Chat by Camamba</a></div><?php } ?>
    </div>
<?php if (!is_admin()) echo $args['after_widget']; ?>	
<?php	
}

//add_action( 'wp_meta', 'camambaChatBlock' );
function camambaWidget_init()
{
  register_sidebar_widget(__('Video Chat'), 'camambaChatBlock');
}
add_action("plugins_loaded", "camambaWidget_init");




/***************
 * Admin Panel *
 ***************/

function camambaChatConfig()
{
	add_options_page('Video Chat Configuration', 'Video Chat', 'manage_options', 'camamba', 'camambaChatOptions');
	add_action( 'admin_init', 'registerCamambaSettings' );
}
add_action('admin_menu', 'camambaChatConfig');


function registerCamambaSettings() {
	register_setting( 'cmb-settings-group', 'camambaChatBg' );
	register_setting( 'cmb-settings-group', 'camambaFontColor' );
	register_setting( 'cmb-settings-group', 'camambaCamBg' );
	register_setting( 'cmb-settings-group', 'camambaChatBgImg' );
	register_setting( 'cmb-settings-group', 'camambaLogoImg' );
	register_setting( 'cmb-settings-group', 'roomName' );
	register_setting( 'cmb-settings-group', 'camambaPowered' );
}


function camambaChatOptions() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	?>
<div class="wrap">
<h2>Video Chat Settings</h2>
<p><b>This plugin is a widget. Don't forget to add it at the Appearance &raquo; Widgets config.</b></p>
<form method="post" action="options.php">
    <?php settings_fields( 'cmb-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><b>Activate "powered by" Link</b></th>
        <td>
			  <input type="radio" name="camambaPowered" value="1"<?php if (get_option('camambaPowered')) echo " checked"; ?>>Yes <input type="radio" name="camambaPowered" value="0"<?php if (!get_option('camambaPowered')) echo " checked"; ?>>No
		  </td>
        </tr>
		  <tr>
			  <th scope="row" colspan="2">Display a small "Video Chat by Camamba" link below the chat block. Activating this would make the Camamba very happy. :-)</th>
		  </tr>

        <tr valign="top">
			  <th scope="row"><b>Chat Background Color</b></th>
			  <td>#<input type="text" name="camambaChatBg" value="<?php echo get_option('camambaChatBg', "000044"); ?>" size="8" maxlength="6"/></td>
        </tr>
		  <tr>
			  <th scope="row" colspan="2">Base color for the chat background gradient. Background Image must be empty to use a background gradient!</th>
		  </tr>

		  <tr valign="top">
			  <th scope="row"><b>Chat Background Image</b></th>
			  <td><input type="text" name="camambaChatBgImg" value="<?php echo get_option('camambaChatBgImg', ""); ?>" size="60" /></td>
        </tr>
		  <tr>
			  <th scope="row" colspan="2">URL to a background image for your chat. Remember that the chat layout is dynamic depending on the users screen resolution, when creating a background image. This overrides the background color!</th>
		  </tr>

        <tr valign="top">
        <th scope="row"><b>Default Chat Text Color</b></th>
			  <td>#<input type="text" name="camambaFontColor" value="<?php echo get_option('camambaFontColor', "cccccc"); ?>"  size="8" maxlength="6" /></td>
			  </tr>
		  <tr>
			  <th scope="row" colspan="2">Default font color for your chatters.</th>
		  </tr>
		  
        <tr valign="top">
        <th scope="row"><b>Cam Background Image</b></th>
			  <td>#<input type="text" name="camambaCamBg" value="<?php echo get_option('camambaCamBg', "http://www.camamba.com/chatConfig/camBGext.jpg"); ?>" size="60" /></td>
			  </tr>
		  <tr>
			  <th scope="row" colspan="2">URL to a background image for your cam windows. Recommended size is 320x240.</th>
		  </tr>
		  
        <tr valign="top">
        <th scope="row"><b>Cam Logo Image</b></th>
			  <td><input type="text" name="camambaLogoImg" value="<?php echo get_option('camambaLogoImg', ""); ?>" size="60" /></td>
			  </tr>
		  <tr>
			  <th scope="row" colspan="2">URL to a logo image to be used in the corner of your cam windows. Recommended width are 50 pixel.</th>
		  </tr>
		  
        <tr valign="top">
			  <th scope="row"><b>Room Name</b></th>
			  <td><input type="text" name="roomName" value="<?php echo get_option('roomName', str_replace(array('http://', 'www.'), array('', ''), $_SERVER['SERVER_NAME'])); ?>" /></td>
        </tr>
		  <tr>
			  <th scope="row" colspan="2">This defaults to your servers domain name. Only change this if you are on a shared domain or want to share rooms across sites. Room Name must be an existing domain or subdomain.</th>
		  </tr>
    </table>
    <p class="submit">
	    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
</form>
	 <p>
		 <b><a href="http://www.camamba.com/admin_create.php" target=_blank>&raquo; Set up a moderator password at Camamba.</a></b>
	 </p>
	 <h3>Moderator Chat Login:</h3>
	 <?php camambaChatBlock(null); ?>
	 <p><b>WARNING: A ban lasts three hours and cannot be reversed. And yes, you can ban yourself. :-)</b></p>
</div>
<?php
}

function add_settings_link($links, $file) {
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
	
	if ($file == $this_plugin) {
		$settings_link = '<a href="options-general.php?page=camamba">Settings</a>';
		$links[] = $settings_link;
	}
	return $links;
 }
 add_filter('plugin_action_links', 'add_settings_link', 10, 2 );
?>