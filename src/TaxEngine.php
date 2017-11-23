<?php  
namespace Printerous\Library;
/**
* 
*/
class TaxEngine
{
	function tax($scheme,$price,$rules)
	{
		$tax = $this->$scheme($price,$rules);
		return $tax;
	}

	function taxExclusive($price,$rules)
	{
		$rules_obj = json_decode($rules);
		$precision = $rules_obj->precision;
		$percentage = $rules_obj->value;
		$tax = $price * $percentage/100;
		$tax = round($tax,$precision,PHP_ROUND_HALF_UP);
		return $tax;
	}

	function taxInclusive($price,$rules)
	{
		$tax = 'Inclusive';
		return $tax;
	}

	function taxFree($price,$rules)
	{
		$tax = $price;
		return $tax;
	}
}
?>