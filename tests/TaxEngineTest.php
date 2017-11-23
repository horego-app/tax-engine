<?php
use PHPUnit\Framework\TestCase;
use Printerous\Library\TaxEngine;

class TaxEngineTest extends TestCase
{
	function testExclusive(){
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$this->assertEquals(1000,$engine->tax('taxExclusive',10000,$rules));
	}
	function testExclusive2(){
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$this->assertEquals(85472,$engine->tax('taxExclusive',854722,$rules));
	}
	function testExclusive3(){
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$this->assertEquals(85478,$engine->tax('taxExclusive',854779,$rules));
	}

	function testInclusive(){
		$engine = new TaxEngine();
		$this->assertEquals('Inclusive', $engine->tax('taxInclusive',1000,true));
	}
}