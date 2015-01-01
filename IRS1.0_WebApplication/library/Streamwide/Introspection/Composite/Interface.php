<?php
/**
 * Introspection composite interface.
 *
 * A composite is an element with children.
 * This interface provides methods for adding, removing and interogating a composite.
 *
 * $Rev: 1962 $
 * $LastChangedDate: 2009-09-25 04:49:25 +0800 (Fri, 25 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_Introspection
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @version    $Id: Interface.php 1962 2009-09-24 20:49:25Z rgasler $
 */

interface Streamwide_Introspection_Composite_Interface extends Streamwide_Introspection_Leaf_Interface
{
    /**
     * Add a child
     *
     * @param Streamwide_Introspection_Leaf_Interface $child child object
     * @return void
     */
    public function addChild( Streamwide_Introspection_Leaf_Interface $child );

    /**
     * Remove a child
     *
     * @param Streamwide_Introspection_Leaf_Interface $child child object
     * @return boolean True if the child was removed, false otherwise
     */
    public function removeChild( Streamwide_Introspection_Leaf_Interface $child );

    /**
     * Do we have children attached?
     *
     * @return boolean
     */
    public function hasChildren();

}

/* EOF */