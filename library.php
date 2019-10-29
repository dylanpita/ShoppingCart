<?php

	class order{
		private $itemID;
		private $itemName;
		private $itemPrice;
		private $quantityWanted;
		private $itemColor;
		private $itemSize;
		
		function __construct($iD, $iN, $iP, $qW, $iC, $iS) {
			
			$this -> itemID = $iD;
			$this -> itemName = $iN;
			$this -> itemPrice = $iP;
			$this -> quantityWanted = $qW;
			$this -> itemColor = $iC;
			$this -> itemSize = $iS;
		
		}
		
		public function get_itemID() {
			return $this -> itemID;
		}
		public function set_itemID($itemID) {
			$this -> itemID = $itemID;
		}
		public function get_itemName() {
			return $this -> itemName;
		}
		public function set_itemName($itemName) {
			$this -> itemName = $itemName;
		}
		public function get_itemPrice() {
			return $this -> itemPrice;
		}
		public function set_itemPrice($itemPrice) {
			$this -> itemPrice = $itemPrice;
		}
		public function get_quantityWanted() {
			return $this -> quantityWanted;
		}
		public function set_quantityWanted($quantityWanted) {
			$this -> quantityWanted = $quantityWanted;
		}
		public function get_itemColor() {
			return $this -> itemColor;
		}
		public function set_itemColor($itemColor) {
			$this -> itemColor = $itemColor;
		}
		public function get_itemSize() {
			return $this -> itemSize;
		}
		public function set_itemSize($itemSize) {
			$this -> itemSize = $itemSize;
		}
		
		public function calculateSubTotal() {
			return $this -> itemPrice * $this -> quantityWanted;
		}
		public function calculateTaxTotal() {
			return number_format($this -> calculateSubTotal() * (0.05 + 0.09975), 2);
		}
		public function calculateTotal() {
			return number_format($this -> calculateSubTotal() + $this -> calculateTaxTotal(), 2);
		}
	}
	
	$shipping_arr = array("Standard" => 5.99, "Express" => 9.99, "One-Day" => 15.99 );
 
?>