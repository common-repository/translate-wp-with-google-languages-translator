<?php
/*
Plugin Name: Translate WordPress with Google Languages Translator
Plugin URI: https://wordpress.org/plugins/translate-wp-with-google-languages-translator/
Version: 1.0
Description: Simple and powerful Google Translator plugin. Use it with a shortcode or with a widget, and make your website multilingual and accessible to everybody on the internet.
Author: Leonard Hall
*/

class Google_Languages_Translator_Main {

	protected static $_languages;

	public static function getVersion() {
		
		return '1';
		
	}
	
	public static function initialize() {

		Google_Languages_Translator_Admin_Form::initialize();

		add_action('widgets_init', array('Google_Languages_Translator_Main', '_register_widget'));

		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array('Google_Languages_Translator_Main', '_add_settings_link'));

	}
	
	public static function _add_settings_link($_links) {
		
		$link = array(
			'<a href="' . admin_url('options-general.php?page=translate-wordpress-google-languages-translator' ) . '">' . __('Settings', 'glt_text') . '</a>',
		);
		
		return array_merge($_links, $link);

	}
	
	public static function _admin_js() {

		wp_enqueue_script('glt-translator-admin', plugins_url('assets/admin.js', __FILE__), array('jquery'), self::getVersion());

		wp_register_style('glt-translator-admin-css', plugins_url('assets/admin.css', __FILE__), array(), self::getVersion());
		wp_enqueue_style('glt-translator-admin-css');

		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');

	}

	public static function isLoadingAdminPage() {
	
		$page = isset($_GET['page']) ? $_GET['page'] : false;
	
		return $page == 'translate-wordpress-google-languages-translator';
	
	}

	public static function getLanguages() {
		
		if (!empty(self::$_languages))
			return self::$_languages;
			
		$languages = array(
			'en' => 'English',
			'fr' => 'French',
			'nl' => 'Dutch',
			'el' => 'Greek',
			'de' => 'German',
			'es' => 'Spanish',
			'zh-CN' => 'Chinese Simplified',
			'zh-TW' => 'Chinese Traditional',
			'pl' => 'Polish',
			'pt' => 'Portuguese',
			'th' => 'Thai',
			'pa' => 'Punjabi',
			'ro' => 'Romanian',
			'ru' => 'Russian',
			'no' => 'Norwegian',
			'da' => 'Danish',
			'fi' => 'Finnish',
			'hi' => 'Hindi',
			'it' => 'Italian',
			'ja' => 'Japanese',
			'af' => 'Afrikaans',
			'sq' => 'Albanian',
			'ar' => 'Arabic',
			'hy' => 'Armenian',
			'az' => 'Azerbaijani',
			'eu' => 'Basque',
			'be' => 'Belarusian',
			'bn' => 'Bengali',
			'bs' => 'Bosnian',
			'bg' => 'Bulgarian',
			'ca' => 'Catalan',
			'ceb' => 'Cebuano',
			'ny' => 'Chichewa',
			'hr' => 'Croatian',
			'cs' => 'Czech',
			'et' => 'Estonian',
			'st' => 'Sesotho',
			'gl' => 'Galician',
			'ka' => 'Georgian',
			'gu' => 'Gujarati',
			'ht' => 'Haitian Creole',
			'ha' => 'Hausa',
			'iw' => 'Hebrew',
			'hmn' => 'Hmong',
			'hu' => 'Hungarian',
			'is' => 'Icelandic',
			'ig' => 'Igbo',
			'id' => 'Indonesian',
			'ga' => 'Irish',
			'jw' => 'Javanese',
			'kn' => 'Kannada',
			'kk' => 'Kazakh',
			'km' => 'Khmer',
			'ko' => 'Korean',
			'lo' => 'Lao',
			'la' => 'Latin',
			'lv' => 'Latvian',
			'lt' => 'Lithuanian',
			'mk' => 'Macedonian',
			'mg' => 'Malagasy',
			'ms' => 'Malay',
			'ml' => 'Malayalam',
			'mt' => 'Maltese',
			'mi' => 'Maori',
			'mr' => 'Marathi',
			'mn' => 'Mongolian',
			'my' => 'Burmese',
			'ne' => 'Nepali',
			'fa' => 'Persian',
			'sr' => 'Serbian',
			'tl' => 'Filipino',
			'si' => 'Sinhala',
			'sk' => 'Slovak',
			'sl' => 'Slovenian',
			'so' => 'Somali',
			'su' => 'Sundanese',
			'sw' => 'Swahili',
			'sv' => 'Swedish',
			'tg' => 'Tajik',
			'ta' => 'Tamil',
			'tr' => 'Turkish',
			'uk' => 'Ukrainian',
			'ur' => 'Urdu',
			'uz' => 'Uzbek',
			'vi' => 'Vietnamese',
			'cy' => 'Welsh',
			'yi' => 'Yiddish',
			'yo' => 'Yoruba',
			'zu' => 'Zulu',
			'te' => 'Telugu',
			'eo' => 'Esperanto'
		);
		
		asort($languages);
		
		return self::$_languages = $languages;
		
	}
	
	public static function _register_widget() {
		
		register_widget('Google_Languages_Translator_Widget');
		
	}

}

