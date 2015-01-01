#!/usr/bin/perl
# Fast script to get all test methods in a PHP test class.
# It returns only methods that are not inside comment blocks.
#
# Syntax: getTests.pl fileName.php [testPrefix]
#
# Without testPrefix will return all public methods
#
# $Rev$
#
# $LastChangedDate$
#
# $LastChangedBy$
#
# @author Radu GASLER <rgasler@streamwide.ro>
# @copyright 2008 Streamwide SAS
# @package Convergence
# @subpackage Tools
# @version 1.0
#

my ($fileName, $testPrefix) = @ARGV;

open my ($FILE), "<", $fileName or die 'Cannot open ' . $fileName .' for reading';

$comment = 0;

while(<$FILE>) {
    # manage /* */ comments
    if (/\/\*/ || /\*\//) {
        # string ends with /* or */
        $comment = (rindex($_, '/*') > rindex($_, '*/'));
    }

    # must be a public function
    if (!$comment) {
        if (/^\s*public function ($testPrefix\w*)/ or /^\s*function ($testPrefix\w*)/) {
            print $1 . "\n";
        }
    }
}

#EOF#