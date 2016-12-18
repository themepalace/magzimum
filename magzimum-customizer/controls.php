<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
  return NULL;


/**
 * Customize Control for Heading
 */
class Magzimum_Customize_Heading_Control extends WP_Customize_Control {

  public $type = 'heading';

  public function render_content() {

    ?>
      <h3 class="magzimum-customizer-heading"><?php echo esc_html( $this->label ); ?></h3><!-- .magzimum-customizer-heading -->
    <?php
  }

}


/**
 * Customize Control for Message
 */
class Magzimum_Customize_Message_Control extends WP_Customize_Control {

  public $type = 'message';

  public function render_content() {

    ?>
      <div class="magzimum-customizer-message">
        <?php echo wp_kses_post( $this->description ); ?>
      </div> <!-- .magzimum-customizer-message -->
    <?php
  }

}

/**
 * Customize Control for Menu Select
 */
class Magzimum_Customize_Dropdown_Menus_Control extends WP_Customize_Control {

  public $type = 'dropdown-menus';

  public function render_content() {

    $all_menus = wp_get_nav_menus();

    ?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
         <select <?php echo esc_url( $this->link() ); ?>>
            <?php
              printf('<option value="%s" %s>%s</option>', '', selected($this->value(), '', false),__( 'Select Menu', 'magzimum' ) );
             ?>
            <?php if ( ! empty( $all_menus ) ): ?>
              <?php foreach ( $all_menus as $key => $menu ): ?>
                <?php
                  printf('<option value="%s" %s>%s</option>', $menu->term_id, selected($this->value(), $menu->term_id, false), $menu->name );
                 ?>
              <?php endforeach ?>
           <?php endif ?>
         </select>

    </label>
    <?php
  }

}


/**
 * Customize Control for Sidebar Select
 */
class Magzimum_Customize_Dropdown_Sidebars_Control extends WP_Customize_Control {

  public $type = 'dropdown-sidebars';

  public function render_content() {

    global $wp_registered_sidebars;

    $all_sidebars = $wp_registered_sidebars;

    ?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
         <select <?php echo esc_url( $this->link() ); ?>>
            <?php
              printf('<option value="%s" %s>%s</option>', '', selected($this->value(), '', false),__( 'Select Sidebar', 'magzimum' ) );
             ?>
            <?php if ( ! empty( $all_sidebars ) ): ?>
              <?php foreach ( $all_sidebars as $key => $sidebar ): ?>
                <?php
                  printf('<option value="%s" %s>%s</option>', $key, selected($this->value(), $key, false), $sidebar['name'] );
                 ?>
              <?php endforeach ?>
           <?php endif ?>
         </select>

    </label>
    <?php
  }

}

/**
 * Customize Control for Radio Image
 */
class Magzimum_Customize_Radio_Image_Control extends WP_Customize_Control {

  public $type = 'radio-image';

  public function render_content() {

    if ( empty( $this->choices ) )
      return;

    $name = '_customize-radio-' . $this->id;

    ?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

      <?php
      foreach ( $this->choices as $value => $label ) :
        ?>
        <label>
          <input type="radio" value="<?php echo esc_attr( $value ); ?>" <?php esc_url( $this->link() ); checked( $this->value(), $value ); ?> class="stylish-radio-image" name="<?php echo esc_attr( $name ); ?>"/>
            <span><img src="<?php echo esc_url($label); ?>" alt="<?php echo esc_attr( $value ); ?>" /></span>
        </label>
        <?php
      endforeach;
       ?>

    </label>
    <?php
  }

}


/**
 * Customize Control for Taxonomy Select
 */
class Magzimum_Customize_Dropdown_Taxonomies_Control extends WP_Customize_Control {

  public $type = 'dropdown-taxonomies';

  public $taxonomy = '';


  public function __construct( $manager, $id, $args = array() ) {

    $our_taxonomy = 'category';
    if ( isset( $args['taxonomy'] ) ) {
      $taxonomy_exist = taxonomy_exists( esc_attr( $args['taxonomy'] ) );
      if ( true === $taxonomy_exist ) {
        $our_taxonomy = esc_attr( $args['taxonomy'] );
      }
    }
    $args['taxonomy'] = $our_taxonomy;
    $this->taxonomy = esc_attr( $our_taxonomy );

    parent::__construct( $manager, $id, $args );
  }

  public function render_content() {

    $tax_args = array(
      'hierarchical' => 0,
      'taxonomy'     => $this->taxonomy,
    );
    $all_taxonomies = get_categories( $tax_args );

    ?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
         <select <?php echo esc_url( $this->link() ); ?>>
            <?php
              printf('<option value="%s" %s>%s</option>', '', selected($this->value(), '', false),__( 'Select', 'magzimum' ) );
             ?>
            <?php if ( ! empty( $all_taxonomies ) ): ?>
              <?php foreach ( $all_taxonomies as $key => $tax ): ?>
                <?php
                  printf('<option value="%s" %s>%s</option>', $tax->term_id, selected($this->value(), $tax->term_id, false), $tax->name );
                 ?>
              <?php endforeach ?>
           <?php endif ?>
         </select>

    </label>
    <?php
  }

}
