<?php
namespace Telelab\Paginator;

use Telelab\Component\ComponentStatic;

 /**
  * Paginator: Pagination
  *
  * @author gdievart
  */
class Paginator extends ComponentStatic
{

    /**
     * @var int Current page
     */
    protected static $_currentPage;

    /**
     * @var int Total page
     */
    protected static $_totalPages;

    /**
     * @var int Total items
     */
    protected static $_totalItems;

    /**
     * @var int Item per page
     */
    protected static $_stepItems;

    /**
     * @var int Number links around current page
     */
    protected static $_around = 4;


    /**
     * Get pagination
     *
     * @param int $current
     * @param int $totalItems
     * @param int $stepItem
     * @return array first previous current links next end
     */
    public static function getPagination($current, $totalItems, $stepItem = 10)
    {
        self::_initMembers($current, $totalItems, $stepItem);

        $pagination = array();
        $pagination['first'] = self::_getFirst();
        $pagination['prev']  = self::_getPrevious();
        $pagination['current'] = self::_getCurrent();
        $pagination['links'] = self::_getLinksAround();
        $pagination['next']  = self::_getNext();
        $pagination['last']  = self::_getLast();

        return $pagination;
    }


    /**
     * Init paginator
     *
     * @param type $current
     * @param type $totalItems
     * @param type $stepItem
     */
    private static function _initMembers($current, $totalItems, $stepItem = 10)
    {
        self::$_currentPage = $current;
        self::$_totalItems  = $totalItems;
        self::$_stepItems   = $stepItem;
        self::$_totalPages  = ceil($totalItems / $stepItem);
    }

    /**
     * Get first link
     *
     * @return int
     */
    private static function _getFirst()
    {
        return 1;
    }


    /**
     * Get previous link
     *
     * @return int
     */
    private static function _getPrevious()
    {
        return self::$_currentPage > 1 ? self::$_currentPage - 1 : null;
    }


    /**
     * Get linkAround
     *
     * @return array
     */
    private static function _getLinksAround()
    {
        if (self::$_currentPage > self::$_totalPages) {
            return self::$_currentPage = self::$_totalPages;
        }
        if (self::$_currentPage <= self::$_around) {
            $i      = 1;
            $limit = self::$_totalPages > (self::$_around + self::$_currentPage) ? self::$_around + self::$_currentPage : self::$_totalPages;
        } else {
            $i      = self::$_currentPage - self::$_around;
            $limit = self::$_totalPages > (self::$_currentPage + self::$_around) ? self::$_currentPage + self::$_around : self::$_totalPages ;
        }

        if ($limit <= (self::$_around * 2 + 1) && (self::$_around * 2 + 1) < self::$_totalPages) {
            $limit = self::$_around * 2 + 1;
        }

        $linksAround = range($i, $limit);

        return $linksAround;
    }


    /**
     * Get current page
     *
     * @return int
     */
    private static function _getCurrent()
    {
        return self::$_currentPage;
    }


    /**
     * Get next link
     *
     * @return int
     */
    private static function _getNext()
    {
        $next = (self::$_currentPage + 1) <= self::$_totalPages ? self::$_currentPage + 1 : null;

        return $next;
    }


    /**
     * Get last link
     *
     * @param int
     */
    private static function _getLast()
    {
        return self::$_totalPages;
    }


    /**
     * Set link around current
     *
     * @param int $around
     */
    public static function setAround($around)
    {
        self::$_around = $around;
    }
}