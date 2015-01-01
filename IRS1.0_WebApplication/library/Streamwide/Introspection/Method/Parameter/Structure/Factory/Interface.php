<?php
/**
 * Interface to be implemented by classes that generate structures.
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


/**
 * Interface to be implemented by classes that generate structures
 */
interface Streamwide_Introspection_Method_Parameter_Structure_Factory_Interface
{
    /**
     * Generate the structure
     *
     * @return Streamwide_Introspection_Method_Parameter_Structure
     */
    public function createStructure();
}

/* EOF */