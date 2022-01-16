<?php

/**
 * Enqueue scripts and styles.
 */

function iap_scripts() {
    wp_enqueue_style( 'style', untrailingslashit( get_template_directory_uri() ) . '/style.css' );
    wp_enqueue_style( 'font-google', 'https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;600;700&display=swap', false ); 
}
add_action( 'wp_enqueue_scripts', 'iap_scripts' );


/**
 * Theme Setup
 */

if (!function_exists('iap_setup') ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function iap_setup() {
        /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
        add_theme_support( 'title-tag' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'width'       => 191,
				'height'      => 67,
				'flex-width'  => false,
				'flex-height' => false,
			)
		);

        // Menu locations
		register_nav_menus(
			array(
				'menu' => __( 'Header', 'iap' ),
			)
		);

        // Add support for featured image
        add_theme_support('post-thumbnails');

        // Set featured image size
        set_post_thumbnail_size(343, 235, true);
    }
endif;

add_action( 'after_setup_theme', 'iap_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function iap_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'iap' ),
			'id'            => 'sidebar',
			'description'   => __( 'Add widgets here to appear in your footer.', 'iap' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

add_action( 'widgets_init', 'iap_widgets_init' );

/**
 * Filter the except length to 20 words.
 *
 * @link https://developer.wordpress.org/reference/functions/the_excerpt/
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */

function iap_excerpt_length( $length ) {
    return 15;
}

add_filter('excerpt_length', 'iap_excerpt_length', 999);


/**
 * Gutenberg Blocks
 */

use Carbon_Fields\Block;
use Carbon_Fields\Field;

function iap_attach_gutenberg_blocks() {
    
    Block::make('My Hero')
        -> add_fields([
            Field::make('text', 'iap_hero_title', __( 'Title' )),
            Field::make('rich_text', 'iap_hero_description', __( 'Content' )),
            Field::make('text', 'iap_hero_button_text', __( 'Button' )),
            Field::make('text', 'iap_hero_button_url', __( 'Url' )),
            Field::make( 'image', 'iap_hero_image', __( 'Imagine' ) ),
        ])

        
        -> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
            <div class="hero-big">
                <div class="container">
                    <div class="hero-inner">
            
                        <div class="hero-content">
                            <h2 class="hero-title"><?= $fields['iap_hero_title'] ?></h2>
                            <p class="hero-big-description"><?= $fields['iap_hero_description'] ?></p>
                            <a href="#" class="button-hero-big"><?=$fields['iap_hero_button_text']?></a>
                        </div>
            
                        <div class="hero-image">
                            <?= wp_get_attachment_image( $fields['iap_hero_image'], 'full' ); ?>    
                        </div>
                    </div>
                </div>
            </div>
    <?php
    });
	
  
	Block::make('My Section')
        -> add_fields([
            Field::make( 'text', 'iap_section_title', __( 'Title' ) ),
            Field::make( 'text', 'iap_section_description', __( 'Text' ) ),
            Field::make('text', 'iap_hero_button_text2', __( 'Button' )),
            Field::make('text', 'iap_hero_button_url2', __( 'Url' )),
            Field::make( 'complex', 'iap_section_cards', __( 'Cards' ) )
                -> add_fields([
                    Field::make( 'image', 'iap_section_card_image', __( 'Image' ) ),
                    Field::make( 'text', 'iap_section_card_title', __( 'Title' ) ),
                    Field::make( 'text', 'iap_section_card_description', __( 'Text' ) )
                ]),
            
        ])
                          
    	-> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
            <div class="section">
                <div class="container">
                    <div class="section-inner">
                        <div class="section-content">
                            <h2 class="section-title"><?= $fields['iap_section_title'] ?></h2>
                            <p class="section-intro"><?= $fields['iap_section_description'] ?></p>

                            <?php if($fields['iap_section_cards']): ?>
                                <div class="cards">
                                    <?php foreach($fields['iap_section_cards'] as $field): ?>
                                        <div class="card-wrap">
                                            <div class="card">
                                                <div class="card-image"><?= wp_get_attachment_image( $field['iap_section_card_image'], 'full' ); ?></div>
                                                <h3 class="card-title"><?= $field['iap_section_card_title'] ?></h3>
                                                <p class="card-description"><?= $field['iap_section_card_description'] ?></p>
                                            </div>
                                        </div>    
                                    <?php endforeach ?>

                                </div>
                            <?php endif ?>

                            <a href="<?= $fields['iap_hero_button_url2']?>" class="button-section"><?=$fields['iap_hero_button_text2']?></a>
                        </div>
                    </div>
                </div>
            </div>
		<?php
	});
        

    Block::make('My Hero Providers')
        -> add_fields([
            Field::make('text', 'iap_hero_providers_title', __( 'Title' )),
            Field::make('rich_text', 'iap_hero_providers_description', __( 'Content' )),
            Field::make('text', 'iap_hero_button_text3', __( 'Button' )),
            Field::make('text', 'iap_hero_button_url3', __( 'Url' )),
            Field::make( 'image', 'iap_hero_providers_image', __( 'Imagine' ) ),
        ])
   
        -> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
            <div class="hero-providers">
                <div class="container">
                    <div class="hero-inner">

                        <div class="hero-image">
                            <?= wp_get_attachment_image( $fields['iap_hero_providers_image'], 'full' ); ?> 
                        </div>

                        <div class="hero-content">
                            <h2 class="hero-title"><?= $fields['iap_hero_providers_title'] ?></h2>
                            <p class="hero-providers-description"><?= $fields['iap_hero_providers_description'] ?></p>

                            <a href="<?= $fields['iap_hero_button_url3']?>" class="button-hero-providers"><?=$fields['iap_hero_button_text3']?></a>
                        </div>

                    </div>
                </div>
            </div>
        <?php
         });

    
    Block::make('My Apps')
        -> add_fields([
            Field::make('text', 'iap_apps_title', __( 'Title' )),
            Field::make('rich_text', 'iap_apps_description', __( 'Content' )),
            Field::make('text', 'iap_apps_button_text', __( 'Button' )),
            Field::make('text', 'iap_apps_button_url', __( 'Url' )),
            Field::make( 'image', 'iap_apps_image', __( 'Imagine' ) ),
        ])
    
        -> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
            <div class="hero-apps">
                <div class="container">
                    <div class="hero-inner">

                        <div class="hero-content">
                            <h2 class="hero-title"><?= $fields['iap_apps_title'] ?></h2>
                            <p class="hero-apps-description"><?= $fields['iap_apps_description'] ?></p>
                            <a href="<?= $fields['iap_apps_button_url']?>" class="button-hero-apps"><?=$fields['iap_apps_button_text']?></a>
                        </div>

                        <div class="hero-image">
                            <?= wp_get_attachment_image( $fields['iap_apps_image'], 'full' ); ?> 
                        </div>
                    </div>
                </div>
    
            </div>
        <?php
        });


    Block::make('My Testimonials')
        -> add_fields([
            Field::make('text', 'iap_testimonials_title', __( 'Title' )),
            Field::make( 'image', 'iap_testimonials_image', __( 'Imagine' ) ),
            Field::make( 'text', 'iap_testimonials_name', __( 'Name' ) ),
            Field::make( 'text', 'iap_testimonials_function', __( 'Function' ) ),
            Field::make('rich_text', 'iap_testimonials_description', __( 'Content' )),
            Field::make('text', 'iap_testimonials_button_url', __( 'Url' )),
            Field::make( 'image', 'iap_testimonials_button_image', __( 'Image' ) ),
        ])

        -> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
            
            <div class="testimonials">
                <div class="container">
                    <div class="testimonials-inner">
                        <h1 class="testimonials-title"><?= $fields['iap_testimonials_title'] ?></h1>
                        <div class="testimonials-content">
                            <div class="testimonials-about">
                                <div class="testimonials-image">
                                    <?= wp_get_attachment_image( $fields['iap_testimonials_image'], 'full' ); ?>
                                </div>

                                <div class="testimonials-text">
                                    <div class="testimonials-name"><?= $fields['iap_testimonials_name'] ?></div>
                                    <div class="testimonials-function"><?= $fields['iap_testimonials_function'] ?></div>
                                </div>
                            </div>
                            
                            <div class="testimonials-description"><?= $fields['iap_testimonials_description'] ?></div>
                        </div>
                    </div>
                    <a href="<?= $fields['iap_testimonials_button_url']?>" class="hero-arrow"><?= wp_get_attachment_image( $fields['iap_testimonials_button_image'], 'full' ); ?></a>
                    
                </div>
            </div>
        <?php
        });

    Block::make('My Article')
    -> add_fields([
        Field::make( 'text', 'iap_article_title', __( 'Title' ) ),
        Field::make( 'complex', 'iap_article_cards', __( 'Cards' ) ) 
            -> add_fields([
                Field::make( 'image', 'iap_article_card_image', __( 'Image' ) ),
                Field::make( 'text', 'iap_article_card_title', __( 'Title' ) ),
                Field::make( 'text', 'iap_article_card_description', __( 'Text' ) ),
                Field::make('text', 'iap_article_button_url', __( 'Url' )) ,
                Field::make('text', 'iap_article_button_text', __( 'Button' )),
                Field::make( 'image', 'iap_article_button_image', __( 'Image' ) )
            ]),

        Field::make('text', 'iap_article_button_url2', __( 'Url' )) ,
        Field::make('text', 'iap_article_button_text2', __( 'Button' ))
    ])
         
    -> set_render_callback( function( $fields, $attributes, $inner_blocks ) { ?>
        <div class="article">
            <div class="container">
                <div class="article-inner">
                    <div class="article-content">
                        <h2 class="article-title"><?= $fields['iap_article_title'] ?></h2>
                        <?php if($fields['iap_article_cards']): ?>
                        
                            <div class="article-cards">
                                <?php foreach($fields['iap_article_cards'] as $field): ?>   
                                    <div class="article-card-wrap">                                
                                        <div class="article-card">
                                            <div class="article-card-image"><?= wp_get_attachment_image( $field['iap_article_card_image'], 'full' ); ?></div>
                                            <h3 class="article-card-title"><?= $field['iap_article_card_title'] ?></h3>
                                            <p class="article-card-description"><?= $field['iap_article_card_description'] ?></p>
                                            <a href="<?= $field['iap_article_button_url']?>" class="button-article"><?=$field['iap_article_button_text']?><?= wp_get_attachment_image( $field['iap_article_button_image'], 'full' ); ?></a>
                                        </div>
                                    </div>
                                <?php endforeach ?>   
                            </div>
                        <?php endif ?>  

                        <?php if ($fields['iap_article_button_url2']): ?> 
                                    <a href="<?= $fields['iap_article_button_url2']?>" class="button-article2"><?=$fields['iap_article_button_text2']?></a>
                                <?php else: ?> 
                                    <span class="button-article2"><?=$fields['iap_article_button_text2']?></span>
                        <?php endif ?>

                    
                    </div>  
                </div>                                                 
            </div>
        </div>  
    <?php         
           
    });

}
add_action('carbon_fields_register_fields', 'iap_attach_gutenberg_blocks' ); 
   
        
                
                
                

                   