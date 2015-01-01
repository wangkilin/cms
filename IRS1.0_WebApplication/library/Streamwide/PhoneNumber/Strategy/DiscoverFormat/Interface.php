<?php
/**
 * Interface for the Strategy to discover phone number format.
 *
 * $Rev: 1953 $
 * $LastChangedDate: 2009-09-24 22:02:35 +0800 (Thu, 24 Sep 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PhoneNumber
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Radu Gasler <rgasler@streamwide.ro>
 * @version    $Id: Interface.php 1953 2009-09-24 14:02:35Z rgasler $
 */

interface Streamwide_PhoneNumber_Strategy_DiscoverFormat_Interface
{
    /**
     * Set the current transformer context.
     *
     * @param Streamwide_PhoneNumber_Transformer $context the current transformer context
     * @return void
     */
    public function setContext(Streamwide_PhoneNumber_Transformer $context);
    
    /**
     * Discover phone number format based on locale settings.
     *
     * @return string the format of the phone number
     * @see Streamwide_PhoneNumber_Transformer::getAllFormats()
     * @see Streamwide_PhoneNumber_Transformer::SHORT
     */
    public function discoverFormat();
}

/* EOF */