class Google_Languages_Translator_Admin_Form {
	
	public static function initialize() {
		
		if (!is_admin())
			return;

		add_action('admin_menu', array('Google_Languages_Translator_Admin_Form', '_initialize_menu'));
		add_action('admin_init', array('Google_Languages_Translator_Admin_Form', '_initialize_settings'));
		
		self::_load_admin_assets();
		
	}
	
	protected static function _load_admin_assets() {

		if (Google_Languages_Translator_Main::isLoadingAdminPage() || strpos(admin_url('widgets.php'), $_SERVER['REQUEST_URI']) !== false) {

			add_action('admin_enqueue_scripts', array('Google_Languages_Translator_Main', '_admin_js' ));

		}

	}
	
	protected static function _tabs() {

        $current = self::getTab();

		echo '<h2 class="nav-tab-wrapper">';
		
		$tabs = array(
			__('General', 'glt_text'),
			__('Advanced', 'glt_text'),
			__('Usage', 'glt_text')
		);
		
		foreach ($tabs as $tab) {
			$tab_low = strtolower($tab);
			echo '<a class="nav-tab' . ($tab_low == $current ? ' nav-tab-active' : '') . '" href="?page=translate-wordpress-google-languages-translator&tab=' . $tab_low . '">' . $tab . '</a>';
		}

		echo '</h2>';

	}
	
	public static function getTab() {

		$current = isset($_GET['tab']) ? $_GET['tab'] : false;
		$valid = array('general', 'advanced', 'usage');

		if ($current === false || !in_array($current, $valid))
			$current = isset($_POST['glt-tab']) ? $_POST['glt-tab'] : 'general';
	
		if (!in_array($current, $valid))
			$current = 'general';
		
		return $current;
		
	}

	public static function _initialize_menu() {
	
		add_options_page('Google Languages Translator', 'Google Languages Translator', 'manage_options', 'translate-wordpress-google-languages-translator', array('Google_Languages_Translator_Admin_Form', '_render'));

	}

	public static function _initialize_settings() {

		$settings = array(
			'general' => array(
				'glt-site-language' => '_site_language',
				'glt-multi-language' => '_multi_language',
				'glt-languages' => '_languages',
				'glt-languages-list' => '_languages_list',
				'glt-display-mode' => '_display_mode',
				'glt-inline-display-mode' => '_inline_display_mode',
				'glt-tabbed-display-mode' => '_tabbed_display_mode',
				'glt-flags' => '_flags',
				'glt-flags-list' => '_flags_list',
				'glt-flags-order' => '_flags_order',
				'glt-toolbar' => '_toolbar',
				'glt-align' => '_align'
			),
			'advanced' => array(
				'glt-active' => '_active',
				'glt-analytics' => '_analytics',
				'glt-analytics-id' => '_analytics_id',
				'glt-css' => '_css'
			)
		);

		$tab = self::getTab();

		if (!array_key_exists($tab, $settings))
			return;
		
		$settings = $settings[$tab];

		add_settings_section('glt_settings_' . $tab, __('Settings', 'glt_text'), '', 'glt_translator_' . $tab);

		foreach ($settings as $setting => $callback) {
			add_settings_field($setting, '', array('Google_Languages_Translator_Admin_Form', $callback), 'glt_translator_' . $tab, 'glt_settings_' . $tab);
			register_setting('glt_translator_' . $tab, $setting);
		}

	}

