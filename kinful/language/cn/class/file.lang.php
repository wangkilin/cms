<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : file.lang.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-1-26
 *@Homepage	: http://www.kinful.com
 *@Version	: 0.1
 */
defined('Kinful') or die("forbidden");
global $My_Lang;
$My_Lang->class['file']['notSetFileHandle']	=	"You have not set file handler";

$My_Lang->class['file']["noPermSetCwd"]		=	"You don't have permission set this path as your work dir";

$My_Lang->class['file']["lockFileFailed"]	=	"Failed to lock file";

$My_Lang->class['file']["writeFileFailed"]	=	"Failed to write string into file";

$My_Lang->class['file']["noPermSetRootPath"]=	"You do not have permission to set such root path";

$My_Lang->class['file']["fileNameIsInvalid"]=	"You set wrong file name.";

$My_Lang->class['file']["fileNotExists"]	=	"The file you specified does not exist.";

$My_Lang->class['file']["wrongMode"]		=	"You set wrong opening file mode. (\"r\", \"r+\", \"w\", \"w+\", \"a\", \"a+\", \"x\", \"x+\")  can be accept";

$My_Lang->class['file']["openFileFailed"]	=	"Failed to open file";

$My_Lang->class['file']["fileExists"]		=	"File already exists.";

$My_Lang->class['file']["createFileFailed"]	=	"Failed to create file";

$My_Lang->class['file']["getFileContentFailed"]="Fialed to read file";

$My_Lang->class['file']["dirNameIsInvalid"]	=	"The dir name is invalid";

$My_Lang->class['file']["wrongDirMode"]		=	"You set wrong dir mode.";

$My_Lang->class['file']["createDirFailed"]	=	"Please check if dir is writable. Failed to create dir";

$My_Lang->class['file']["noSuchDir"]		=	"there are no such dir name";

$My_Lang->class['file']["readDirFailed"]	=	"Failed to read dir";
?>
