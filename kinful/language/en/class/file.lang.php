<?php
/********************************************************/
/*****                 @!!@                          ****/
/********************************************************/
/**
 *@FileName : file.lang.php
 *@Author	: WangKilin
 *@Email	: wangkilin@126.com
 *@Date		: 2007-1-26
 *@Homepage	: http://www.yeaheasy.com
 *@Version	: 0.1
 */
defined('YeahEasy') or die("forbidden");
global $YE_lang;
$YE_lang->class['file']['notSetFileHandle']	=	"You have not set file handler";

$YE_lang->class['file']["noPermSetCwd"]		=	"You don't have permission set this path as your work dir";

$YE_lang->class['file']["lockFileFailed"]	=	"Failed to lock file";

$YE_lang->class['file']["writeFileFailed"]	=	"Failed to write string into file";

$YE_lang->class['file']["noPermSetRootPath"]=	"You do not have permission to set such root path";

$YE_lang->class['file']["fileNameIsInvalid"]=	"You set wrong file name.";

$YE_lang->class['file']["fileNotExists"]	=	"The file you specified does not exist.";

$YE_lang->class['file']["wrongMode"]		=	"You set wrong opening file mode. (\"r\", \"r+\", \"w\", \"w+\", \"a\", \"a+\", \"x\", \"x+\")  can be accept";

$YE_lang->class['file']["openFileFailed"]	=	"Failed to open file";

$YE_lang->class['file']["fileExists"]		=	"File already exists.";

$YE_lang->class['file']["createFileFailed"]	=	"Failed to create file";

$YE_lang->class['file']["getFileContentFailed"]="Fialed to read file";

$YE_lang->class['file']["dirNameIsInvalid"]	=	"The dir name is invalid";

$YE_lang->class['file']["wrongDirMode"]		=	"You set wrong dir mode.";

$YE_lang->class['file']["createDirFailed"]	=	"Please check if dir is writable. Failed to create dir";

$YE_lang->class['file']["noSuchDir"]		=	"there are no such dir name";

$YE_lang->class['file']["readDirFailed"]	=	"Failed to read dir";
?>