	public static function _render() {

		$current = self::getTab();

?>
		<div id="glt_form_wrapper">
			<h1>Translate WordPress with Google Languages Translator</h1>
			<?php self::_tabs(); ?>
			<form action="<?php echo admin_url('/options.php'); ?>" method="post">
			
				<?php $tab = self::getTab(); settings_fields('glt_translator_' . $tab); ?>
				<input type="hidden" name="glt-tab" id="glt-tab" value="<?php echo $current; ?>" />
				
			
				<div class="postbox glt-tab-content">
				<div class="inside">
				
					<table border="0" cellspacing="0" cellpadding="0" class="form-table">
				<?php switch($current) {
					case 'general': ?>

					<tr>
						<th><?php echo __('Original language of this website', 'glt_text'); ?></th>
						<td><?php self::_site_language(); ?></td>
					</tr>
					
					<tr>
						<th><?php echo __('Is this website written in more than one language?', 'glt_text'); ?></th>
						<td><?php self::_multi_language(); ?></td>
					</tr>

					<tr>
						<th><?php echo __('Languages to display', 'glt_text'); ?></th>
						<td><?php self::_languages(); ?></td>
					</tr>

					<tr id="languages_list_wrapper">
						<td colspan="2"><?php self::_languages_list(); ?></td>
					</tr>

					<tr>
						<th><?php echo __('Display mode:', 'glt_text'); ?></th>
						<td>
							<?php self::_display_mode(); ?>
							<span id="inline_display_mode_wrapper"><?php self::_inline_display_mode(); ?></span>
							<span id="tabbed_display_mode_wrapper"><?php self::_tabbed_display_mode(); ?></span>
							<span id="automatic_display_mode_wrapper"><br><?php echo __('The translation banner will automatically be displayed when the default browser language of the visitor is different from the language of your page. No dropdown will be displayed.', 'glt_text'); ?></span>
						</td>
					</tr>

					<tr id="flags_wrapper">
						<th><?php echo __('Display flags?', 'glt_text'); ?></th>
						<td><?php self::_flags(); ?></td>
					</tr>

					<tr id="choose_flags_wrapper">
						<th colspan="2"><?php echo __('Flags to display:', 'glt_text'); ?></th>
					</tr>

					<tr id="flags_list_wrapper"<?php self::_show('flags', '1'); ?>>
						<td colspan="2"><?php self::_flags_list(); ?></td>
					</tr>

					<tr id="flags_order_title_wrapper">
						<th colspan="2"><?php echo __('Flags order:', 'glt_text'); ?></th>
					</tr>

					<tr id="flags_order_wrapper">
						<td colspan="2"><?php self::_flags_order(); ?></td>
					</tr>

					<tr id="toolbar_wrapper">
						<th><?php echo __('Display Google Toolbar? (recommended)', 'glt_text'); ?>&nbsp;<a href="https://developers.google.com/translate/v2/attribution" target="_blank"><?php echo __('Learn more', 'glt_text'); ?></a></th>
						<td><?php self::_toolbar(); ?></td>
					</tr>

					<tr id="align_wrapper">
						<th><?php echo __('Align translator?', 'glt_text'); ?></th>
						<td><?php self::_align(); ?></td>
					</tr>

					<?php break; ?>
					<?php case 'advanced': ?>
					
					<tr>
						<th><?php echo __('Status:', 'glt_text'); ?></th>
						<td><?php self::_active(); ?></td>
					</tr>
					<tr>
						<th><?php echo __('Track translation traffic using Google Analytics:', 'glt_text'); ?></th>
						<td><?php self::_analytics(); ?></td>
					</tr>

					<tr id="analytics_id_wrapper">
						<th><?php echo __('Google Analytics ID: (UA-XXXXXXXX-X)', 'glt_text'); ?></th>
						<td><?php self::_analytics_id(); ?></td>
					</tr>

					<tr class="analytics">
						<th><?php echo __('Custom CSS code:', 'glt_text'); ?></th>
						<td><?php self::_css(); ?></td>
					</tr>

					<?php break; ?>
					<?php case 'usage':
						$name = 'glt-display-mode';
						$setting = self::_get_setting($name, 'inline');
						if ($setting == 'inline') {
					?>

					<tr>
						<td><h2><?php echo __('Widget usage:', 'glt_text'); ?></h2></td>
					</tr>
					<tr>
						<td><code>GLT Translator</code></td>
					</tr>
					
					<?php } ?>
					
					<tr>
						<td><h2><?php echo __('Shortcode usage:', 'glt_text'); ?></h2></td>
					</tr>
					<tr>
						<td><code>[glt-translator]</code></td>
					</tr>
					<tr>
						<td><h2><?php echo __('Widget usage in header/footer/page/template:', 'glt_text'); ?></h2></td>
					</tr>
					<tr>
						<td><code>&lt;?php echo do_shortcode('[glt-translator]'); ?&gt;</code></td>
					</tr>

					<?php break; } if ($current != 'usage') { ?>

					<tr>
						<td colspan="2">
						<?php submit_button(); ?>
						</td>
					</tr>
					
					<?php } ?>
					
				 </table>

				</div>
				</div>



	</form>

	</div>
	<div id="glt_guide_wrapper" class="metabox-holder notranslate" style="float: right; width: 33%;">
		<div class="postbox">
			<div class="inside">
				<table border="0" cellspacing="0" cellpadding="0" class="form-table">
					<tr>
						<th id="glt_guide_img_wrapper"><a href="http://wordpress.translate.guide/"><img src="<?php echo plugins_url(dirname(plugin_basename(__FILE__)) . '/assets/guide.jpg'); ?>"></a></th>
					</tr>
					<tr>
						<td>
							Take a brief read of this plugins guide, and find the best translation plugins with premium features:
							
							<ul>
								<li>
									Full SEO support:
									<ul>
										<li>Query string (?lang=en)</li>
										<li>Pre path (/en/ in front of URL)</li>
										<li>Subdomain (en.yoursite.com)</li>
										<li>Translate permalinks. Sitemap.</li>
										<li><em>lang</em> and <em>hreflang</em> tags.</li>
									</ul>
								</li>
								<li>Place the translator anywhere (without file edits)</li>
								<li>Different sizes and layouts</li>
								<li>Manually adjust translations</li>
								<li>Responsive and color adjustments</li>
								<li>Personalized customer support</li>
								<li>And much more!</li>
							</ul>
							
							<a href="http://wordpress.translate.guide/">Read it now: http://wordpress.translate.guide/</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<?php
	}

