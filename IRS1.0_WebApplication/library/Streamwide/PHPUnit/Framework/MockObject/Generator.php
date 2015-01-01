<?php
/**
 * Streamwide_PHPUnit_Framework_MockObject_Generator class
 *
 * $Rev: 2103 $
 * $LastChangedDate: 2009-11-16 04:51:51 +0800 (Mon, 16 Nov 2009) $
 * $LastChangedBy: rgasler $
 *
 * @category   Streamwide
 * @package    Streamwide_PHPUnit
 * @copyright  Copyright (c) 2009 Streamwide SAS
 * @author     Irina MIRICI <imirici@streamwide.ro>
 * @version    $Id: Generator.php 2103 2009-11-15 20:51:51Z rgasler $
 */

class Streamwide_PHPUnit_Framework_MockObject_Generator extends PHPUnit_Framework_MockObject_Generator
{

    /**
     * Overrides PHPUnit_Framework_MockObject_Generator::generate()
     * to be able to call the also redefined static method generateMock()
     * @param  string  $originalClassName
     * @param  array   $methods
     * @param  string  $mockClassName
     * @param  boolean $callOriginalClone
     * @param  boolean $callAutoload
     * @return array
     */
    public static function generate($originalClassName, array $methods = NULL, $mockClassName = '', $callOriginalClone = TRUE, $callAutoload = TRUE)
    {
        if ($mockClassName == '') {
            $key = md5(
              $originalClassName .
              serialize($methods) .
              serialize($callOriginalClone)
            );

            if (isset(self::$cache[$key])) {
                return self::$cache[$key];
            }
        }

        $mock = self::generateMock(
          $originalClassName,
          $methods,
          $mockClassName,
          $callOriginalClone,
          $callAutoload
        );

        if (isset($key)) {
            self::$cache[$key] = $mock;
        }

        return $mock;
    }

    /**
     * Overrides PHPUnit_Framework_MockObject_Generator::generateMock()
     * to load a template which defines a customized invocationMocker in mock definition
     * @param  string  $originalClassName
     * @param  array   $methods
     * @param  string  $mockClassName
     * @param  boolean $callOriginalClone
     * @param  boolean $callAutoload
     * @return array
     */
    protected static function generateMock($originalClassName, array $methods = NULL, $mockClassName, $callOriginalClone, $callAutoload)
    {
        $templateDir   = dirname( dirname( dirname( dirname(__FILE__) ) ) ) .
            DIRECTORY_SEPARATOR . 'PHPUnit'. DIRECTORY_SEPARATOR. 'Framework' .
            DIRECTORY_SEPARATOR . 'MockObject' . DIRECTORY_SEPARATOR . 'Generator' . DIRECTORY_SEPARATOR;

        $swTemplateDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Generator' . DIRECTORY_SEPARATOR;

        $classTemplate = new PHPUnit_Util_Template($swTemplateDir . 'mocked_class.tpl');
        $cloneTemplate = '';
        $isClass       = FALSE;
        $isInterface   = FALSE;

        $mockClassName = self::generateMockClassName(
          $originalClassName, $mockClassName
        );

        if (class_exists($originalClassName, $callAutoload)) {
            $isClass = TRUE;
        } else {
            if (interface_exists($originalClassName, $callAutoload)) {
                $isInterface = TRUE;
            }
        }

        if (!class_exists($mockClassName['fullClassName'], $callAutoload) &&
            !interface_exists($mockClassName['fullClassName'], $callAutoload)) {
            $prologue = 'class ' . $mockClassName['className'] . "\n{\n}\n\n";

            if (!empty($mockClassName['namespaceName'])) {
                $prologue = 'namespace ' . $mockClassName['namespaceName'] . ";\n\n" . $prologue;
            }

            $cloneTemplate = new PHPUnit_Util_Template($templateDir . 'mocked_clone.tpl');
        } else {
            $class = new ReflectionClass($mockClassName['fullClassName']);

            if ($class->isFinal()) {
                throw new RuntimeException(
                  sprintf(
                    'Class "%s" is declared "final" and cannot be mocked.',
                    $mockClassName['fullClassName']
                  )
                );
            }

            if ($class->hasMethod('__clone')) {
                $cloneMethod = $class->getMethod('__clone');

                if (!$cloneMethod->isFinal()) {
                    if ($callOriginalClone) {
                        $cloneTemplate = new PHPUnit_Util_Template($templateDir . 'unmocked_clone.tpl');
                    } else {
                        $cloneTemplate = new PHPUnit_Util_Template($templateDir . 'mocked_clone.tpl');
                    }
                }
            } else {
                $cloneTemplate = new PHPUnit_Util_Template($templateDir . 'mocked_clone.tpl');
            }
        }

        if (is_object($cloneTemplate)) {
            $cloneTemplate = $cloneTemplate->render();
        }

        if (is_array($methods) && empty($methods) && ($isClass || $isInterface)) {
            $methods = get_class_methods($originalClassName);
        }

        if (!is_array($methods)) {
            $methods = array();
        }

        $constructor   = NULL;
        $mockedMethods = '';

        if (isset($class)) {
            if ($class->hasMethod('__construct')) {
                $constructor = $class->getMethod('__construct');
            }

            else if ($class->hasMethod($originalClassName)) {
                $constructor = $class->getMethod($originalClassName);
            }

            foreach ($methods as $methodName) {
                try {
                    $method = $class->getMethod($methodName);

                    if (self::canMockMethod($method)) {
                        $mockedMethods .= self::generateMockedMethodDefinitionFromExisting(
                          $templateDir, $method
                        );
                    }
                }

                catch (ReflectionException $e) {
                    $mockedMethods .= self::generateMockedMethodDefinition(
                      $templateDir, $mockClassName['fullClassName'], $methodName
                    );
                }
            }
        } else {
            foreach ($methods as $methodName) {
                $mockedMethods .= self::generateMockedMethodDefinition(
                  $templateDir, $mockClassName['fullClassName'], $methodName
                );
            }
        }

        $classTemplate->setVar(
          array(
            'prologue'          => isset($prologue) ? $prologue : '',
            'class_declaration' => self::generateMockClassDeclaration(
                                     $mockClassName, $isInterface
                                   ),
            'clone'             => $cloneTemplate,
            'mocked_methods'    => $mockedMethods
          )
        );

        return array(
          'code'          => $classTemplate->render(),
          'mockClassName' => $mockClassName['mockClassName']
        );
    }

}

/* EOF */