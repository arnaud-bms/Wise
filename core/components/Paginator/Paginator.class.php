<?php
namespace Telelab\Paginator;

use Telelab\Component\ComponentStatic;

 /**
  * Class MPaginator
  *
  * @author gdievart
  */
class Paginator extends ComponentStatic{

	/**
	 * Current page
	 * @var int
	 */
	protected static $_iCurrentPage;

	/**
	 * Total page
	 * @var int
	 */
	protected static $_iTotalPages;

	/**
	 * Total items
	 * @var int
	 */
	protected static $_iTotalItems;

	/**
	 * Item per page
	 * @var int
	 */
	protected static $_iStepItems;

	/**
	 * Number links around current page
	 * @var int
	 */
	protected static $_iAround = 4;


	/**
	 * Get pagination
	 *
	 * @param int $iCurrent
	 * @param int $iTotalItems
	 * @param int $iStepItem
	 * @return array first previous current links next end
	 */
	public static function getPagination($iCurrent, $iTotalItems, $iStepItem = 10) {
		self::_initMembers($iCurrent, $iTotalItems, $iStepItem);

		$aPagination = array();
		$aPagination['first'] = self::_getFirst();
		$aPagination['prev']  = self::_getPrevious();
		$aPagination['current'] = self::_getCurrent();
		$aPagination['links'] = self::_getLinksAround();
		$aPagination['next']  = self::_getNext();
		$aPagination['last']  = self::_getLast();

		return $aPagination;
	}


	/**
	 * Init paginator
	 *
	 * @param type $iCurrent
	 * @param type $iTotalItems
	 * @param type $iStepItem
	 */
	private static function _initMembers($iCurrent, $iTotalItems, $iStepItem = 10) {
		self::$_iCurrentPage = $iCurrent;
		self::$_iTotalItems  = $iTotalItems;
		self::$_iStepItems   = $iStepItem;
		self::$_iTotalPages  = ceil( $iTotalItems / $iStepItem);
	}

	/**
	 * Get first link
	 *
	 * @return int
	 */
 	private static function _getFirst() {
		return 1;
	}


	/**
	 * Get previous link
	 *
	 * @return int
	 */
 	private static function _getPrevious() {
		return self::$_iCurrentPage > 1 ? self::$_iCurrentPage - 1 : null;
	}


	/**
	 * Get linkAround
	 *
	 * @return array
	 */
 	private static function _getLinksAround() {
        if (self::$_iCurrentPage > self::$_iTotalPages) {
            return self::$_iCurrentPage = self::$_iTotalPages;
        }
		if(self::$_iCurrentPage <= self::$_iAround) {
            $i      = 1;
            $iLimit = self::$_iTotalPages > (self::$_iAround + self::$_iCurrentPage) ? self::$_iAround + self::$_iCurrentPage : self::$_iTotalPages;
        }
		else {
			$i      = self::$_iCurrentPage - self::$_iAround;
            $iLimit = self::$_iTotalPages > (self::$_iCurrentPage + self::$_iAround) ? self::$_iCurrentPage + self::$_iAround : self::$_iTotalPages ;
		}

		if($iLimit <= (self::$_iAround * 2 + 1) && (self::$_iAround * 2 + 1) < self::$_iTotalPages)
			$iLimit = self::$_iAround * 2 + 1;

		$aLinksAround = range($i, $iLimit);

		return $aLinksAround;
	}


	/**
	 * Get current page
	 *
	 * @return int
	 */
 	private static function _getCurrent() {
		return self::$_iCurrentPage;
	}


	/**
	 * Get next link
	 *
	 * @return int
	 */
 	private static function _getNext() {
		$iNext = (self::$_iCurrentPage + 1) <= self::$_iTotalPages ? self::$_iCurrentPage + 1 : null;

		return $iNext;
	}


	/**
	 * Get last link
	 *
	 * @param int
	 */
 	private static function _getLast() {
		return self::$_iTotalPages;
	}


	/**
	 * Set link around current
	 *
	 * @param int $iAround
	 */
 	public static function setAround($iAround) {
		self::$_iAround = $iAround;
	}
}