	protected static function _get_setting($_name, $_default, $_update=true) {

		if (get_option($_name) === false && $_update)
			update_option($_name, $_default);

		return get_option($_name);
		
	}
	
	protected static function _show($_parent, $_state) {
		
		$name = 'glt-' . $_parent;
		$setting = self::_get_setting($name, '', false);
		
		echo $setting != $_state ? ' style="display: none;"' : 'tete';
		
	}
	
	protected static function _active() {

		$name = 'glt-active';
		$setting = self::_get_setting($name, '1');

		echo '<input type="radio" name="' . $name . '" id="' . $name . '-yes" value="1"' . ($setting == '1' ? ' checked="checked"' : '') . '/><label for="' . $name . '-yes">' . __('Enabled', 'glt_text') . '</label><br>';
		echo '<input type="radio" name="' . $name . '" id="' . $name . '-no" value="0"' . ($setting == '0' ? ' checked="checked"' : '') . '/><label for="' . $name . '-no">' . __('Disabled', 'glt_text') . '</label>';
	
	}

	protected static function _site_language() {

		$name = 'glt-site-language';
		$setting = self::_get_setting($name, 'en');
		
		echo '<select name="' . $name . '" id="' . $name . '">';

		$languages = Google_Languages_Translator_Main::getLanguages();

		foreach ($languages as $key => $value)		
			echo '<option value="'. $key . '"' . ($setting == $key ? ' selected="selected"' : '') . '>' . $value . '</option>';
		
		echo '</select>';

	}

