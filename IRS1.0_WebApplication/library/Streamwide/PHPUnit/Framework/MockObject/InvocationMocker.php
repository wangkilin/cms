<?php
/**
 * Streamwide_PHPUnit MockObject InvocationMocker class
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Irina MIRICI <imirici@streamwide.ro>
 * @version    $Id: InvocationMocker.php 2103 2009-11-15 20:51:51Z rgasler $
 */

require_once 'Streamwide/PHPUnit/Framework/MockObject/Builder/InvocationMocker.php';

class Streamwide_PHPUnit_Framework_MockObject_InvocationMocker extends PHPUnit_Framework_MockObject_InvocationMocker
{
    /**
     * Overrides PHPUnit_Framework_MockObject_InvocationMocker::expects()
     * to return a customized builder
     *
     * @param PHPUnit_Framework_MockObject_Matcher_Invocation $matcher
     * @return Streamwide_PHPUnit_Framework_MockObject_Builder_InvocationMocker
     */
    public function expects(PHPUnit_Framework_MockObject_Matcher_Invocation $matcher)
    {
        $builder = new Streamwide_PHPUnit_Framework_MockObject_Builder_InvocationMocker($this, $matcher);

        return $builder;
    }

}
/* EOF */