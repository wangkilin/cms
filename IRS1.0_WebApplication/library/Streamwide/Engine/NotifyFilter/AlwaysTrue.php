<?php
/**
 *
 * $Rev: 2088 $
 * $LastChangedDate: 2009-10-30 20:56:54 +0800 (Fri, 30 Oct 2009) $
 * $LastChangedBy: salexandru $
 *
 * @author Stefan ALEXANDRU <salexandru@streamwide.ro>
 * @copyright 2009 Streamwide SAS
 * @package Package
 * @subpackage SubPackage
 * @version 1.0
 *
 */

class Streamwide_Engine_NotifyFilter_AlwaysTrue extends Streamwide_Engine_NotifyFilter
{
    
    public function __construct()
    {
        parent::__construct( null );
    }
    
    public function isSatisfiedBy( $candidate )
    {
        return true;
    }
    
}
 
/* EOF */