	protected static function _multi_language() {

		$name = 'glt-multi-language';
		$setting = self::_get_setting($name, '0');

		echo '<input type="radio" name="' . $name . '" id="' . $name . '-yes" value="1"' . ($setting == '1' ? ' checked="checked"' : '') . '/><label for="' . $name . '-yes">' . __('Yes, the content is multi lingual', 'glt_text') . '</label><br>';
		echo '<input type="radio" name="' . $name . '" id="' . $name . '-no" value="0"' . ($setting == '0' ? ' checked="checked"' : '') . '/><label for="' . $name . '-no">' . __('No, the content is written in one language only', 'glt_text') . '</label>';

	}

	protected static function _languages() {

		$name = 'glt-languages';
		$setting = self::_get_setting($name, 'all');
		
		echo '<input type="radio" name="' . $name . '" id="' . $name . '-all" value="all"' . ($setting == 'all' ? ' checked="checked"' : '') . ' /><label for="' . $name . '-all">' . __('All Languages', 'glt_text') . '</label><br>';
		echo '<input type="radio" name="' . $name . '" id="' . $name . '-specific" value="specific"' . ($setting == 'specific' ? ' checked="checked"' : '') . ' /><label for="' . $name . '-specific">' . __('Specific Languages', 'glt_text') . '</label>';
	
	}

	protected static function _languages_list() {

		$name = 'glt-languages-list';
		$site_language = get_option('glt-site-language');
		$setting = self::_get_setting($name, $site_language);

		$languages = Google_Languages_Translator_Main::getLanguages();
		$i = 1;

		echo '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $setting . '" />';

		$setting = explode(',', $setting);
		$name .= '-aux';

		foreach ($languages as $code => $name_language) {
			
			if ($i % 4)
				echo '<div class="languages" style="width:25%; float:left">';

			echo '<div><input type="checkbox" name="' . $name . '" id="' . $name . '-' . $code  . '" value="' . $code . '"' . (in_array($code, $setting) ? ' checked="checked"' : '') . ' /><label for="' . $name . '-' . $code . '">' . $name_language . '</label></div>';

			if ($i % 4)
				echo '</div>';	

			$i++;
			
		}

		echo '<div class="clear"></div>';

	}

	protected static function _flags() {

		$name = 'glt-flags';
		$setting = self::_get_setting($name, '1');

		echo '<input type="radio" name="' . $name . '" id="' . $name . '-show" value="1"' . ($setting == '1' ? ' checked="checked"' : '') . '/><label for="' . $name . '-show">' . __('Yes, display flags', 'glt_text') . '</label><br>';
		echo '<input type="radio" name="' . $name . '" id="' . $name . '-hide" value="0"' . ($setting == '0' ? ' checked="checked"' : '') . '/><label for="' . $name . '-hide">' . __('No, hide flags', 'glt_text') . '</label>';

	}

	protected static function _flags_list() {

		$name = 'glt-flags-list';
		$site_language = get_option('glt-site-language');
		$setting = self::_get_setting($name, $site_language);

		$languages = Google_Languages_Translator_Main::getLanguages();
		$i = 1;

		echo '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $setting . '" />';

		$setting = explode(',', $setting);
		$name .= '-aux';

		foreach ($languages as $code => $name_language) {
			
			if ($i % 4)
				echo '<div class="languages" style="width:25%; float:left">';

			echo '<div><input type="checkbox" name="' . $name . '" id="' . $name . '-' . $code  . '" value="' . $code . '"' . (in_array($code, $setting) ? ' checked="checked"' : '') . ' /><label for="' . $name . '-' . $code . '">' . $name_language . '</label></div>';

			if ($i % 4)
				echo '</div>';	

			$i++;
			
		}

		echo '<div class="clear"></div>';

	}

