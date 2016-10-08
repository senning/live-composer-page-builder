<?php

class SampleTest extends WP_UnitTestCase {

	function test_dslc_get_new_module_id() {

		$new_id = dslc_get_new_module_id();

		$this->assertInternalType( 'int',  9 );
		// replace this with some actual testing code
		//$this->assertTrue( class_exists( 'DSLC_Module' ) );
	}
}

