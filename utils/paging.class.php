<?php

/**
 * paging creation class
 *
 * @author ISK
 */

class paging {
	private $pageRange;
	
	public $first;
	public $size;
	
	public $totalRecords;
	public $totalPages;
	
	public $data = array();
	
	/**
	* @desc constructor
	* @param int amount to show value in a single page
	*/
	public function __construct($rowsPerPage) {
		$this->size = $rowsPerPage;
		$this->pageRange = 5;
	}
	
	/**
	* @desc page creation
	* @param int  amount of total value in a list
	* @param int  selected page
	*/
	public function process($total, $currentPage) {
		// we count page amount
		$pageCount = ceil($total / $this->size);
		
		// statistics are created
		$this->totalRecords = (int) $total;
		$this->totalPages = (int) ($pageCount) ? $pageCount : 1;
		$this->first = ($currentPage - 1) * $this->size;
		
		// page formation
		for($i = 1; $i <= $pageCount; $i++) {
			$row['isActive'] = ($i == $currentPage) ? 1 : 0;
			$row['page'] = $i;
			
			$this->data[] = $row;
		}		
	}
}

?>