<?php
/**
 * firmasite Theme Customizer
 *
 * @package firmasite
 */

			
add_action( 'customize_controls_print_footer_scripts', "firmasite_customizer_desc_script",99);
function firmasite_customizer_desc_script() { 
	global $firmasite_settings_desc;
/* USAGE:
				// Adding explanation for setting
				$firmasite_settings_desc["font"]['content'] = esc_attr__( 'You can choose a different font for your site.', "firmasite" ); 
				$firmasite_settings_desc["font"]['title'] = ""; 
				$firmasite_settings_desc["font"]['locate'] = "li#customize-control-firmasite_settings-logo div.customize-image-picker"; 
				$firmasite_settings_desc["font"]['important'] = true; //this one makes icons in different color to clarify its important
 */	?>
	<script>
	jQuery(document).ready(function() {
		<?php foreach ($firmasite_settings_desc as $id => $data) { ?>
		jQuery('<?php if (isset($data['locate'])){ echo $data['locate']; } else { ?>li#customize-control-firmasite_settings-<?php echo $id; ?> label<?php } ?>').prepend('<a href="#" class="pull-right" data-rel="popover" data-trigger="hover" data-placement="left" data-html="true" data-content="<?php 
		if (isset($data["content"])) echo $data["content"]; ?>" data-original-title="<?php if (isset($data["title"])) echo $data["title"]; ?>"><span class="btn btn-<?php echo ($data["important"]) ? "danger" : "info"; ?> btn-xs"><?php echo ($data["important"]) ? "!?" : "?"; ?></span></a>');
		<?php } ?>
		jQuery('[data-rel=popover]').popover();
	});
	</script>
<?php }

/*add_action ('admin_menu', 'firmasite_customizer_admin_menulink');
function firmasite_customizer_admin_menulink() {
    // add the Customize link to the admin menu
    add_theme_page( __( 'Customize', "firmasite" ), __( 'Customize', "firmasite" ), 'edit_theme_options', 'customize.php' );
}*/


// Register js for customizer panel
add_action( 'customize_preview_init', "firmasite_customizer_preview_init");
function firmasite_customizer_preview_init() {
	include ( get_template_directory() . '/functions/customizer-call.php');			// Customizer functions
	wp_enqueue_script( 'firmasite_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ) );
	
	wp_localize_script( 'firmasite_customizer', 'firmasite_settings_array', $firmasite_settings );

	
} 


// Register css for customizer panel
add_action( 'customize_controls_print_styles', "firmasite_customizer_print_styles" );
function firmasite_customizer_print_styles() {
	
	global $firmasite_settings;
	
	// bootstrap go go
	wp_enqueue_style( 'customizer-bootstrap', $firmasite_settings["styles_url"][$firmasite_settings["style"]] . '/bootstrap.min.css' );

	// google font option
	wp_enqueue_style( 'bootstrap-formhelpers', get_template_directory_uri() . '/assets/bootstrapformhelpers/css/bootstrap-formhelpers.css' );
	
	// Customizer style
	wp_enqueue_style( 'firmasite_customizer', get_template_directory_uri() . '/assets/css/customizer.css' );

	// bootstrap js go go
	wp_enqueue_script( 'customizer-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ) );
	
	// google font option
	wp_enqueue_script( 'formhelpers-selectbox', get_template_directory_uri() . '/assets/bootstrapformhelpers/js/bootstrap-formhelpers-selectbox.js', array( 'jquery' ) );
	wp_enqueue_script( 'formhelpers-googlefonts-codes', get_template_directory_uri() . '/assets/bootstrapformhelpers/js/bootstrap-formhelpers-googlefonts.codes.js', array( 'jquery' ) );
	wp_enqueue_script( 'formhelpers-googlefonts', get_template_directory_uri() . '/assets/bootstrapformhelpers/js/bootstrap-formhelpers-googlefonts.js', array( 'jquery' ) );

	// customizer-panel go go
	wp_enqueue_script( 'customizer-panel', get_template_directory_uri() . '/assets/js/customizer-panel.js', array( 'jquery' ) );
	wp_localize_script( 'customizer-panel', 'styles_url', $firmasite_settings["styles_url"] );

} 


add_action( 'after_setup_theme', "firmasite_customizer_setup" );
function firmasite_customizer_setup(){
	
	add_action( 'customize_register', "firmasite_customizer_register");
	function firmasite_customizer_register($wp_customize) {
			global $firmasite_settings, $firmasite_settings_desc;
		
/*
 * Site Title & Tagline
 */		
			// Logo
			$wp_customize->add_setting( 'firmasite_settings[logo]', array(
				'type' => 'option',
			) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'firmasite_settings[logo]', array(
				'label'   => esc_attr__( 'Logo', "firmasite" ),
				'section' => 'title_tagline',
				'settings'   => 'firmasite_settings[logo]',
			) ) );	
				// Adding explanation for setting
				$firmasite_settings_desc["logo"]['content'] = esc_attr__( 'You can upload logo for your site.', "firmasite" ); 
				$firmasite_settings_desc["logo"]['locate'] = "li#customize-control-firmasite_settings-logo div.customize-image-picker"; 


/*
 * Color
 */		
			$wp_customize->add_setting( 'firmasite_settings[explain]', array(
				'type'              => 'option',
			) );
			$wp_customize->add_control( new Firmasite_Customize_Explain_Control( $wp_customize, 'firmasite_settings[explain]', array(
				'label'    => __( 'Please decide your preferred <strong>Theme Style</strong> under <strong>Theme Options</strong> first. Then you can change small color options here.', "firmasite" ),
				'type' => 'explain',
				'section'  => 'colors',
				'priority' => '1',
			) ) );
	
			// Logo-Text color
			$wp_customize->add_setting( 'firmasite_settings[color-logo-text]', array(
				'default' => 'info',
				'type' => 'option',
			) );
			$wp_customize->add_control( new Firmasite_Customize_Badge_Color_Control( $wp_customize, 'firmasite_settings[color-logo-text]', array(
				'label'   => esc_attr__( 'Site Title Color', "firmasite" ),
				'section' => 'colors',
				'priority' => '11',
				'settings'   => 'firmasite_settings[color-logo-text]',
				'choices' => array(
					'default' => '<span class="label label-default">&nbsp;</span>',
					'success' => '<span class="label label-success">&nbsp;</span>',
					'warning' => '<span class="label label-warning">&nbsp;</span>',
					'danger' => '<span class="label label-danger">&nbsp;</span>',
					'info' => '<span class="label label-info">&nbsp;</span>',
					'primary' => '<span class="label label-primary">&nbsp;</span>',
				),
			) ) );	
				// Adding explanation for setting
				$firmasite_settings_desc["color-logo-text"]['content'] = esc_attr__( 'If you are not using logo, you can change your site title\'s color from this option.', "firmasite" ); 
				$firmasite_settings_desc["color-logo-text"]['locate'] = "li#customize-control-firmasite_settings-color-logo-text"; 


			// Taxonomy color
			$wp_customize->add_setting( 'firmasite_settings[color-tax]', array(
				'default' => 'info',
				'type' => 'option',
			) );
			$wp_customize->add_control( new Firmasite_Customize_Badge_Color_Control( $wp_customize, 'firmasite_settings[color-tax]', array(
				'label'   => esc_attr__( 'Category / Tag Color', "firmasite" ),
				'section' => 'colors',
				'priority' => '13',
				'settings'   => 'firmasite_settings[color-tax]',
				'choices' => array(
					'default' => '<span class="label label-default">&nbsp;</span>',
					'success' => '<span class="label label-success">&nbsp;</span>',
					'warning' => '<span class="label label-warning">&nbsp;</span>',
					'danger' => '<span class="label label-danger">&nbsp;</span>',
					'info' => '<span class="label label-info">&nbsp;</span>',
					'primary' => '<span class="label label-primary">&nbsp;</span>',
				),
			) ) );	
				// Adding explanation for setting
				$firmasite_settings_desc["color-tax"]['content'] = esc_attr__( 'You can change your categories and taxonomies color from this option.', "firmasite" ); 
				$firmasite_settings_desc["color-tax"]['locate'] = "li#customize-control-firmasite_settings-color-tax"; 
			
/*
 * Theme Options
 */		
		// Theme Options
		$wp_customize->add_section( 'secenek', array(
				'title' => esc_attr__( 'Appearance', "firmasite" ), // The title of section
				'priority' => '10',
		) );

	
			 
			 // Google Fonts
			$wp_customize->add_setting( 'firmasite_settings[font]', array(
				//'default' => 'Open Sans',
				'type' => 'option',
				'transport'         => 'postMessage'
			) );			 
			$wp_customize->add_control( new Firmasite_Customize_GoogleFont_Control( $wp_customize, 'firmasite_settings[font]', array(
				'label' => esc_attr__( 'Font', "firmasite" ),
				'section' => 'secenek',
				'settings'   => 'firmasite_settings[font]',
				'priority' => '1',
			) ) );			
			$wp_customize->get_setting( 'firmasite_settings[font]' )->transport = 'postMessage';
				// Adding explanation for setting
				$firmasite_settings_desc["font"]['content'] = esc_attr__( 'You can change your site\'s font', "firmasite" ); 



			 // Layout
			$wp_customize->add_setting( 'firmasite_settings[layout]', array(
				'default' => 'content-sidebar',
				'type' => 'option',
			) );			 
			$wp_customize->add_control( 'firmasite_settings[layout]', array(
				'label' => __( 'Layout', "firmasite" ),
				'section' => 'secenek',
				'type' => 'radio',
				'choices' => array(
					'content-sidebar' => esc_attr__( 'Content - Sidebar', "firmasite" ),
					'sidebar-content' => esc_attr__( 'Sidebar - Content', "firmasite" ),
					'only-content' => esc_attr__( 'Only Content. No sidebar (Short)', "firmasite" ),
					'only-content-long' => esc_attr__( 'Only Content. No sidebar (Long)', "firmasite" ),
				),
			) );						
				// Adding explanation for setting
				$firmasite_settings_desc["layout"]['content'] = esc_attr__( 'You can change your site\'s layout.', "firmasite" ); 
				$firmasite_settings_desc["layout"]['locate'] = "li#customize-control-firmasite_settings-layout"; 



			 // Theme Style
			$wp_customize->add_setting( 'firmasite_settings[style]', array(
				'default' => 'united',
				'type' => 'option',
				'transport'         => 'postMessage'
			) );			 
			$wp_customize->add_control( new Firmasite_Customize_ImageOptions_Control( $wp_customize, 'firmasite_settings[style]', array(
				'label' => esc_attr__( 'Theme Style', "firmasite" ),
				'section' => 'secenek',
				'type' => 'imageoptions',
				'priority' => '20',
				// If you are going to customize this, dont forget firmasite_theme_styles_url filter
				'choices' => $firmasite_settings["styles"],
			) ) );						
			$wp_customize->get_setting( 'firmasite_settings[style]' )->transport = 'postMessage';
				// Adding explanation for setting
				$firmasite_settings_desc["style"]['content'] = esc_attr__( 'You can change your site\'s style.', "firmasite" ); 
				$firmasite_settings_desc["style"]['locate'] = "li#customize-control-firmasite_settings-style"; 

	
			


/*
 * Theme Settings
 */		
		// Theme Settings
		$wp_customize->add_section( 'theme-settings', array(
				'title' => esc_attr__( 'Theme Settings', "firmasite" ), // The title of section
				'priority' => '90',
		) );


			 // Loop Style
			$wp_customize->add_setting( 'firmasite_settings[loop-style]', array(
				'default' => 'loop-list',
				'type' => 'option',
			) );			 
			$wp_customize->add_control( 'firmasite_settings[loop-style]', array(
				'label' => esc_attr__( 'Loop Style', "firmasite" ),
				'section' => 'theme-settings',
				'priority' => '991',
				'type' => 'radio',
				'choices' => array(
					'loop-list' => esc_attr__( 'Vertical List', "firmasite" ),
					'loop-excerpt' => esc_attr__( 'Vertical List (Excerpt)', "firmasite" ),
					'loop-tile' => esc_attr__( 'Multi-Column List (Excerpt)', "firmasite" ),
				),
			) );						
				// Adding explanation for setting
				$firmasite_settings_desc["loop-style"]['content'] = "<b>".esc_attr__( "Vertical List", "firmasite" ).":</b> " .
						esc_attr__( "Content will list one by one", "firmasite" ) .
						"<br /><b>".esc_attr__( "Vertical List (Excerpt)", "firmasite" ).":</b> ".
						esc_attr__( "Content's excerpt will list one by one", "firmasite" ).
						"<br /><b>".esc_attr__( "Multi-Column List (Excerpt)", "firmasite" ).":</b> ".
						sprintf( esc_attr__("Content's excerpt will list vertically (%s in each row)", "firmasite" ),								
								number_format_i18n( $firmasite_settings["loop_tile_row"] )
							); ; 
				$firmasite_settings_desc["loop-style"]['locate'] = "li#customize-control-firmasite_settings-loop-style"; 
			
			

			// No responsive
			$wp_customize->add_setting( 'firmasite_settings[no-responsive]', array(
				'type'              => 'option',
			) );
			$wp_customize->add_control( 'firmasite_settings[no-responsive]', array(
				'label'    => esc_attr__( 'Make fixed. No responsive', "firmasite" ),
				'type' => 'checkbox',
				'section'  => 'theme-settings',
				'priority' => '992',
			) );	
				// Adding explanation for setting
				$firmasite_settings_desc["no-responsive"]['content'] = esc_attr__( 'Responsive feature have special display style for different devices (from desktop computer monitors to mobile phones). This will remove responsive feature so your site will have same display in all devices.', "firmasite" ); 


/*
 * Navigation Section
 */		
			// Alternative Menu System
			$wp_customize->add_setting( 'firmasite_settings[menu-style]', array(
				'default'           => 'default',
				'type'              => 'option',
			) );
			$wp_customize->add_control( 'firmasite_settings[menu-style]', array(
				'label'    => esc_attr__( 'Menu Style', "firmasite" ),
				'section'  => 'nav',
				'priority' => '50',
				'type' => 'radio',
				'choices' => array(
					'default' => esc_attr__( 'Default', "firmasite" ),
					'alternative' => esc_attr__( 'Alternative', "firmasite" ),
					'simple' => esc_attr__( 'Simple', "firmasite" ),
				),
			) );
				// Adding explanation for setting
				$firmasite_settings_desc["menu-style"]['content'] = esc_attr__( 'If you are using menus, you can change menu style with this option', "firmasite" ); 
				$firmasite_settings_desc["menu-style"]['locate'] = "li#customize-control-firmasite_settings-menu-style"; 


			// hover-nav menu
			$wp_customize->add_setting( 'firmasite_settings[hover-nav]', array(
				'type'              => 'option',
			) );
			$wp_customize->add_control( 'firmasite_settings[hover-nav]', array(
				'label'    => esc_attr__( 'Dont make menu automatically open when hover', "firmasite" ),
				'type' => 'checkbox',
				'priority' => '90',
				'section'  => 'nav',
			) );
				// Adding explanation for setting
				$firmasite_settings_desc["hover-nav"]['content'] = esc_attr__( 'You can disable dropdown menus automatically open when you hover.<br /> <span class="label label-warning"><i class="icon-exclamation-sign"></i> Be careful:</span> Parent menu item will only work for opening dropdown menu and won\'t work like a link', "firmasite" ); 


			$wp_customize->add_setting( 'firmasite_settings[nav-explain]', array(
				'type'              => 'option',
			) );
			$wp_customize->add_control( new Firmasite_Customize_Explain_Control( $wp_customize, 'firmasite_settings[nav-explain]', array(
				'label'    => esc_attr__( 'You can create or manage menus from Menus page under Appearance', "firmasite" ) . ':<a href="' . admin_url( 'nav-menus.php' ) . '" target="_blank"> ' . __( 'Menus', "firmasite" ) . '</a>',
				'type' => 'explain',
				'section'  => 'nav',
				'priority' => '1',
			) ) );			

	}
}


/*
add_filter( 'display_media_states', function($media_states) {
	$meta_logo = get_post_meta($post->ID, '_wp_attachment_is_logo', true );
	if ( ! empty( $meta_background ) && $meta_logo == $stylesheet )
		$media_states[] = __( 'Logo', "firmasite" );

	return $media_states;
},10,1);*/


if (class_exists("WP_Customize_Control")){
	class Firmasite_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
	 
		public function render_content() {
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	}
}


if (class_exists("WP_Customize_Control")){
	class Firmasite_Customize_Explain_Control extends WP_Customize_Control {
		public $type = 'explain';
	 
		public function render_content() {
			?>
				<p><span class="text-muted"><?php echo $this->label; ?></span></p>
			<?php
		}
	}
}


if (class_exists("WP_Customize_Control")){
	class Firmasite_Customize_ImageOptions_Control extends WP_Customize_Control {
		public $type = 'imageoptions';
	 
		public function render_content() {
			if ( empty( $this->choices ) )
				return;
				
			global $firmasite_settings;

			$name = '_customize-imageoptions-' . $this->id;

			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php
			foreach ( $this->choices as $value => $label ) :
				$selected = "";
				if ($this->value() == $value) $selected = "of-radio-img-selected"; 
				
				if(!isset($firmasite_settings["thumbnail_url"][esc_attr( $value )]))
					$firmasite_settings["thumbnail_url"][esc_attr( $value )] = $firmasite_settings["styles_url"][esc_attr( $value )];
				?>
				<label>
                        <input type="radio" id="<?php echo esc_attr( $value ); ?>" class="of-radio-img-radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
							<?php if ($this->value() == $value){ ?>
                            <div class="of-radio-img-label selected"><i class="icon-ok"></i> <?php echo esc_html( $label ); ?></div>                          
							<?php } else {?>
                            <div class="of-radio-img-label"><?php echo esc_html( $label ); ?></div>
                            <?php } ?>
							<img src="<?php echo $firmasite_settings["thumbnail_url"][esc_attr( $value )]; ?>/thumbnail.png" alt="<?php echo esc_attr( $name ); ?>" class="of-radio-img-img <?php echo $selected; ?>"  />
				</label>
				<?php
			endforeach;
		}
	}
}

if (class_exists("WP_Customize_Control")){
	class Firmasite_Customize_GoogleFont_Control extends WP_Customize_Control {
		public $type = 'googlefont';
	 
		public function render_content() {
			$data_subset = FIRMASITE_SUBSETS;
			$data_subsets = "";
			if (!empty($data_subset)) $data_subsets = 'data-subsets="'.$data_subset.'"';
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
          <div id="font" class="bfh-selectbox bfh-googlefonts" <?php  echo $data_subsets; ?> data-family="<?php echo esc_textarea( $this->value() ); ?>">
            <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
            <a class="bfh-selectbox-toggle" role="button" data-toggle="bfh-selectbox" href="#">
            <span class="bfh-selectbox-option" data-option=""></span>
            <b class="caret"></b>
            </a>
            <div class="bfh-selectbox-options">
              <input type="text" class="bfh-selectbox-filter">
              <ul role="option">
              </ul>
            </div>
          </div>


		  </label>

			<?php
		}
	}
}



if (class_exists("WP_Customize_Control")){
	class Firmasite_Customize_Badge_Color_Control extends WP_Customize_Control {
		public $type = 'labelpick';
	 
		public function render_content() {
			if ( empty( $this->choices ) )
				return;
				
			global $firmasite_settings;

			$name = '_customize-labelpick-' . $this->id;

			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php
			foreach ( $this->choices as $value => $label ) :
				$selected = "";
				if ($this->value() == $value) $selected = "selected"; 
				?>
				<label style="margin-left:5px">
                        <input type="radio" id="<?php echo esc_attr( $value ); ?>" class="" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
							<?php if ($this->value() == $value){ ?>
                            <div class="selected"><?php echo $label; ?></div>                     
							<?php } else {?>
                            <div class=""><?php echo $label; ?></div>
                            <?php } ?>
				</label>   
				<?php
			endforeach;
		}
	}
}