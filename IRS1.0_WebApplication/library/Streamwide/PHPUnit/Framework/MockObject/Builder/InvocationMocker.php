<?php
/**
 * Builder for mocked or stubbed invocations.
 * Class Streamwide_PHPUnit_Framework_MockObject_Builder_InvocationMocker extends PHPUnit_Framework_MockObject_Builder_InvocationMocker
 * Override parent::method( $constraint ), to make sure it sets method name in an matcher of type InvokedAtMethodCall
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

/**
 * Builder for mocked or stubbed invocations.
 *
 * @package Streamwide_PHPUnit
 * @subpackage Mock
 */
class Streamwide_PHPUnit_Framework_MockObject_Builder_InvocationMocker extends PHPUnit_Framework_MockObject_Builder_InvocationMocker
{
    /**
     * Override method to set in an matcher of type Streamwide_PHPUnit_Framework_MockObject_Matcher_InvokedAtMethodCall
     * the method name.
     *
     * @param string|PHPUnit_Framework_Constraint $constraint When you have an Streamwide_PHPUnit_Framework_MockObject_Matcher_InvokedAtMethodCall matcher, constraint must be string (method name)
     */
    public function method($constraint)
    {
        /*
         * When the invocationMatcher of the curent matcher we build is of type
         * Streamwide_PHPUnit_Framework_MockObject_Matcher_InvokedAtMethodCall,
         * we need to set it the method name. The constraint must be a string specifying method name
         */
        if ( $this->matcher->invocationMatcher !== NULL
            && $this->matcher->invocationMatcher instanceof Streamwide_PHPUnit_Framework_MockObject_Matcher_InvokedAtMethodCall ) {
                if ( ! is_string( $constraint ) ) {
                    throw new RuntimeException( 'When you use an atMethodCall matcher, the method constraint must receive a string representing the name of the method.' );
                }
                $this->matcher->invocationMatcher->methodName = $constraint;
        }

        return parent::method($constraint);
    }
}
/* EOF */
