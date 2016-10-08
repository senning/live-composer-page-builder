<?php

class SampleTest extends WP_UnitTestCase {

	function test_dslc_get_new_module_id() {

		$new_id = dslc_get_new_module_id();

		$this->assertNull( $new_id );

		wp_set_current_user( 1 );
		$new_id = dslc_get_new_module_id();
		$this->assertInternalType( 'int', $new_id );
		// replace this with some actual testing code
		//$this->assertTrue( class_exists( 'DSLC_Module' ) );
	}
}

