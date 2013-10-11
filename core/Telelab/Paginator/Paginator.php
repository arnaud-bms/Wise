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
    protected static $currentPage;

    /**
     * @var int Total page
     */
    protected static $totalPages;

    /**
     * @var int Total items
     */
    protected static $totalItems;

    /**
     * @var int Item per page
     */
    protected static $stepItems;

    /**
     * @var int Number links around current page
     */
    protected static $around = 4;


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
        self::initMembers($current, $totalItems, $stepItem);

        $pagination = array();
        $pagination['first'] = self::getFirst();
        $pagination['prev']  = self::getPrevious();
        $pagination['current'] = self::getCurrent();
        $pagination['links'] = self::getLinksAround();
        $pagination['next']  = self::getNext();
        $pagination['last']  = self::getLast();

        return $pagination;
    }


    /**
     * Init paginator
     *
     * @param type $current
     * @param type $totalItems
     * @param type $stepItem
     */
    private static function initMembers($current, $totalItems, $stepItem = 10)
    {
        self::$currentPage = $current;
        self::$totalItems  = $totalItems;
        self::$stepItems   = $stepItem;
        self::$totalPages  = ceil($totalItems / $stepItem);
    }

    /**
     * Get first link
     *
     * @return int
     */
    private static function getFirst()
    {
        return 1;
    }


    /**
     * Get previous link
     *
     * @return int
     */
    private static function getPrevious()
    {
        return self::$currentPage > 1 ? self::$currentPage - 1 : null;
    }


    /**
     * Get linkAround
     *
     * @return array
     */
    private static function getLinksAround()
    {
        if (self::$currentPage > self::$totalPages) {
            return self::$currentPage = self::$totalPages;
        }
        if (self::$currentPage <= self::$around) {
            $i      = 1;
            $limit = self::$totalPages > (self::$around + self::$currentPage) ? self::$around + self::$currentPage : self::$totalPages;
        } else {
            $i      = self::$currentPage - self::$around;
            $limit = self::$totalPages > (self::$currentPage + self::$around) ? self::$currentPage + self::$around : self::$totalPages ;
        }

        if ($limit <= (self::$around * 2 + 1) && (self::$around * 2 + 1) < self::$totalPages) {
            $limit = self::$around * 2 + 1;
        }

        $linksAround = range($i, $limit);

        return $linksAround;
    }


    /**
     * Get current page
     *
     * @return int
     */
    private static function getCurrent()
    {
        return self::$currentPage;
    }


    /**
     * Get next link
     *
     * @return int
     */
    private static function getNext()
    {
        $next = (self::$currentPage + 1) <= self::$totalPages ? self::$currentPage + 1 : null;

        return $next;
    }


    /**
     * Get last link
     *
     * @param int
     */
    private static function getLast()
    {
        return self::$totalPages;
    }


    /**
     * Set link around current
     *
     * @param int $around
     */
    public static function setAround($around)
    {
        self::$around = $around;
    }
}