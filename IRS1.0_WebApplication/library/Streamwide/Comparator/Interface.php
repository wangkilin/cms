<?php
/**
 * Comparator interface
 *
 * $Rev: 1953 $
 * $LastChangedDate: 2009-09-24 22:02:35 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Comparator
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Interface.php 1953 2009-09-24 14:02:35Z rgasler $
 */

interface Streamwide_Comparator_Interface
{
    /**
     * Compares two items in a collection. This function should return
     * -1 if $item1 is smaller than $item2 , 1 if $item1 is greater than $item2,
     * and 0 if $item1 and $item2 are equal
     *
     * @param mixed $item1 first item to compare
     * @param mixed $item2 second item to compare
     * @return integer
     */
    function compare( $item1, $item2 );
}

/* EOF */