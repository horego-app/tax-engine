<?php
use PHPUnit\Framework\TestCase;
use Printerous\Library\TaxEngine;

class TaxEngineTest extends TestCase
{
	function testExclusive(){
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$this->assertEquals(1000,$engine->taxExclusive(10000,$rules));
	}
	function testExclusive2(){
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$this->assertEquals(85472,$engine->taxExclusive(854722,$rules));
	}
	function testExclusive3(){
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$this->assertEquals(85478,$engine->taxExclusive(854779,$rules));
	}
	function testExclusive4(){
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 2, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$this->assertEquals(0.24,$engine->taxExclusive(2.35,$rules));
	}
	function testExclusive5(){
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$this->assertEquals(0,$engine->taxExclusive(2.35,$rules));
	}
	function testInclusive(){
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$this->assertEquals(91, $engine->taxInclusive(1000,$rules));
	}

	function testInclusive2(){
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$this->assertEquals(9091, $engine->taxInclusive(100000,$rules));
	}
	function testInclusive3(){
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 2, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$this->assertEquals(90.91, $engine->taxInclusive(1000,$rules));
	}

	function testExclusivePrice()
	{
		$engine = new TaxEngine();
		$this->assertEquals(['price_before_tax' => 10000,'price_after_tax' => 11000], $engine->taxExclusivePrice(1000,10000));
	}

	function testExclusiveResult()
	{
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$expected_result = ['price_before_tax' => 10000, 'price_after_tax' => 11000, 'tax' => 1000];
		$this->assertEquals($expected_result,$engine->tax('taxExclusive',10000, $rules));
	}

	function testExclusiveResult2()
	{
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$expected_result = ['price_before_tax' => 181364, 'price_after_tax' => 199500, 'tax' => 18136];
		$this->assertEquals($expected_result,$engine->tax('taxExclusive',181364, $rules));
	}

	function testInclusiveResult()
	{
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$expected_result = ['price_before_tax' => 90909, 'price_after_tax' => 100000, 'tax' => 9091];
		$this->assertEquals($expected_result,$engine->tax('taxInclusive',100000, $rules));
	}

	function testNoTaxResult()
	{
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$expected_result = ['price_before_tax' => 100000, 'price_after_tax' => 100000, 'tax' => 0];
		$this->assertEquals($expected_result,$engine->tax('no tax',100000, $rules));
	}
	function testTaxFreeResult()
	{
		$engine = new TaxEngine();
		$rules_arr = ['precision' => 0, 'value' => '10', 'type' => 'percent'];
		$rules = json_encode($rules_arr);
		$expected_result = ['price_before_tax' => 100000, 'price_after_tax' => 100000, 'tax' => 0];
		$this->assertEquals($expected_result,$engine->tax('tax free',100000, $rules));
	}
}