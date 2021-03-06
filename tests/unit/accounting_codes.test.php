<?php
/* Lozeil -- Copyright (C) No Parking 2013 - 2016 */

require_once dirname(__FILE__)."/../inc/require.inc.php";

class tests_Accounting_Codes extends TableTestCase {
	function __construct() {
		parent::__construct();
		$this->initializeTables(
			"accountingcodes"
		);
	}
	
	function test_grid_body() {
		$accountingcode = new Accounting_Code();
		$accountingcode->number = "41101";
		$accountingcode->name = "autre test 41101";
		$accountingcode->save();
		$accountingcode = new Accounting_Code();
		$accountingcode->number = 10;
		$accountingcode->name = "test 10";
		$accountingcode->save();
		$accountingcode = new Accounting_Code();
		$accountingcode->number = 101;
		$accountingcode->name = "autre test 101";
		$accountingcode->save();
		$accountingcode = new Accounting_Code();
		$accountingcode->number = "410001";
		$accountingcode->name = "autre test 410001";
		$accountingcode->save();
		$accountingcode = new Accounting_Code();
		$accountingcode->number = 1;
		$accountingcode->name = "autre test 1";
		$accountingcode->save();
		$accountingcode = new Accounting_Code();
		$accountingcode->number = "411AB";
		$accountingcode->name = "autre test 411AB";
		$accountingcode->save();
		$accountingcode = new Accounting_Code();
		$accountingcode->number = "411AB02";
		$accountingcode->name = "autre test 411AB02";
		$accountingcode->save();
		$accountingcodes = new Accounting_Codes();
		$accountingcodes->select();
		
		$grid = $accountingcodes->grid_body();
		$this->assertEqual(array_keys($grid), array("1", "10", "101", "410001", "41101", "411AB", "411AB02"));
		$this->assertEqual($grid['411AB']['class'], "411 accounting_codes_shift_3");
		$this->assertEqual($grid['411AB02']['class'], "411 accounting_codes_shift_3");
		
		$this->truncateTables("accountingcodes");
	}
	
	function test_fullnames() {
		$accountingcode = new Accounting_Code();
		$accountingcode->number = 601;
		$accountingcode->name = "test 601";
		$accountingcode->save();
		$accountingcode = new Accounting_Code();
		$accountingcode->number = 603;
		$accountingcode->name = "autre test 603";
		$accountingcode->save();
		$accountingcodes = new Accounting_Codes();
		$accountingcodes->select();
		$fullnames = $accountingcodes->fullnames();
		$this->assertEqual($fullnames[1], "60100000 - test 601");
		$this->assertEqual($fullnames[2], "60300000 - autre test 603");

		$this->truncateTable("accountingcodes");
	}
	
	function test_numbers() {
		$accountingcode = new Accounting_Code();
		$accountingcode->number = 601;
		$accountingcode->save();
		$accountingcode = new Accounting_Code();
		$accountingcode->number = 603;
		$accountingcode->save();
		$accountingcodes = new Accounting_Codes();
		$accountingcodes->select();
		$fullnames = $accountingcodes->numbers();
		$this->assertEqual($fullnames[1], "60100000");
		$this->assertEqual($fullnames[2], "60300000");
		$this->truncateTable("accountingcodes");
	}
	
	function test_filter_with() {
		$accounting_codes = new Accounting_Codes();
		$accounting_codes->filter_with(array('id' => 3));
		$this->assertTrue($accounting_codes->filters['id'] == 3);
		$this->truncateTable("accountingcodes");
	}

	function test_get_where() {
		$code1 = new Accounting_Code();
		$code1->name = "Code 1";
		$code1->number = "1";
		$code1->save();

		$code2 = new Accounting_Code();
		$code2->name = "Code 2";
		$code2->number = "2";
		$code2->save();

		$codes = new Accounting_Codes();
		$codes->filter_with(array('>id' => 1));
		$codes->select();

		$this->assertEqual(count($codes), 1);

		$this->truncateTables("accountingcodes");
	}	
}
