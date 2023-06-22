<?php
/**
 * @package OpenAI Modules for Beaver Builder
 */

class BotterFly_LetterPage_Module extends FLBuilderModule {

    public function __construct() {
        parent::__construct( array(
            'name' => __( 'Letter Page', 'botterfly-custom-bb-modules' ),
            'description' => __( 'BotterFly Module', 'botterfly-custom-bb-modules' ),
            'category' => __( 'OpenAI Modules', 'botterfly-custom-bb-modules' ),
            'dir' => botterfly_custom_bb_modules_PATH . 'modules/letter-page/',
            'url' => botterfly_custom_bb_modules_URL . 'modules/letter-page/',
            'partial_refresh' => true,
        ) );
        $this->add_css( 'bt-css', '//stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );
        $this->add_css( 'boxicons-css', '//unpkg.com/boxicons@2.0.9/css/boxicons.min.css' );
        $this->add_css( 'summernote-css', '//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css' );
        $this->add_js( 'bt-js', '//stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array( 'jquery' ), '4.5.2', true );
        $this->add_js( 'summernote-js', '//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js', array( 'jquery' ), '4.5.2', true );
    }

}

FLBuilder::register_module( 'BotterFly_LetterPage_Module', array() );

?>
