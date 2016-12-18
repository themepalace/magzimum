<?php
if ( ! class_exists( 'Magzimum_Customizer' ) ):

  class Magzimum_Customizer{

    var $base_args;
    var $defaults;
    var $version;

    function __construct( $args, $defs ){

      $this->base_args = $args;
      $this->defaults  = $this->populate_defaults( $defs );
      $this->version   = '1.0.0';

      add_action( 'customize_controls_enqueue_scripts', array($this,'load_assets') );
      add_action( 'customize_register', array($this,'register_customizer') );

    }

    function load_assets(){
      global $pagenow;
     
      wp_enqueue_style( 'magzimum-customizer-style', get_template_directory_uri() . '/magzimum-customizer/assets/css/magzimum-customizer.css', false, $this->version );
    }

    private function populate_defaults( $defs ){

      $output = array();

      if ( ! empty( $defs ) && is_array( $defs ) ) {
        foreach ($defs as $key => $d) {
          $output[ $key ] = $d;
        }
      }

      return $output;

    }

    public function register_customizer( $wp_customize ){

      $built_in_controls = array(
        'checkbox',
        'dropdown-pages',
        'number',
        'radio',
        'range',
        'select',
        'text',
        'textarea',
      );

      $built_in_sections = array(
        'header_image',
        'background_image',
      );

      foreach ($this->base_args['panels'] as $panel_key => $panel) {

        if ( 'pre_defined' != $panel_key ) {
          // Add Panel
          $panel_args = array(
            'title'          => '',
            'priority'       => 100,
            'theme_supports' => '',
            'capability'     => 'edit_theme_options',
            'description'    => '',
          );
          if (isset($panel['title'])) {
            $panel_args['title'] = esc_attr( $panel['title'] );
          }
          if (isset($panel['priority'])) {
            $panel_args['priority'] = abs( $panel['priority'] );
          }
          if (isset($panel['theme_supports'])) {
            $panel_args['theme_supports'] = esc_attr( $panel['theme_supports'] );
          }
          if (isset($panel['capability'])) {
            $panel_args['capability'] = esc_attr( $panel['capability'] );
          }
          if (isset($panel['description'])) {
            $panel_args['description'] = esc_html( $panel['description'] );
          }

          $wp_customize->add_panel( esc_attr( $panel_key ), $panel_args );
        }

        if ( ! empty( $panel['sections'] ) ) {

          foreach ( $panel['sections'] as $section_key => $section ) {
            
            if ( !in_array( $section_key, $built_in_sections ) ) {
              // Add Section
              $section_args = array(
                'title'          => '',
                'priority'       => 100,
                'capability'     => 'edit_theme_options',
                'theme_supports' => '',
                'description'    => '',
                'panel'          => esc_attr( $panel_key ),
              );
              if (isset($section['title'])) {
                $section_args['title'] = esc_attr( $section['title'] );
              }
              if (isset($section['priority'])) {
                $section_args['priority'] = abs( $section['priority'] );
              }
              if (isset($section['theme_supports'])) {
                $section_args['theme_supports'] = esc_attr( $section['theme_supports'] );
              }
              if (isset($section['capability'])) {
                $section_args['capability'] = esc_attr( $section['capability'] );
              }
              if (isset($section['description'])) {
                $section_args['description'] = esc_attr( $section['description'] );
              }

              $wp_customize->add_section( esc_attr( $section_key ), $section_args );
            }

            if ( ! empty( $section['fields'] ) ) {

              foreach ($section['fields'] as $field_key => $field) {

                // Add Setting
                $setting_args = array(
                  'default'              => '',
                  'type'                 => 'theme_mod',
                  'capability'           => 'edit_theme_options',
                  'theme_supports'       => '',
                  'transport'            => 'refresh',
                  'sanitize_callback'    => 'esc_attr',
                  'sanitize_js_callback' => 'esc_attr',
                );
                $wp_customize->add_setting( esc_attr( 'theme_options['.$field_key.']' ), array(

                  'default'              => isset( $this->defaults[ $field_key] ) ? $this->defaults[ $field_key] : $setting_args['default'],
                  'type'                 => isset( $field['option_type'] ) ? esc_attr( $field['option_type'] ) : $setting_args['type'],
                  'capability'           => isset( $field['capability'] ) ? esc_attr( $field['capability'] ) : $setting_args['capability'],
                  'theme_supports'       => isset( $field['theme_supports'] ) ? esc_attr( $field['theme_supports'] ) : $setting_args['theme_supports'],
                  'transport'            => isset( $field['transport'] ) ? esc_attr( $field['transport'] ) : $setting_args['transport'],
                  'sanitize_callback'    => isset( $field['sanitize_callback'] ) ? esc_attr( $field['sanitize_callback'] ) : $setting_args['sanitize_callback'],
                  'sanitize_js_callback' => isset( $field['sanitize_js_callback'] ) ? esc_attr( $field['sanitize_js_callback'] ) : $setting_args['sanitize_js_callback'],
                  )
                );

                // Prepare control args
                $control_args = array(
                  'label'    => $field['title'],
                  'section'  => esc_attr( $section_key ),
                  'type'     => $field['type'],
                  'priority' => 100,
                );
                if ( isset( $field['priority'] ) ) {
                  $control_args['priority'] = abs( $field['priority'] );
                }
                if ( isset( $field['input_attrs'] ) ) {
                  $control_args['input_attrs'] = $field['input_attrs'];
                }
                if ( isset( $field['choices'] ) ) {
                  $control_args['choices'] = $field['choices'];
                }
                if ( isset( $field['taxonomy'] ) ) {
                  $control_args['taxonomy'] = $field['taxonomy'];
                }
                if ( isset( $field['description'] ) ) {
                  $control_args['description'] = $field['description'];
                }

                if ( in_array( $field['type'], $built_in_controls ) ) {

                  // Built in controls
                  $wp_customize->add_control( esc_attr( 'theme_options['.$field_key.']' ), $control_args );

                }
                else{

                  // WP class or our class
                  $class_name = 'WP_Customize_'.ucfirst($field['type']).'_Control';
                  $class_exists = false;
                  if ( class_exists( $class_name ) ) {
                    $class_exists = true;
                  }
                  if ( ! $class_exists) {
                    $class_temp_name = $field['type'];
                    $exploded_class = explode('-', $field['type']);
                    $new_array = array_map('ucfirst', $exploded_class);
                    $new_class_name = implode('_', $new_array);
                    $class_name = 'Magzimum_Customize_'.$new_class_name.'_Control';
                    if (class_exists($class_name)) {
                      $class_exists = true;
                    }
                  }

                  if ( true === $class_exists ) {
                    // Control class exists
                    $obj = new $class_name(
                      $wp_customize,
                      esc_attr( 'theme_options['.$field_key.']' ),
                      $control_args
                    );
                    $wp_customize->add_control($obj);

                  }
                  else{
                    echo $class_name . ' not found';
                  }

                }

              }

            }

          } // end for loop $panel['sections']

        } //end if not empty sections

      } // end for loop base_args['panels']

    } //end function


  } //end class

endif;