	protected static function _display_mode() {

		$name = 'glt-display-mode';
		$setting = self::_get_setting($name, 'inline');

		echo '<select name="' . $name . '" id="' . $name . '">';
		echo '<option value="inline"' . ($setting == 'inline' ? ' selected="selected"' : '') . '>' . __('Inline', 'glt_text') . '</option>';
		echo '<option value="tabbed"' . ($setting == 'tabbed' ? ' selected="selected"' : '') . '>' . __('Tabbed', 'glt_text') . '</option>';
		echo '<option value="automatic"' . ($setting == 'automatic' ? ' selected="selected"' : '') . '>' . __('Automatic', 'glt_text') . '</option>';
		echo '</select>';

	}

	protected static function _inline_display_mode() {

		$name = 'glt-inline-display-mode';
		$setting = self::_get_setting($name, 'vertical');

		echo '<select name="' . $name . '" id="' . $name . '">';
		echo '<option value="vertical"' . ($setting == 'vertical' ? ' selected="selected"' : '') . '>' . __('Vertical', 'glt_text') . '</option>';
		echo '<option value="horizontal"' . ($setting == 'horizontal' ? ' selected="selected"' : '') . '>' . __('Horizontal', 'glt_text') . '</option>';
		echo '<option value="dropdown"' . ($setting == 'dropdown' ? ' selected="selected"' : '') . '>' . __('Dropdown only', 'glt_text') . '</option>';
		echo '</select>';

	}

	protected static function _tabbed_display_mode() {

		$name = 'glt-tabbed-display-mode';
		$setting = self::_get_setting($name, 'lower-right');

		echo '<select name="' . $name . '" id="' . $name . '">';
		echo '<option value="lower-right"' . ($setting == 'lower-right' ? ' selected="selected"' : '') . '>' . __('Lower right', 'glt_text') . '</option>';
		echo '<option value="lower-left"' . ($setting == 'lower-left' ? ' selected="selected"' : '') . '>' . __('Lower left', 'glt_text') . '</option>';
		echo '<option value="upper-right"' . ($setting == 'upper-right' ? ' selected="selected"' : '') . '>' . __('Upper right', 'glt_text') . '</option>';
		echo '<option value="upper-left"' . ($setting == 'upper-left' ? ' selected="selected"' : '') . '>' . __('Upper left', 'glt_text') . '</option>';
		echo '</select>';

	}

	protected static function _toolbar() {

		$name = 'glt-toolbar';
		$setting = self::_get_setting($name, '1');

		echo '<select name="' . $name . '" id="' . $name . '">';
		echo '<option value="1"' . ($setting == '1' ? ' selected="selected"' : '') . '>' . __('Yes, display the Google toolbar', 'glt_text') . '</option>';
		echo '<option value="0"' . ($setting == '0' ? ' selected="selected"' : '') . '>' . __('No, hide the Google toolbar', 'glt_text') . '</option>';
		echo '</select>';

	}

	protected static function _branding() {

		$name = 'glt-branding';
		$setting = self::_get_setting($name, '1');

		echo '<select name="' . $name . '" id="' . $name . '">';
		echo '<option value="1"' . ($setting == '1' ? ' selected="selected"' : '') . '>' . __('Yes, display the Google brand', 'glt_text') . '</option>';
		echo '<option value="0"' . ($setting == '0' ? ' selected="selected"' : '') . '>' . __('No, hide the Google brand', 'glt_text') . '</option>';
		echo '</select>';

	}

	protected static function _align() {

		$name = 'glt-align';
		$setting = self::_get_setting($name, 'left');

		echo '<input type="radio" name="' . $name . '" id="' . $name . '-left" value="left"' . ($setting == 'left' ? ' checked="checked"' : '') . '/><label for="' . $name . '-left">' . __('Align left', 'glt_text') . '</label><br>';
		echo '<input type="radio" name="' . $name . '" id="' . $name . '-center" value="center"' . ($setting == 'center' ? ' checked="checked"' : '') . '/><label for="' . $name . '-center">' . __('Align center', 'glt_text') . '</label><br>';
		echo '<input type="radio" name="' . $name . '" id="' . $name . '-right" value="right"' . ($setting == 'right' ? ' checked="checked"' : '') . '/><label for="' . $name . '-right">' . __('Align right', 'glt_text') . '</label>';

	}

