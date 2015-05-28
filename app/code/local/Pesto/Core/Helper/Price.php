<?php
/**
 * File: Price.php
 * Date: 28.05.15 - 13:18
 *
 * @author pest (pest11s@gmail.com)
 */

class Pesto_Core_Helper_Price extends Mage_Core_Helper_Abstract {

	/*
	 * Output product price with set number of decimals,
	 * currency symbol ($) or short name (USD),
	 * and with additional wrappers.
	 *
	 * @param $product - product model
	 * @return string with HTML code.
	 */
	public function printProductPrice($product, $decimals = 2, $symbol = TRUE) {
		$final_price = number_format($product->getFinalPrice(), $decimals, '.', '');

		if ($symbol) {
			$currency = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
		} else {
			$currency = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getShortName();
		}

		$result = '<span class="price-wrapper">';
			$result .= $final_price;
			$result .= ' <span class="currency">'.$currency.'</span>';
		$result .= '</span>';

		return $result;
	}

}