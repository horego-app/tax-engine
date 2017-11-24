<?php  
namespace Printerous\Library;
/**
* 
*/
class TaxEngine
{
	function tax($policy,$price,$rules)
	{
		if(stripos($policy, 'free') !== false){
			$policy = 'taxFree';
		} else if(stripos($policy,'exclusive') !== false) {
			$policy = 'taxExclusive';
		}
		else {
			$policy = 'taxInclusive';
		}
		$tax = $this->$policy($price,$rules);
		$price_method = $policy.'Price';
		$prices = $this->$price_method($tax,$price);
		$result = $prices;
		$result['tax'] = $tax;
		return $result;
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
		$rules_obj = json_decode($rules);
		$precision = $rules_obj->precision;
		$percentage = $rules_obj->value;
		$tax = $price - ($price/((100+$percentage)/100));
		$tax = round($tax,$precision,PHP_ROUND_HALF_UP);
		return $tax;
	}

	function taxFree($price,$rules)
	{
		$tax = 0;
		return $tax;
	}

	function taxExclusivePrice($tax,$price)
	{
		$price_after_tax = $price + $tax;
		$price_before_tax = $price;
		$prices = ['price_before_tax' => $price_before_tax, 'price_after_tax' => $price_after_tax];
		return $prices;
	}

	function taxInclusivePrice($tax,$price)
	{
		$price_after_tax = $price;
		$price_before_tax = $price-$tax;
		$prices = ['price_before_tax' => $price_before_tax, 'price_after_tax' => $price_after_tax];
		return $prices;
	}

	function taxFreePrice($tax,$price)
	{
		return $this->taxInclusivePrice($tax,$price);
	}
}
?>