	protected static function _analytics() {

		$name = 'glt-analytics';
		$setting = self::_get_setting($name, '0');

		echo '<input type="radio" name="' . $name . '" id="' . $name . '-yes" value="1"' . ($setting == '1' ? ' checked="checked"' : '') . '/><label for="' . $name . '-yes">' . __('Yes', 'glt_text') . '</label><br>';
		echo '<input type="radio" name="' . $name . '" id="' . $name . '-no" value="0"' . ($setting == '0' ? ' checked="checked"' : '') . '/><label for="' . $name . '-no">' . __('No', 'glt_text') . '</label>';


	}

	protected static function _analytics_id() {

		$name = 'glt-analytics-id';
		$setting = self::_get_setting($name, '');

		echo '<input type="text" name="' . $name . '" id="' . $name . '" value="' . $setting . '" />';

	}

	protected static function _css() {

		$name = 'glt-css';
		$setting = self::_get_setting($name, '');

		echo '<textarea name="' . $name . '" id="' . $name . '">' . $setting  . '</textarea>';

	}

	protected static function _flags_order() {

		$name = 'glt-flags-order';
		$selected_flags = self::_get_setting('glt-flags-list', '');
		
		$setting = self::_get_setting($name, $selected_flags);
		$setting = explode(',', $setting);

		$selected_flags = explode(',', $selected_flags);

		$result = array();

		echo '<ul id="flags_order">';

		foreach ($setting as $language) {
			
			if (!in_array($language, $selected_flags))
				continue;
			
			echo '<li class="glt-flag glt-flag-' . strtolower($language)  . '"></li>';
			
			$result[] = $language;
			
		}

		echo '</ul>';
		
		echo '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . implode(',', $result) . '" />';
		echo '<input type="hidden" name="' . $name . '-aux" id="' . $name . '-aux" value="" />';

	}

}

class Google_Languages_Translator_Widget extends WP_Widget {
	
	function __construct() {
		
		parent::__construct(
			'Google_Languages_Translator_Widget', __('GLT Translator ', 'glt_text'), array(
				'description' => __('Add the Google Language Translator website tool.', 'glt_text')
			) 
		);
		
	}

	protected static function _get_setting($_name) {

		$result = get_option('glt-' . $_name);

		return empty($result) ? '' : $result;
		
	}

	public function widget($_args, $_instance) {
		
		$active = self::_get_setting('active');
		
		if ($active != '1')
			return;
		
		$title = apply_filters('widget_title', $_instance['title']);
		echo $_args['before_widget'];
		
		if (!empty($title))
			echo $_args['before_title'] . $title . $_args['after_title'];
	
		echo do_shortcode('[glt-translator]');
		echo $_args['after_widget'];
		
	}

	public function form($_instance) {
		
		$title = isset($_instance['title']) ? $_instance['title'] : '';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title:', 'glt_text');  ?></label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"></p>
<?php 
	}

	public function update($_new, $_old) {

		$instance = array();
		$instance['title'] = !empty($_new['title']) ? strip_tags($_new['title']) : '';
		
		return $instance;

	}

}

class Google_Languages_Translator_Translator {

	public static function initialize() {

		if (is_admin())
			return;

		add_shortcode('glt-translator', array('Google_Languages_Translator_Translator', 'generate'));

		$active = self::_get_setting('active');

		if ($active != '1')
			return;

		add_action('wp_head', array('Google_Languages_Translator_Translator', 'head'));

	}

	public static function head() {
	
		wp_enqueue_style('glt-translator-style', plugins_url('assets/style.css', __FILE__), array(), Google_Languages_Translator_Main::getVersion());
		
	}
	
	protected static function _get_setting($_name) {

		$result = get_option('glt-' . $_name);

		return empty($result) ? '' : $result;
		
	}


