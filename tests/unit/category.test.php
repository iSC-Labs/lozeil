<?php
/*
	lozeil
	$Author: adrien $
	$URL: $
	$Revision:  $

	Copyright (C) No Parking 2013 - 2013
*/

require_once dirname(__FILE__)."/../inc/require.inc.php";

class tests_Category extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"categories"
		);
	}
	
	function test_save_load() {
		$category = new Category();
		$category->name = "première category";
		$category->save();
		$category_loaded = new Category();
		$category_loaded->id = 1;
		$category_loaded->load();
		$this->assertEqual($category_loaded->name, $category->name);
		$this->truncateTable("categories");
	}
	
	function test_update() {
		$category = new Category();
		$category->name = "premier category";
		$category->save();
		$category_loaded = new Category();
		$category_loaded->id = 1;
		$category_loaded->name = "changement de nom";
		$category_loaded->update();
		$category_loaded2 = new Category();
		$category_loaded2->id = 1;
		$category_loaded2->load();
		$this->assertNotEqual($category_loaded2->name, $category->name);
		$this->truncateTable("categories");
	}
	
	function test_delete() {
		$category = new Category();
		$category->name = "premier category";
		$category->save();
		$category_loaded = new Category();
		$this->assertTrue($category_loaded->load(1));
		$category->delete();
		$this->assertFalse($category_loaded->load(1));
		$this->truncateTable("categories");
	}
}