	protected static function _get_settings($_check_container=false) {

		$display_mode = self::_get_setting('display-mode');
	
		if ($_check_container)
			return $display_mode == 'inline';
	
		$result = array(
			'pageLanguage' => self::_get_setting('site-language')
		);

		if (self::_get_setting('multi-language') == '1')
			$result['multilanguagePage'] = true;

		$inline_display_mode = self::_get_setting('inline-display-mode');
		$tabbed_display_mode = self::_get_setting('tabbed-display-mode');

		if (self::_get_setting('languages') == 'specific' && $display_mode == 'inline')
			$result['includedLanguages'] = self::_get_setting('languages-list');
		
		if ($display_mode == 'inline') {
			if ($inline_display_mode == 'horizontal')
				$result['layout'] = 1;
			else if ($inline_display_mode == 'dropdown')
				$result['layout'] = 2;
		}
		else if ($display_mode == 'tabbed') {
			if ($tabbed_display_mode == 'lower-right')
				$result['floatPosition'] = 3;
			else if ($tabbed_display_mode == 'lower-left')
				$result['floatPosition'] = 4;
			else if ($tabbed_display_mode == 'upper-right')
				$result['floatPosition'] = 2;
			else if ($tabbed_display_mode == 'upper-left')
				$result['floatPosition'] = 1;
		}
		else
			$result['floatPosition'] = 1;

		$ga_id = self::_get_setting('analytics-id');
		if (self::_get_setting('analytics') == '1' && !empty($ga_id)) {
			$result['gaTrack'] = true;
			$result['gaId'] = $ga_id;
		}
				
		return json_encode($result);
		
	}

	protected static function _align() {
		
		$align = self::_get_setting('align');
		
		if (!in_array($align, array('left', 'center', 'right')))
			$align = 'left';
		
		return ' class="glt-align-' . $align . '"';
		
	}
	
	protected static function _flags() {
		
		$flags = self::_get_setting('flags');
		
		if ($flags != '1')
			return;
		
		if (self::_get_setting('languages') != 'all')
			return;
		
		$flags_order = self::_get_setting('flags-order');
		$flags_order = explode(',', $flags_order);
		
		if (empty($flags_order))
			return;
		
		$display_mode = self::_get_setting('display-mode');
		$inline_display_mode = self::_get_setting('inline-display-mode');
		
		if ($display_mode != 'inline')
			return;
		
		if (!in_array($inline_display_mode, array('vertical', 'horizontal')))
			return;

		$align = self::_align();

		echo '
<script type="text/javascript">
function Pglt_Translate(_language) {

	var element = jQuery(".goog-te-combo").get(0);
	
	if (!element)
		return;
	
	element.value = _language;
	
	try {
		if (document.createEvent) {
			var ev = document.createEvent("HTMLEvents");
			ev.initEvent("change", true, true);
			element.dispatchEvent(ev);
			element.dispatchEvent(ev);
		} 
		else {
			var ev = document.createEventObject();
			element.fireEvent("onchange", ev);
			element.fireEvent("onchange", ev);
		}
	} 
	catch (e) {}
	
}
</script>
';

		echo '<ul id="glt-flags"' . $align . '>';
		
		foreach ($flags_order as $language)
			echo '<li class="glt-flag-' . strtolower($language) . '" onclick="Pglt_Translate(\'' . $language .  '\')"></li>';
		
		echo '</ul>';
		
	}
	
	protected static function _toolbar_css() {

		$result = self::_get_setting('toolbar');
		
		if ($result == '1')
			return;
			
		echo '<style type="text/css">.goog-te-banner-frame { display: none !important; visibility: hidden !important; } body { top: 0 !important; }</style>';
		
	}
	
	protected static function _custom_css() {

		$result = self::_get_setting('css');
		
		if (empty($result))
			return;
			
		echo '<style type="text/css">' . $result . '</style>';
		
	}
	
	public static function generate() {

		$active = self::_get_setting('active');

		if ($active != '1')
			return;

		$settings = self::_get_settings();
		$has_container = self::_get_settings(true);

		self::_custom_css();
		self::_toolbar_css();

		if ($has_container) {
			self::_flags();
			$align = self::_align();
			echo '<div id="glt-translator"' . $align . '></div>';
		}

		echo '
<script type="text/javascript">
function gltTranslatortInit() {
	new google.translate.TranslateElement(' . $settings . ', "glt-translator");
}
</script>
';
		echo '<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=gltTranslatortInit"></script>';

	}

}

Google_Languages_Translator_Translator::initialize();
Google_Languages_Translator_Main::initialize();