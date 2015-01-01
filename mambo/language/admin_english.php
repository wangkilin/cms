<?php
/**
* @version $Id: admin_english.php,v 1.30 2004/10/13 09:07:52 dappa Exp $
* @package adminLanguage 1.0
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

DEFINE('_A_CANCEL','Cancel'); // needed for $alt text in toolbar item
DEFINE('_A_SAVE','Save'); // needed for $alt text in toolbar item

/**
* @location /../includes/mambo.php
* @desc Includes translations of several droplists and non-translated stuff
*/

//Droplist
DEFINE('_A_TOP','Top');
DEFINE('_A_ALL','All');
DEFINE('_A_NONE','None');
DEFINE('_A_SELECT_IMAGE','Select Image');
DEFINE('_A_NO_USER','No User');
DEFINE('_A_CREATE_CAT','You must create a category first');
DEFINE('_A_PARENT_BROWSER_NAV','Parent Window With Browser Navigation');
DEFINE('_A_NEW_BROWSER_NAV','New Window With Browser Navigation');
DEFINE('_A_NEW_W_BROWSER_NAV','New Window Without Browser Navigation');

//Main Texts
DEFINE('_A_PUBLISHED_PEND','Published, but is <u>Pending</u>');
DEFINE('_A_PUBLISHED_CURRENT','Published and is <u>Current</u>');
DEFINE('_A_PUBLISHED_EXPIRED','Published, but has <u>Expired</u>');
DEFINE('_A_PUBLISHED_NOT','Not Published');
DEFINE('_A_TOGGLE_STATE','Click on icon to toggle state.');

//Alt Hover
DEFINE('_A_PENDING','Pending');
DEFINE('_A_VISIBLE','Visible');
DEFINE('_A_FINISHED','Finished');

/**
* @desc Includes the main adminLanguage class which refers to var's for translations
*/
class adminLanguage {

//templates/mambo_admin_blue/login.php
var $A_USERNAME = 'Username';
var $A_PASSWORD = 'Password';
var $A_WELCOME_MAMBO = '<p>Welcome to Mambo!</p><p>Use a valid username and password to gain access to the administration console.</p>';
var $A_WARNING_JAVASCRIPT = '!Warning! Javascript must be enabled for proper operation of the Administrator';

//templates/mambo_admin_blue/index.php
var $A_GENERATE_TIME = 'Page was generated in %f seconds';
var $A_LOGOUT = 'Logout';

//popups/contentwindow.php
var $A_TITLE_CPRE = 'Content Preview';
var $A_CLOSE = 'Close';
var $A_PRINT = 'Print';

//popups/modulewindow.php
var $A_TITLE_MPRE = 'Module Preview';

//popups/pollwindow.php
var $A_TITLE_PPRE = 'Poll Preview';
var $A_VOTE = 'Vote';
var $A_RESULTS = 'Results';

//popups/uploadimage.php
var $A_TITLE_UPLOAD = 'Upload a file';
var $A_FILE_UPLOAD = 'File Upload';
var $A_UPLOAD = 'Upload';

//modules/mod_components.php
var $A_ERROR = 'Error!';

//modules/mod_fullmenu.php
var $A_MENU_HOME = 'Home';
var $A_MENU_HOME_PAGE = 'Home Page';
var $A_MENU_SITE = 'Site';
var $A_MENU_CONFIGURATION = 'Configuration';
var $A_MENU_LANGUAGES = 'Languages';
var $A_MENU_MANAGE_LANG = 'Manage Languages';
var $A_MENU_LANG_MANAGE = 'Language Manager';
var $A_MENU_INSTALL = 'Install';
var $A_MENU_INSTALL_LANG = 'Install Languages';
var $A_MENU_MEDIA_MANAGE = 'Media Manager';
var $A_MENU_MANAGE_MEDIA = 'Manage Media Files';
var $A_MENU_PREVIEW = 'Preview';
var $A_MENU_NEW_WINDOW = 'In New Window';
var $A_MENU_INLINE = 'Inline';
var $A_MENU_INLINE_POS = 'Inline with Positions';
var $A_MENU_STATISTICS = 'Statistics';
var $A_MENU_STATISTICS_SITE = 'Site Statistics';
var $A_MENU_BROWSER = 'Browser, OS, Domain';
var $A_MENU_PAGE_IMP = 'Page Impressions';
var $A_MENU_SEARCH_TEXT = 'Search Text';
var $A_MENU_TEMP_MANAGE = 'Template Manager';
var $A_MENU_TEMP_CHANGE = 'Change site template';
var $A_MENU_SITE_TEMP = 'Site Templates';
var $A_MENU_ADMIN_TEMP = 'Administrator Templates';
var $A_MENU_ADMIN_CHANGE_TEMP = 'Change admin template';
var $A_MENU_MODUL_POS = 'Module Positions';
var $A_MENU_TEMP_POS = 'Template Positions';
var $A_MENU_TRASH_MANAGE = 'Trash Manager';
var $A_MENU_MANAGE_TRASH = 'Manage trash';
var $A_MENU_USER_MANAGE = 'User Manager';
var $A_MENU_MANAGE_USER = 'Manage users';
var $A_MENU_ADD_EDIT = 'Add/Edit Users';
var $A_MENU_MASS_MAIL = 'Mass Mail';
var $A_MENU_MAIL_USERS = 'Send an e-mail to a register user group';
var $A_MENU_MANAGE_STR = 'Manage Site Structure';
var $A_MENU_CONTENT = 'Content';
var $A_MENU_CONTENT_MANAGE = 'Content Management';
var $A_MENU_CONTENT_MANAGERS = 'Content Managers';
var $A_MENU_MANAGE_CONTENT = 'Manage Content Items';
var $A_MENU_ITEMS = 'Items';
var $A_MENU_ADDNEDIT = 'Add/Edit';
var $A_MENU_ARCHIVE = 'Archive';
var $A_MENU_OTHER_MANAGE = 'Other Managers';
var $A_MENU_ITEMS_FRONT = 'Manage Frontpage Items';
var $A_MENU_ITEMS_CONTENT = 'Manage Typed Content Items';
var $A_MENU_ITEMS_ARCHIVE = 'Manage Archive Items';
var $A_MENU_ARCHIVE_MANAGE = 'Archive Manager';
var $A_MENU_CONTENT_SEC = 'Manage Content Sections';
var $A_MENU_CONTENT_CAT = 'Manage Content Categories';
var $A_MENU_COMPONENTS = 'Components';
var $A_MENU_INST_UNST = 'Install/Uninstall';
var $A_MENU_MORE_COMP = 'More Components';
var $A_MENU_MODULES = 'Modules';
var $A_MENU_INSTALL_CUST = 'Install custom modules';
var $A_MENU_SITE_MOD = 'Site Modules';
var $A_MENU_SITE_MOD_MANAGE = 'Manage Site modules';
var $A_MENU_ADMIN_MOD = 'Administrator Modules';
var $A_MENU_ADMIN_MOD_MANAGE = 'Manage Administrator modules';
var $A_MENU_MAMBOTS = 'Mambots';
var $A_MENU_CUSTOM_MAMBOT = 'Install custom mambot';
var $A_MENU_SITE_MAMBOTS = 'Site Mambots';
var $A_MENU_MAMBOT_MANAGE = 'Manage Site Mambots';
var $A_MENU_MESSAGES = 'Messages';
var $A_MENU_INBOX = 'Inbox';
var $A_MENU_PRIV_MSG = 'Private Messages';
var $A_MENU_GLOBAL_CHECK = 'Global Checkin';
var $A_MENU_CHECK_INOUT = 'Check-in all checked-out items';
var $A_MENU_SYSTEM_INFO = 'System Info';
var $A_MENU_CLEAN_CACHE = 'Clean Cache';
var $A_MENU_CLEAN_CACHE_ITEMS = 'Clean the content items cache';
var $A_MENU_BIG_THANKS = 'A big thanks to those involved';
var $A_MENU_SUPPORT = 'Support';
var $A_MENU_SYSTEM = 'System';

//modules/mod_latest.php
var $A_LATEST_ADDED = 'Most Recently Added Content';

//modules/mod_online.php
var $A_ONLINE_USERS = 'Users Online';

//modules/mod_popular.php
var $A_POPULAR_MOST = 'Most Popular Items';
var $A_CREATED = 'Created';
var $A_HITS = 'Hits';

//modules/mod_quickicon.php
var $A_MENU_MANAGER = 'Menu Manager';
var $A_FRONTPAGE_MANAGER = 'Frontpage Manager';
var $A_STATIC_MANAGER = 'Static Content Manager';
var $A_SECTION_MANAGER = 'Section Manager';
var $A_CATEGORY_MANAGER = 'Category Manager';
var $A_ALL_MANAGER = 'All Content Items';
var $A_TRASH_MANAGER = 'Trash Manager';
var $A_GLOBAL_CONF = 'Global Configuration';
var $A_HELP = 'Help';

//includes/menubar.html.php
var $A_NEW = 'New';
var $A_PUBLISH = 'Publish';
var $A_DEFAULT = 'Default';
var $A_ASSIGN = 'Assign';
var $A_UNPUBLISH = 'Unpublish';
var $A_UNARCHIVE = 'Unarchive';
var $A_EDIT = 'Edit';
var $A_DELETE = 'Delete';
var $A_TRASH = 'Trash';
var $A_SAVE = 'Save';
var $A_BACK = 'Back';
var $A_CANCEL = 'Cancel';

//Alerts
var $A_ALERT_SELECT_TO = 'Please make a selection from the list to';
var $A_ALERT_SELECT_PUB = 'Please make a selection from the list to publish';
var $A_ALERT_SELECT_PUB_LIST = 'Please select an item to make default';
var $A_ALERT_ITEM_ASSIGN = 'Please select an item to assign';
var $A_ALERT_SELECT_UNPUBLISH = 'Please make a selection from the list to unpublish';
var $A_ALERT_SELECT_ARCHIVE = 'Please make a selection from the list to archive';
var $A_ALERT_SELECT_UNARCHIVE = 'Please select a news story to unarchive';
var $A_ALERT_SELECT_EDIT = 'Please select an item from the list to edit';
var $A_ALERT_SELECT_DELETE = 'Please make a selection from the list to delete';
var $A_ALERT_CONFIRM_DELETE = 'Are you sure you want to delete selected items?';

//Alerts
var $A_ALERT_ENTER_PASSWORD = 'Please enter a password'; 
var $A_ALERT_INCORRECT = 'Incorrect Username, Password, or Access Level.  Please try again';
var $A_ALERT_INCORRECT_TRY = 'Incorrect Username and Password, please try again';
var $A_ALERT_ALPHA = 'File must only contain alphanumeric characters and no spaces please.';
var $A_ALERT_IMAGE_UPLOAD = 'Please select an image to upload';
var $A_ALERT_IMAGE_EXISTS = 'Image $userfile_name already exists.';
var $A_ALERT_IMAGE_FILENAME = 'The file must be gif, png, jpg, bmp, swf, doc, xls or ppt';
var $A_ALERT_UPLOAD_FAILED = 'Upload of $userfile_name failed';
var $A_ALERT_UPLOAD_SUC = 'Upload of $userfile_name to $media_path successful';
var $A_ALERT_UPLOAD_SUC2 = 'Upload of $userfile_name to $base_Dir successful';

//includes/pageNavigation.php
var $A_OF = 'of'; 
var $A_NO_RECORD_FOUND = 'No records found';
var $A_FIRST_PAGE = 'first page';
var $A_PREVIOUS_PAGE = 'previous page';
var $A_NEXT_PAGE = 'next page';
var $A_END_PAGE = 'end page';
var $A_PREVIOUS = 'Previous';
var $A_NEXT = 'Next';
var $A_END = 'End';
var $A_DISPLAY = 'Display';
var $A_MOVE_UP = 'Move Up';
var $A_MOVE_DOWN = 'Move Down';

//DIRECTORY COMPONENTS ALL FILES
var $A_COMP_CHECKED_OUT = 'Checked Out';
var $A_COMP_TITLE = 'Title';
var $A_COMP_IMAGE = 'Image';
var $A_COMP_FRONT_PAGE = 'Front Page';
var $A_COMP_IMAGE_POSITION = 'Image Position';
var $A_COMP_FILTER = 'Filter';
var $A_COMP_ORDERING = 'Ordering';
var $A_COMP_ACCESS_LEVEL = 'Access Level';
var $A_COMP_PUBLISHED = 'Published';
var $A_COMP_UNPUBLISHED = 'UnPublished';
var $A_COMP_REORDER = 'Reorder';
var $A_COMP_ACCESS = 'Access';
var $A_COMP_SECTION = 'Section';
var $A_COMP_NB = '#';
var $A_COMP_ACTIVE = '# Active';
var $A_COMP_TRASH = '# Trash';
var $A_COMP_DESCRIPTION = 'Description';
var $A_COMP_SELECT_MENU_TYPE = 'Please select a menu type';
var $A_COMP_ENTER_MENU_NAME = 'Please enter a Name for this menu item';
var $A_COMP_CREATE_MENU_LINK = 'Are you sure you want to create a menu link? \nAny unsaved changes to this content will be lost.';
var $A_COMP_LINK_TO_MENU = 'Link to Menu';
var $A_COMP_CREATE_MENU = 'This will create a new menu item in the menu you select';
var $A_COMP_SELECT_MENU = 'Select a Menu';
var $A_COMP_MENU_TYPE_SELECT = 'Select Menu Type';
var $A_COMP_MENU_NAME_ITEM = 'Menu Item Name';
var $A_COMP_MENU_LINKS = 'Existing Menu Links';
var $A_COMP_NONE = 'None';
var $A_COMP_MENU = 'Menu';
var $A_COMP_TYPE = 'Type';
var $A_COMP_EDIT = 'Edit';
var $A_COMP_ADD = 'Add';
var $A_COMP_ITEM_NAME = 'Item Name';
var $A_COMP_STATE = 'State';
var $A_COMP_TRASHED = 'Trashed';
var $A_COMP_NAME = 'Name';
var $A_COMP_DEFAULT = 'Default';
var $A_COMP_CATEG = 'Category';
var $A_COMP_LINK_USER = 'Linked to User';
var $A_COMP_CONTACT = 'Contact';
var $A_COMP_EMAIL = 'E-mail';
var $A_COMP_PREVIEW = 'Preview';
var $A_COMP_ITEMS = 'items';
var $A_COMP_ID = 'ID';
var $A_COMP_EXPIRED = 'Expired';
var $A_COMP_YES = 'Yes';
var $A_COMP_NO = 'No';
var $A_COMP_EDITING = 'Editing';
var $A_COMP_ADDING = 'Adding';
var $A_COMP_ARCHIVED = 'Archived';
var $A_COMP_HITS = 'Hits';
var $A_COMP_SOURCE = 'Source';
var $A_COMP_SEL_ITEM = 'Select an item to';
var $A_COMP_DATE = 'Date';
var $A_COMP_AUTHOR = 'Author';
var $A_COMP_ANOTHER_ADMIN = 'is currently being edited by another administrator';

//components/com_admin/admin.admin.html.php
var $A_COMP_ADMIN_TITLE = 'Control Panel';
var $A_COMP_ADMIN_INFO = 'Information';
var $A_COMP_ADMIN_SYSTEM = 'System Information';
var $A_COMP_ADMIN_PHP_BUILT_ON = 'PHP built On:';
var $A_COMP_ADMIN_DB = 'Database Version:';
var $A_COMP_ADMIN_PHP_VERSION = 'PHP Version:';
var $A_COMP_ADMIN_SERVER = 'Web Server:';
var $A_COMP_ADMIN_SERVER_TO_PHP = 'WebServer to PHP interface:';
var $A_COMP_ADMIN_AGENT = 'User Agent:';
var $A_COMP_ADMIN_SETTINGS = 'Relevant PHP Settings:';
var $A_COMP_ADMIN_MODE = 'Safe Mode:';
var $A_COMP_ADMIN_BASEDIR = 'Open basedir:';
var $A_COMP_ADMIN_ERRORS = 'Display Errors:';
var $A_COMP_ADMIN_OPEN_TAGS = 'Short Open Tags:';
var $A_COMP_ADMIN_FILE_UPLOADS = 'File Uploads:';
var $A_COMP_ADMIN_QUOTES = 'Magic Quotes:';
var $A_COMP_ADMIN_REG_GLOBALS = 'Register Globals:';
var $A_COMP_ADMIN_OUTPUT_BUFF = 'Output Buffering:';
var $A_COMP_ADMIN_S_SAVE_PATH = 'Session save path:';
var $A_COMP_ADMIN_S_AUTO_START = 'Session auto start:';
var $A_COMP_ADMIN_XML = 'XML enabled:';
var $A_COMP_ADMIN_ZLIB = 'Zlib enabled:';
var $A_COMP_ADMIN_DISABLED = 'Disabled Functions:';
var $A_COMP_ADMIN_WYSIWYG = 'WYSIWYG Editor:';
var $A_COMP_ADMIN_CONF_FILE = 'Configuration File:';
var $A_COMP_ADMIN_PHP_INFO = 'PHP Information';
var $A_COMP_ADMIN_DIR_PERM = 'Directory Permissions';
var $A_COMP_ADMIN_FOR_ALL = 'For all Mambo functions and features to work ALL of the following directories should be writeable:';
var $A_COMP_ADMIN_CREDITS = 'Credits';
var $A_COMP_ADMIN_APP = 'Application';
var $A_COMP_ADMIN_URL = 'URL';
var $A_COMP_ADMIN_VERSION = 'Version';
var $A_COMP_ADMIN_LICENSE = 'License';
var $A_COMP_ADMIN_CALENDAR = 'Calendar';
var $A_COMP_ADMIN_PUB_DOMAIN = 'Public Domain';
var $A_COMP_ADMIN_ICONS = 'Icons';
var $A_COMP_ADMIN_INDEX = 'Index';
var $A_COMP_ADMIN_OPEN_NEW_WIN = 'Open in new window';

//components/com_admin/admin.admin.php
var $A_COMP_ALERT_NO_LINK = 'There is no link associated with this item';

//components/com_banners/admin.banners.html.php
var $A_COMP_BANNERS_MANAGER = 'Banner Manager';
var $A_COMP_BANNERS_NAME = 'Banner Name';
var $A_COMP_BANNERS_IMPRESS_MADE = 'Impressions Made';
var $A_COMP_BANNERS_IMPRESS_LEFT = 'Impressions Left';
var $A_COMP_BANNERS_CLICKS = 'Clicks';
var $A_COMP_BANNERS_CLICKS2 = '% Clicks';
var $A_COMP_BANNERS_PUBLISHED = 'Published';
var $A_COMP_BANNERS_LOCK = 'Checked Out';
var $A_COMP_BANNERS_PROVIDE = 'You must provide a banner name.';
var $A_COMP_BANNERS_SELECT_IMAGE = 'Please select an image.';
var $A_COMP_BANNERS_FILL_URL = 'Please fill in the URL for the banner.';
var $A_COMP_BANNERS_BANNER = 'Banner';
var $A_COMP_BANNERS_CLIENT = 'Client Name';
var $A_COMP_BANNERS_PURCHASED = 'Impressions Purchased:';
var $A_COMP_BANNERS_UNLIMITED = 'Unlimited';
var $A_COMP_BANNERS_URL = 'Banner URL:';
var $A_COMP_BANNERS_SHOW = 'Show Banner:';
var $A_COMP_BANNERS_CLICK_URL = 'Click URL:';
var $A_COMP_BANNERS_CUSTOM = 'Custom banner code:';
var $A_COMP_BANNERS_IMAGE = 'Banner Image:';
var $A_COMP_BANNERS_CLIENT_MANAGER = 'Banner Client Manager';
var $A_COMP_BANNERS_NO_ACTIVE = 'No. of Active Banners';
var $A_COMP_BANNERS_FILL_CL_NAME = 'Please fill in the Client Name.';
var $A_COMP_BANNERS_FILL_CO_NAME = 'Please fill in the Contact Name.';
var $A_COMP_BANNERS_FILL_CO_EMAIL = 'Please fill in the Contact Email.';
var $A_COMP_BANNERS_TITLE_CLIENT = 'Banner Client';
var $A_COMP_BANNERS_CONTACT_NAME = 'Contact Name';
var $A_COMP_BANNERS_CONTACT_EMAIL = 'Contact Email';
var $A_COMP_BANNERS_EXTRA = 'Extra Info';

//components/com_banners/admin.banners.php
var $A_COMP_BANNERS_SELECT_CLIENT = 'Select Client';
var $A_COMP_BANNERS_COMP = 'The component';
var $A_COMP_BANNERS_EDITED = 'is currently being edited by another administrator.';
var $A_COMP_BANNERS_DEL_CLIENT = 'Cannot delete client at this time as they have a banner still running';

//components/com_categories/admin.categories.html.php
var $A_COMP_CATEG_MANAGER = 'Category Manager';
var $A_COMP_CATEG_CATEGS = 'Categories';
var $A_COMP_CATEG_NAME = 'Category Name';
var $A_COMP_CATEG_ID = 'Category ID';
var $A_COMP_CATEG_MUST_NAME = 'Category must have a name';
var $A_COMP_CATEG_DETAILS = 'Category Details';
var $A_COMP_CATEG_TITLE = 'Category Title:';
var $A_COMP_CATEG_TABLE = 'Category Table';
var $A_COMP_CATEG_BLOG = 'Category Blog';
var $A_COMP_CATEG_BLOG_ARCHIVE = 'Category Archive Blog';
var $A_COMP_CATEG_MESSAGE = 'The category';
var $A_COMP_CATEG_MESSAGE2 = 'is currently being edited by another administrator';
var $A_COMP_CATEG_MOVE = 'Move Category';
var $A_COMP_CATEG_MOVE_TO_SECTION = 'Move to Section';
var $A_COMP_CATEG_BEING_MOVED = 'Categories being moved';
var $A_COMP_CATEG_CONTENT = 'Content Items being moved';
var $A_COMP_CATEG_MOVE_CATEG = 'This will move the Categories listed';
var $A_COMP_CATEG_ALL_ITEMS = 'and all the items within the category (also listed)';
var $A_COMP_CATEG_TO_SECTION = 'to the selected Section.';
var $A_COMP_CATEG_COPY = 'Copy Category';
var $A_COMP_CATEG_COPY_TO_SECTION = 'Copy to Section';
var $A_COMP_CATEG_BEING_COPIED = 'Categories being copied';
var $A_COMP_CATEG_ITEMS_COPIED = 'Content Items being copied';
var $A_COMP_CATEG_COPY_CATEGS = 'This will copy the Categories listed';

//components/com_categories/admin.categories.php
var $A_COMP_CATEG_DELETE = 'Select a category to delete';
var $A_COMP_CATEG_CATEG_S = 'Category(s)';
var $A_COMP_CATEG_CANNOT_REMOVE = 'cannot be removed as they contain records';
var $A_COMP_CATEG_SELECT = 'Select a category to';
var $A_COMP_CATEG_ITEM_MOVE = 'Select an item to move';
var $A_COMP_CATEG_MOVED_TO = 'Categories moved to';
var $A_COMP_CATEG_COPY_OF = 'Copy of';
var $A_COMP_CATEG_COPIED_TO = 'Categories copied to';
var $A_COMP_CATEG_SELECT_TYPE = 'Select Type';

//components/com_categories/admin.checkin.php
var $A_COMP_CHECK_TITLE = 'Global Check-in';
var $A_COMP_CHECK_DB_T = 'Database Table';
var $A_COMP_CHECK_NB_ITEMS = '# of Items';
var $A_COMP_CHECK_IN = 'Checked-In';
var $A_COMP_CHECK_TABLE = 'Checking table';
var $A_COMP_CHECK_DONE = 'Checked out items have now been all checked in';

//components/com_categories/admin.config.html.php
var $A_COMP_CONF_GC = 'Global Configuration';
var $A_COMP_CONF_IS = 'is';
var $A_COMP_CONF_WRT = 'Writeable';
var $A_COMP_CONF_UNWRT = 'Unwriteable';
//var $A_COMP_CONF_SITE_PAGE = 'site-page';
var $A_COMP_CONF_OFFLINE = 'Site Offline';
var $A_COMP_CONF_OFFMESSAGE = 'Offline Message';
var $A_COMP_CONF_ERR_MESSAGE = 'System Error Message';
var $A_COMP_CONF_SITE_NAME = 'Site Name';
var $A_COMP_CONF_UN_LINKS = 'Show UnAuthorized Links';
var $A_COMP_CONF_USER_REG = 'Allow User Registration';
var $A_COMP_CONF_AC_ACT = 'Use New Account Activation';
var $A_COMP_CONF_REQ_EMAIL = 'Require Unique Email';
var $A_COMP_CONF_DEBUG = 'Debug Site';
var $A_COMP_CONF_EDITOR = 'WYSIWYG Editor';
var $A_COMP_CONF_LENGTH = 'List Length';
//var $A_COMP_CONF_LOCAL_PG = 'Locale-page';
var $A_COMP_CONF_LOCALE = 'Locale';
var $A_COMP_CONF_LANG = 'Frontend Language';
var $A_COMP_CONF_ALANG = 'Backend Language';
var $A_COMP_CONF_TIME_SET = 'Time Offset';
var $A_COMP_CONF_DATE = 'Current date/time configured to display';
var $A_COMP_CONF_LOCAL = 'Country Locale';
//var $A_COMP_CONF_CONT_PAGE = 'content-page';
var $A_COMP_CONF_CONTROL = '* These Parameters control Output elments *';
var $A_COMP_CONF_LINK_TITLES = 'Linked Titles';
var $A_COMP_CONF_MORE_LINK = 'Read More Link';
var $A_COMP_CONF_RATE_VOTE = 'Item Rating/Voting';
var $A_COMP_CONF_AUTHOR = 'Author Names';
var $A_COMP_CONF_CREATED = 'Created Date and Time';
var $A_COMP_CONF_MOD_DATE = 'Modified Date and Time';
var $A_COMP_CONF_HITS = 'Hits';
var $A_COMP_CONF_PDF = 'PDF Icon';
var $A_COMP_CONF_OPT_MEDIA = 'Option not available as /media directory not writable';
var $A_COMP_CONF_PRINT_ICON = 'Print Icon';
var $A_COMP_CONF_EMAIL_ICON = 'Email Icon';
var $A_COMP_CONF_ICONS = 'Icons';
var $A_COMP_CONF_USE_OR_TEXT = 'Print, PDF & Email will utilise Icons or Text';
var $A_COMP_CONF_TBL_CONTENTS = 'Table of Contents on multi-page items';
var $A_COMP_CONF_BACK_BUTTON = 'Back Button';
var $A_COMP_CONF_CONTENT_NAV = 'Content Item Navigation';
var $A_COMP_CONF_HYPER = 'Use hyperlinked titles';
//var $A_COMP_CONF_DB_PAGE = 'db-page';
var $A_COMP_CONF_HOSTNAME = 'Hostname';
var $A_COMP_CONF_DB_USERNAME = 'Username';
var $A_COMP_CONF_DB_PW = 'Password';
var $A_COMP_CONF_DB_NAME = 'Database';
var $A_COMP_CONF_DB_PREFIX = 'Database Prefix';
var $A_COMP_CONF_NOT_CH = '!! DO NOT CHANGE UNLESS YOU HAVE A DATABASE BUILT USING TABLES WITH THE PREFIX YOU ARE SETTING !!';
//Svar $A_COMP_CONF_S_PAGE = 'server-page';
var $A_COMP_CONF_ABS_PATH = 'Absolute Path';
var $A_COMP_CONF_LIVE = 'Live Site';
var $A_COMP_CONF_SECRET = 'Secret Word';
var $A_COMP_CONF_GZIP = 'GZIP Page Compression';
var $A_COMP_CONF_CP_BUFFER = 'Compress buffered output if supported';
var $A_COMP_CONF_SESSION_TIME = 'Login Session Lifetime';
var $A_COMP_CONF_SEC = 'seconds';
var $A_COMP_CONF_AUTO_LOGOUT = 'Auto logout after this time of inactivity';
var $A_COMP_CONF_ERR_REPORT = 'Error Reporting';
var $A_COMP_CONF_META_PAGE = 'metadata-page';
var $A_COMP_CONF_META_DESC = 'Global Site Meta Description';
var $A_COMP_CONF_META_KEY = 'Global Site Meta Keywords';
var $A_COMP_CONF_META_TITLE = 'Show Title Meta Tag';
var $A_COMP_CONF_META_ITEMS = 'Show the title meta tag when viewing content items';
var $A_COMP_CONF_META_AUTHOR = 'Show Author Meta Tag';
//var $A_COMP_CONF_MAIL_PAGE = 'mail-page';
var $A_COMP_CONF_MAIL = 'Mailer';
var $A_COMP_CONF_MAIL_FROM = 'Mail From';
var $A_COMP_CONF_MAIL_FROM_NAME = 'From Name';
var $A_COMP_CONF_MAIL_SMTP_AUTH = 'SMTP Auth';
var $A_COMP_CONF_MAIL_SMTP_USER = 'SMTP User';
var $A_COMP_CONF_MAIL_SMTP_PASS = 'SMTP Pass';
var $A_COMP_CONF_MAIL_SMTP_HOST = 'SMTP Host';
//var $A_COMP_CONF_CACHE_PAGE = 'cache-page';
var $A_COMP_CONF_CACHE = 'Caching';
var $A_COMP_CONF_CACHE_FOLDER = 'Cache Folder';
var $A_COMP_CONF_CACHE_DIR = 'Current cache is directory is';
var $A_COMP_CONF_CACHE_DIR_UNWRT = 'The cache directory is UNWRITEABLE - please set this directory to CHMOD755 before turning on the cache';
var $A_COMP_CONF_CACHE_TIME = 'Cache Time';
//var $A_COMP_CONF_STATS_PAGE = 'stats-page';
var $A_COMP_CONF_STATS = 'Statistics';
var $A_COMP_CONF_STATS_ENABLE = 'Enable/disable collection of site statistics';
var $A_COMP_CONF_STATS_LOG_HITS = 'Log Content Hits by Date';
var $A_COMP_CONF_STATS_WARN_DATA = 'WARNING : Large amounts of data will be collected';
var $A_COMP_CONF_STATS_LOG_SEARCH = 'Log Search Strings';
//var $A_COMP_CONF_SEO_PAGE = 'seo-page';
var $A_COMP_CONF_SEO_LBL = 'SEO';
var $A_COMP_CONF_SEO = 'Search Engine Optimization';
var $A_COMP_CONF_SEO_SEFU = 'Search Engine Friendly URLs';
var $A_COMP_CONF_SEO_APACHE = 'Apache only! Rename htaccess.txt to .htaccess before activating';
var $A_COMP_CONF_SEO_DYN = 'Dynamic Page Titles';
var $A_COMP_CONF_SEO_DYN_TITLE = 'Dynamically changes the page title to reflect current content viewed';
var $A_COMP_CONF_SERVER = 'Server';
var $A_COMP_CONF_METADATA = 'Metadata';
var $A_COMP_CONF_EMAIL = 'Mail';
var $A_COMP_CONF_CACHE_TAB = 'Cache';

//components/com_categories/admin.config.php
var $A_COMP_CONF_HIDE = 'Hide';
var $A_COMP_CONF_SHOW = 'Show';
var $A_COMP_CONF_DEFAULT = 'System Default';
var $A_COMP_CONF_NONE = 'None';
var $A_COMP_CONF_SIMPLE = 'Simple';
var $A_COMP_CONF_MAX = 'Maximum';
var $A_COMP_CONF_MAIL_FC = 'PHP mail function';
var $A_COMP_CONF_SEND = 'Sendmail';
var $A_COMP_CONF_SMTP = 'SMTP Server';
var $A_COMP_CONF_UPDATED = 'The configuration details have been updated!';
var $A_COMP_CONF_ERR_OCC = 'An Error Has Occurred! Unable to open config file to write!';

//components/com_categories/admin.contact.html.php
var $A_COMP_CONT_MANAGER = 'Contact Manager';
var $A_COMP_CONT_FILTER = 'Filter';
var $A_COMP_CONT_YOUR_NAME = 'You must provide a name.';
var $A_COMP_CONT_CATEG = 'Please select a Category.';
var $A_COMP_CONT_DETAILS = 'Contact Details';
var $A_COMP_CONT_POSITION = 'Contact\'s Position';
var $A_COMP_CONT_ADDRESS = 'Street Address';
var $A_COMP_CONT_TOWN = 'Town/Suburb';
var $A_COMP_CONT_STATE = 'State/County';
var $A_COMP_CONT_COUNTRY = 'Country';
var $A_COMP_CONT_POSTAL_CODE = 'Postal Code/ZIP';
var $A_COMP_CONT_TEL = 'Telephone';
var $A_COMP_CONT_FAX = 'Fax';
var $A_COMP_CONT_INFO = 'Miscellaneous Info';
//var $A_COMP_CONT_PUBLISH = 'publish-page';
var $A_COMP_CONT_PUBLISHING = 'Publishing Info';
var $A_COMP_CONT_SITE_DEFAULT = 'Site Default';
//var $A_COMP_CONT_IMG_PAGE = 'images-page';
var $A_COMP_CONT_IMG_INFO = 'Image Info';
var $A_COMP_CONT_PARAMS = 'params-page';
var $A_COMP_CONT_PARAMETERS = 'Parameters';
var $A_COMP_CONT_PARAM_MESS = '* These Parameters only control what you see when you click to view a Contact item *';
var $A_COMP_CONT_PUB_TAB = 'Publishing';
var $A_COMP_CONT_IMG_TAB = 'Images';

//components/com_categories/admin.contact.php
var $A_COMP_CONT_SELECT_REC = 'Select a record to';

//components/com_categories/admin.content.html.php
var $A_COMP_CONTENT_ALL_ITEMS = 'All Content Items';
var $A_COMP_CONTENT_START_ALWAYS = 'Start: Always';
var $A_COMP_CONTENT_START = 'Start';
var $A_COMP_CONTENT_FIN_NOEXP = 'Finish: No Expiry';
var $A_COMP_CONTENT_FINISH = 'Finish';
var $A_COMP_CONTENT_PUBLISH_INFO = 'Publish Information';
var $A_COMP_CONTENT_TRASH = 'Please make a selection from the list to send to Trash';
var $A_COMP_CONTENT_TRASH_MESS = 'Are you sure you want to Trash the selected items? \nThis will not permanently delete the items.';
var $A_COMP_CONTENT_ARCHIVE = 'Archive';
var $A_COMP_CONTENT_MANAGER = 'Manager';
var $A_COMP_CONTENT_ZERO = 'Are you sure you want to reset the Hits to Zero? \nAny unsaved changes to this content will be lost.';
var $A_COMP_CONTENT_MUST_TITLE = 'Content item must have a title';
var $A_COMP_CONTENT_MUST_SECTION = 'You must select a Section.';
var $A_COMP_CONTENT_MUST_CATEG = 'You must select a Category.';
var $A_COMP_CONTENT_IN = 'content in';
var $A_COMP_CONTENT_TITLE_ALIAS = 'Title Alias';
var $A_COMP_CONTENT_ITEM_DETAILS = 'Item Details';
var $A_COMP_CONTENT_INTRO = 'Intro Text: (required)';
var $A_COMP_CONTENT_MAIN = 'Main Text: (optional)';
var $A_COMP_CONTENT_PUB_INFO = 'Publishing Info';
var $A_COMP_CONTENT_FRONTPAGE = 'Show on Frontpage';
var $A_COMP_CONTENT_AUTHOR = 'Author Alias';
var $A_COMP_CONTENT_CREATOR = 'Change Creator';
var $A_COMP_CONTENT_OVERRIDE = 'Override Created Date';
var $A_COMP_CONTENT_START_PUB = 'Start Publishing';
var $A_COMP_CONTENT_FINISH_PUB = 'Finish Publishing';
var $A_COMP_CONTENT_DRAFT_UNPUB = 'Draft Unpublished';
var $A_COMP_CONTENT_RESET_HIT = 'Reset Hit Count';
var $A_COMP_CONTENT_REVISED = 'Revised';
var $A_COMP_CONTENT_TIMES = 'times';
var $A_COMP_CONTENT_CREATED = 'Created';
var $A_COMP_CONTENT_BY = 'By';
var $A_COMP_CONTENT_NEW_DOC = 'New document';
var $A_COMP_CONTENT_LAST_MOD = 'Last Modified';
var $A_COMP_CONTENT_NOT_MOD = 'Not modified';
var $A_COMP_CONTENT_MOSIMAGE = 'MOSImage Control';
var $A_COMP_CONTENT_SUB_FOLDER = 'Sub-folder';
var $A_COMP_CONTENT_GALLERY = 'Gallery Images';
var $A_COMP_CONTENT_IMAGES = 'Content Images';
var $A_COMP_CONTENT_UP = 'up';
var $A_COMP_CONTENT_DOWN = 'down';
var $A_COMP_CONTENT_REMOVE = 'remove';
var $A_COMP_CONTENT_EDIT_IMAGE = 'Edit the image selected';
var $A_COMP_CONTENT_ALIGN = 'Align';
var $A_COMP_CONTENT_ALT = 'Alt Text';
var $A_COMP_CONTENT_BORDER = 'Border';
var $A_COMP_CONTENT_APPLY = 'Apply';
var $A_COMP_CONTENT_PARAM = 'Parameter Control';
var $A_COMP_CONTENT_PARAM_MESS = '* These Parameters only control what you see when you click to view an item fully *';
var $A_COMP_CONTENT_META_DATA = 'Meta Data';
var $A_COMP_CONTENT_KEYWORDS = 'Keywords';
//var $A_COMP_CONTENT_LINK_PAGE = 'link-page';
var $A_COMP_CONTENT_LINK_CI = 'This will create a \'Link - Content Item\' in the menu you select';
var $A_COMP_CONTENT_LINK_NAME = 'Link Name';
var $A_COMP_CONTENT_SOMETHING = 'Please select something';
var $A_COMP_CONTENT_MOVE_ITEMS = 'Move Items';
var $A_COMP_CONTENT_MOVE_SECCAT = 'Move to Section/Category';
var $A_COMP_CONTENT_ITEMS_MOVED = 'Items being Moved';
var $A_COMP_CONTENT_SECCAT = 'Please select a Section/Category to copy the items to';
var $A_COMP_CONTENT_COPY_ITEMS = 'Copy Content Items';
var $A_COMP_CONTENT_COPY_SECCAT = 'Copy to Section/Category';
var $A_COMP_CONTENT_ITEMS_COPIED = 'Items being copied';
var $A_COMP_CONTENT_PUBLISHING = 'Publishing';
var $A_COMP_CONTENT_IMAGES2 = 'Images';
var $A_COMP_CONTENT_META_INFO = 'Meta Info';
var $A_COMP_CONTENT_ADD_ETC = 'Add Sect/Cat/Title';
var $A_COMP_CONTENT_LINK_TO_MENU = 'Link to Menu';

//components/com_categories/admin.content.php
var $A_COMP_CONTENT_CACHE = 'Cache cleaned';
var $A_COMP_CONTENT_CANNOT = 'You cannot edit an archived item';
var $A_COMP_CONTENT_MODULE = 'The module';
var $A_COMP_CONTENT_ANOTHER = 'is currently being edited by another administrator';
var $A_COMP_CONTENT_ARCHIVED = 'Item(s) successfully Archived';
var $A_COMP_CONTENT_PUBLISHED = 'Item(s) successfully Published';
var $A_COMP_CONTENT_UNPUBLISHED = 'Item(s) successfully Unpublished';
var $A_COMP_CONTENT_SEL_TOG = 'Select an item to toggle';
var $A_COMP_CONTENT_SEL_DEL = 'Select an item to delete';
var $A_COMP_CONTENT_SEL_MOVE = 'Select an item to move';
var $A_COMP_CONTENT_MOVED = 'Item(s) successfully moved to Section';
var $A_COMP_CONTENT_ERR_OCCURRED = 'An error has occurred';
var $A_COMP_CONTENT_COPIED = 'Item(s) successfully copied to Section';
var $A_COMP_CONTENT_RESET_HIT_COUNT = 'Successfully Reset Hit count for';
var $A_COMP_CONTENT_IN_MENU = '(Link - Static Content) in menu';
var $A_COMP_CONTENT_SUCCESS = 'successfully created';
var $A_COMP_CONTENT_SELECT_CAT = 'Select Category';
var $A_COMP_CONTENT_SELECT_SEC = 'Select Section';

//components/com_categories/toolbar.content.html.php
var $A_COMP_CONTENT_BAR_TRASH = 'Trash';
var $A_COMP_CONTENT_BAR_MOVE = 'Move';
var $A_COMP_CONTENT_BAR_COPY = 'Copy';
var $A_COMP_CONTENT_BAR_SAVE = 'Save';

//components/com_categories/admin.frontpage.html.php
var $A_COMP_FRONT_PAGE_ITEMS = 'Front Page Items';
var $A_COMP_FRONT_ORDER = 'Order';

//components/com_categories/admin.frontpage.php
var $A_COMP_FRONT_COUNT_NUM = 'Parameter count must be a number';
var $A_COMP_FRONT_INTRO_NUM = 'Parameter intro must be a number';
var $A_COMP_FRONT_WELCOME = 'Welcome to the Frontpage';
var $A_COMP_FRONT_IDONOT = 'I do not have anything to display';

//components/com_categories/admin.languages.html.php
var $A_COMP_LANG_INSTALL = 'Installed Languages';
var $A_COMP_LANG_LANG = 'Language';
var $A_COMP_LANG_EMAIL = 'Author Email';
var $A_COMP_LANG_EDITOR = 'Language Editor';
var $A_COMP_LANG_FILE = 'File language';

//components/com_categories/admin.languages.php
var $A_COMP_LANG_UPDATED = 'Configuration succesfully updated!';
var $A_COMP_LANG_M_SURE = 'Error! Make sure that configuration.php is writeable.';
var $A_COMP_LANG_CANNOT = 'You can not delete language in use.';
var $A_COMP_LANG_FAILED_OPEN = 'Operation Failed: Could not open';
var $A_COMP_LANG_FAILED_SPEC = 'Operation failed: No language specified.';
var $A_COMP_LANG_FAILED_EMPTY = 'Operation failed: Content empty.';
var $A_COMP_LANG_FAILED_UNWRT = 'Operation failed: The file is not writable.';
var $A_COMP_LANG_FAILED_FILE = 'Operation failed: Failed to open file for writing.';

//components/com_categories/admin.mambots.html.php
var $A_COMP_MAMB_ADMIN = 'Administrator';
var $A_COMP_MAMB_SITE = 'Site';
var $A_COMP_MAMB_MANAGER = 'Mambot Manager';
var $A_COMP_MAMB_NAME = 'Mambot Name';
var $A_COMP_MAMB_FILE = 'File';
var $A_COMP_MAMB_MUST_NAME = 'Mambot must have a name';
var $A_COMP_MAMB_MUST_FNAME = 'Mambot must have a filename';
var $A_COMP_MAMB_DETAILS = 'Mambot Details';
var $A_COMP_MAMB_FOLDER = 'Folder';
var $A_COMP_MAMB_MFILE = 'Mambot file';
var $A_COMP_MAMB_ORDER = 'Mambot Order';

//components/com_categories/admin.mambots.php
var $A_COMP_MAMB_EDIT = 'is currently being edited by another administrator';
var $A_COMP_MAMB_DEL = 'Select a module to delete';
var $A_COMP_MAMB_TO = 'Select a mambot to';
var $A_COMP_MAMB_PUB = 'publish';
var $A_COMP_MAMB_UNPUB = 'unpublish';

//components/com_categories/admin.massmail.html.php
var $A_COMP_MASS_SUBJECT = 'Please fill in the subject';
var $A_COMP_MASS_SELECT_GROUP = 'Please select a group';
var $A_COMP_MASS_MESSAGE = 'Please fillin the message';
var $A_COMP_MASS_MAIL = 'Mass Mail';
var $A_COMP_MASS_GROUP = 'Group';
var $A_COMP_MASS_CHILD = 'Mail to Child Groups';
var $A_COMP_MASS_SUB = 'Subject';
var $A_COMP_MASS_MESS = 'Message';

//components/com_categories/admin.massmail.php
var $A_COMP_MASS_ALL = '- All User Groups -';
var $A_COMP_MASS_FILL = 'Please fill in the form correctly';
var $A_COMP_MASS_SENT = 'E-mail sent to';
var $A_COMP_MASS_USERS = 'users';

//components/com_categories/admin.media.html.php
var $A_COMP_MEDIA_MG = 'Media Manager';
var $A_COMP_MEDIA_DIR = 'Directory';
var $A_COMP_MEDIA_UP = 'Up';
var $A_COMP_MEDIA_UPLOAD = 'Upload';
var $A_COMP_MEDIA_CODE = 'Code';
var $A_COMP_MEDIA_CDIR = 'Create Directory';
var $A_COMP_MEDIA_PROBLEM = 'Configuration Problem';
var $A_COMP_MEDIA_EXIST = 'does not exist.';
var $A_COMP_MEDIA_DEL = 'Delete';
var $A_COMP_MEDIA_INSERT = 'Insert your text here';
var $A_COMP_MEDIA_DEL_FILE = "Delete file \''+file+'\'?";
var $A_COMP_MEDIA_DEL_ALL = "There are '+numFiles+' files/folders in \''+folder+'\'.\n\nPlease delete all files/folder in \''+folder+'\' first.";
var $A_COMP_MEDIA_DEL_FOLD = "Delete folder \''+folder+'\'?";
var $A_COMP_MEDIA_NO_IMG = 'No Images Found';

//components/com_categories/admin.media.php
var $A_COMP_MEDIA_NO_HACK = 'NO HACKING PLEASE';
var $A_COMP_MEDIA_DIR_SAFEMODE = 'Directory creation not allowed while running in SAFE MODE as this can cause problems.';
var $A_COMP_MEDIA_ALPHA = 'Directory name must only contain alphanumeric characters and no spaces please.';
var $A_COMP_MEDIA_FAILED = 'Upload FAILED.File allready exists';
var $A_COMP_MEDIA_ONLY = 'Only files of type gif, png, jpg, bmp, pdf, swf, doc, xls or ppt can be uploaded';
var $A_COMP_MEDIA_UP_FAILED = 'Upload FAILED';
var $A_COMP_MEDIA_UP_COMP = 'Upload complete';

//components/com_categories/admin.menumanager.html.php
var $A_COMP_MENU_NAME = 'Menu Name';
var $A_COMP_MENU_TYPE = 'Menu Type';
var $A_COMP_MENU_ID = 'Module ID';
var $A_COMP_MENU_ASSIGN = 'No module assigned to menu';
var $A_COMP_MENU_ENTER = 'Please enter a name for your menu';
var $A_COMP_MENU_ENTER_TYPE = 'Please enter a menu type for your menu';
var $A_COMP_MENU_DETAILS = 'Menu Details';
var $A_COMP_MENU_MAINMENU = 'A mod_mainmenu module, with the same name will automatically be created/modified when you save this menu.';
var $A_COMP_MENU_DEL = 'Delete Menu';
var $A_COMP_MENU_MODULE_DEL = 'Menu/Module being Deleted';
var $A_COMP_MENU_ITEMS_DEL = 'Menu Items being Deleted';
var $A_COMP_MENU_WILL = '* This will';
var $A_COMP_MENU_WILL2 = 'this Menu, <br />ALL its Menu Items and the Module associated with it *';
var $A_COMP_MENU_YOU_SURE = 'Are you sure you want to Deleted this menu? \nThis will Delete the Menu, its Items and the Module.';
var $A_COMP_MENU_NAME_MENU = 'Please enter a name for the copy of the Menu';
var $A_COMP_MENU_COPY = 'Copy Menu';
var $A_COMP_MENU_NEW = 'New Menu Name';
var $A_COMP_MENU_COPIED = 'Menu being copied';
var $A_COMP_MENU_ITEMS_COPIED = 'Menu Items being copied';
var $A_COMP_MENU_MOD_MENU = 'A mod_mainmenu module, with the same name<br />will automatically be created when you save this menu.';

//components/com_categories/admin.menumanager.php
var $A_COMP_MENU_CREATED = 'New Menu created';
var $A_COMP_MENU_UPDATED = 'Menu updated.';
var $A_COMP_MENU_DETECTED = 'Menu Deleted';
var $A_COMP_MENU_COPY_OF = 'Copy of Menu';
var $A_COMP_MENU_CONSIST = 'created, consisting of';

//components/com_categories/toolbar.menumanager.html.php
var $A_COMP_MENU_BAR_DEL = 'Delete';

//components/com_categories/admin.messages.html.php
var $A_COMP_MESS_PRIVATE = 'Private Messaging';
var $A_COMP_MESS_SEARCH = 'Search';
var $A_COMP_MESS_FROM = 'From';
var $A_COMP_MESS_READ = 'Read';
var $A_COMP_MESS_UNREAD = 'Unread';
var $A_COMP_MESS_CONF = 'Private Messaging Configuration';
var $A_COMP_MESS_GENERAL = 'General';
var $A_COMP_MESS_SURE = 'Are you sure?';
var $A_COMP_MESS_INBOX = 'Lock Inbox';
var $A_COMP_MESS_MAILME = 'Mail me on new Message';
var $A_COMP_MESS_VIEW = 'View Private Message';
var $A_COMP_MESS_POSTED = 'Posted';
var $A_COMP_MESS_PROVIDE_SUB = 'You must provide a subject.';
var $A_COMP_MESS_PROVIDE_MESS = 'You must provide a message.';
var $A_COMP_MESS_PROVIDE_REC = 'You must select a recipient.';
var $A_COMP_MESS_NEW = 'New Private Message';
var $A_COMP_MESS_TO = 'To';

//components/com_categories/admin.modules.html.php
var $A_COMP_MOD_MANAGER = 'Module Manager';
var $A_COMP_MOD_NAME = 'Module Name';
var $A_COMP_MOD_POSITION = 'Position';
var $A_COMP_MOD_PAGES = 'Pages';
var $A_COMP_MOD_VARIES = 'Varies';
var $A_COMP_MOD_ALL = 'All';
var $A_COMP_MOD_USER = 'User';
var $A_COMP_MOD_MUST_TITLE = 'Module must have a title';
var $A_COMP_MOD_MODULE = 'Module';
var $A_COMP_MOD_DETAILS = 'Module Details';
var $A_COMP_MOD_SHOW_TITLE = 'Show title';
var $A_COMP_MOD_ORDER = 'Module Order';
var $A_COMP_MOD_CONTENT = 'Content';
var $A_COMP_MOD_MOD_POSITION = 'Module Positions';
var $A_COMP_MOD_ITEM_LINK = 'Menu Item Link(s)';
var $A_COMP_MOD_TAB_LBL = 'Location(s)';

//components/com_categories/admin.modules.php
var $A_COMP_MOD_MODULES = 'Module(s)';
var $A_COMP_MOD_CANNOT = 'cannot be deleted they can only be un-installed as they are Mambo modules.';
var $A_COMP_MOD_SELECT_TO = 'Select a module to';

//components/com_categories/admin.newsfeeds.html.php
var $A_COMP_FEED_TITLE = 'Newsfeed Manager';
var $A_COMP_FEED_NEWS = 'News Feed';
var $A_COMP_FEED_ARTICLES = '# Articles';
var $A_COMP_FEED_CACHE = 'Cache time(sec)';
var $A_COMP_FEED_FILL_NAME = 'Please fill in the newsfeed name.';
var $A_COMP_FEED_SEL_CATEG = 'Please select a Category.';
var $A_COMP_FEED_FILL_LINK = 'Please fill in the newsfeed link.';
var $A_COMP_FEED_FILL_NB = 'Please fill in the number of articles to display.';
var $A_COMP_FEED_FILL_REFRESH = 'Please fill in the cache refresh time.';
var $A_COMP_FEED_LINK = 'Link';
var $A_COMP_FEED_NB_ARTICLE = 'Number of Articles';
var $A_COMP_FEED_IN_SEC = 'Cache time (in seconds)';

//components/com_categories/admin.poll.html.php
var $A_COMP_POLL_MANAGER = 'Poll Manager';
var $A_COMP_POLL_TITLE = 'Poll Title';
var $A_COMP_POLL_OPTIONS = 'Options';
var $A_COMP_POLL_MUST_TITLE = 'Poll must have a title';
var $A_COMP_POLL_NON_ZERO = 'Poll must have a non-zero lag time';
var $A_COMP_POLL_POLL = 'Poll';
var $A_COMP_POLL_SHOW = 'Show on menu items';
var $A_COMP_POLL_LAG = 'Lag';
var $A_COMP_POLL_BETWEEN = '(seconds between votes)';

//components/com_categories/admin.poll.php
var $A_COMP_POLL_THE = 'The poll';
var $A_COMP_POLL_BEING = 'is currently being edited by another administrator.';

//components/com_categories/poll.class.php
var $A_COMP_POLL_TRY_AGAIN = 'There is a module already with that name, please try again.';

//components/com_categories/admin.sections.html.php
var $A_COMP_SECT_MANAGER = 'Section Manager';
var $A_COMP_SECT_NAME = 'Section Name';
var $A_COMP_SECT_ID = 'Section ID';
var $A_COMP_SECT_NB_CATEG = '# Categories';
var $A_COMP_SECT_NEW = 'New Section';
var $A_COMP_SECT_SEL_MENU = 'Please select a Menu';
var $A_COMP_SECT_MUST_NAME = 'Section must have a name';
var $A_COMP_SECT_MUST_TITLE = 'Section must have a title';
var $A_COMP_SECT_DETAILS = 'Section Details';
var $A_COMP_SECT_SCOPE = 'Scope';
var $A_COMP_SECT_SHORT_NAME = 'A short name to appear in menus';
var $A_COMP_SECT_LONG_NAME = 'A long name to be displayed in headings';
var $A_COMP_SECT_COPY = 'Copy Section';
var $A_COMP_SECT_COPY_TO = 'Copy to Section';
var $A_COMP_SECT_NEW_NAME = 'The new Section name';
var $A_COMP_SECT_WILL_COPY = 'This will copy the Categories listed<br />and all the items within the category (also listed)<br />to the new Section created.';

//components/com_categories/admin.sections.php
var $A_COMP_SECT_THE = 'The section';
var $A_COMP_SECT_LIST = 'Section List';
var $A_COMP_SECT_BLOG = 'Section Blog';
var $A_COMP_SECT_ARCHIVE_BLOG = 'Section Archive Blog';
var $A_COMP_SECT_DELETE = 'Select a section to delete';
var $A_COMP_SECT_SEC = 'Sections(s)';
var $A_COMP_SECT_CANNOT = 'cannot be removed as they contain categories';
var $A_COMP_SECT_SUCCESS_DEL = 'successfully deleted';
var $A_COMP_SECT_TO = 'Select a section to';
var $A_COMP_SECT_CANNOT_PUB = 'Cannot Publish an Empty Section';
var $A_COMP_SECT_AND_ALL = 'and all its Categories and Items have been copied as';
var $A_COMP_SECT_IN_MENU = 'in menu';

//components/com_categories/admin.statistics.html.php
var $A_COMP_STAT_OS = 'Browser, OS, Domain Statistics';
var $A_COMP_STAT_BR_PAGE = 'Browsers';
var $A_COMP_STAT_BROWSER = 'Browser';
var $A_COMP_STAT_OS_PAGE = 'OS Stats';
var $A_COMP_STAT_OP_SYST = 'Operating System';
var $A_COMP_STAT_URL_PAGE = 'Domain Stats';
var $A_COMP_STAT_URL = 'Domain';
var $A_COMP_STAT_IMPR = 'Page Impression Statistics';
var $A_COMP_STAT_PG_IMPR = 'Page Impressions';
var $A_COMP_STAT_SCH_ENG = 'Search Engine Text';
var $A_COMP_STAT_LOG_IS = 'logging is';
var $A_COMP_STAT_ENABLED = 'Enabled';
var $A_COMP_STAT_DISABLED = 'Disabled';
var $A_COMP_STAT_SCH_TEXT = 'Search Text';
var $A_COMP_STAT_T_REQ = 'Times Requested';
var $A_COMP_STAT_R_RETURN = 'Results Returned';

//components/com_categories/admin.syndicate.html.php
var $A_COMP_SYND_SET = 'Syndication Settings';

//components/com_categories/admin.syndicate.php
var $A_COMP_SYND_SAVED = 'Settings successfully Saved';

//components/com_categories/admin.templates.html.php
var $A_COMP_TEMP_NO_PREVIEW = 'No preview available';
var $A_COMP_TEMP_INSTALL = 'Installed';
var $A_COMP_TEMP_TP = 'Templates';
var $A_COMP_TEMP_PREVIEW = 'Preview Template';
var $A_COMP_TEMP_ASSIGN = 'Assigned';
var $A_COMP_TEMP_AUTHOR_URL = 'Author URL';
var $A_COMP_TEMP_EDITOR = 'Template Editor';
var $A_COMP_TEMP_PATH = 'Path: templates';
var $A_COMP_TEMP_WRT = ' - Writeable';
var $A_COMP_TEMP_UNWRT = ' - Unwriteable';
var $A_COMP_TEMP_ST_EDITOR = 'Template Stylesheet Editor';
var $A_COMP_TEMP_NAME = 'Path';
var $A_COMP_TEMP_ASSIGN_TP = 'Assign template';
var $A_COMP_TEMP_TO_MENU = 'to menu items';
var $A_COMP_TEMP_PAGES = 'Page(s)';
var $A_COMP_TEMP_ = 'Position';

//components/com_categories/admin.templates.php
var $A_COMP_TEMP_CANNOT = 'You can not delete template in use.';
var $A_COMP_TEMP_NOT_OPEN = 'Operation Failed: Could not open';
var $A_COMP_TEMP_FLD_SPEC = 'Operation failed: No template specified.';
var $A_COMP_TEMP_FLD_EMPTY = 'Operation failed: Content empty.';
var $A_COMP_TEMP_FLD_WRT = 'Operation failed: Failed to open file for writing.';
var $A_COMP_TEMP_FLD_NOT = 'Operation failed: The file is not writable.';
var $A_COMP_TEMP_SAVED = 'Positions saved';

//components/com_categories/admin.trash.html.php
var $A_COMP_TRASH_MANAGER = 'Trash Manager';
var $A_COMP_TRASH_ITEMS = 'Content Items';
var $A_COMP_TRASH_MENU_ITEMS = 'Menu Items';
var $A_COMP_TRASH_DEL_ITEMS = 'Delete Items';
var $A_COMP_TRASH_NB_ITEMS = 'Number of Items';
var $A_COMP_TRASH_ITEM_DEL = 'Items being Deleted';
var $A_COMP_TRASH_PERM_DEL = 'Permanently Delete';
var $A_COMP_TRASH_THESE = 'these Items from the Database *';
var $A_COMP_TRASH_YOU_SURE = 'Are you sure you want to Deleted the listed items? \nThis will Permanently Delete them from the database.';
var $A_COMP_TRASH_RESTORE = 'Restore Items';
var $A_COMP_TRASH_NUMBER = 'Number of Items';
var $A_COMP_TRASH_ITEM_REST = 'Items being Restored';
var $A_COMP_TRASH_REST = 'Restore';
var $A_COMP_TRASH_RETURN = 'these Items,<br />they will be returned to their orignial places as Unpublished items *';
var $A_COMP_TRASH_ARE_YOU = 'Are you sure you want to Restore the listed items?';

//components/com_categories/admin.trash.php
var $A_COMP_TRASH_SUCCESS_DEL = 'Item(s) successfully Deleted';
var $A_COMP_TRASH_SUCCESS_REST = 'Item(s) successfully Restored';

//components/com_categories/admin.typedcontent.html.php
var $A_COMP_TYPED_STATIC = 'Static Content Manager';
var $A_COMP_TYPED_LINKS = 'Links';
var $A_COMP_TYPED_ARE_YOU = 'Are you sure you want to create a menu link to this Static Content item? \nAny unsaved changes to this content will be lost.';
var $A_COMP_TYPED_CONTENT = 'Typed Content';
var $A_COMP_TYPED_TEXT = 'Text: (required)';
var $A_COMP_TYPED_EXPIRES = 'Expires';
var $A_COMP_TYPED_WILL = 'This will create a \'Link - Static Content\' in the menu you select';

//components/com_categories/admin.typedcontent.php
var $A_COMP_TYPED_SAVED = 'Typed Content Item saved';
var $A_COMP_TYPED_TRASHED = 'Item(s) sent to the Trash';

//components/com_categories/admin.users.html.php
var $A_COMP_USERS_ID = 'UserID';
var $A_COMP_USERS_LOG_IN = 'Logged In';
var $A_COMP_USERS_LAST = 'Last Visit';
var $A_COMP_USERS_BLOCKED = 'Blocked';
var $A_COMP_USERS_YOU_MUST = 'You must provide a user login name.';
var $A_COMP_USERS_YOU_LOGIN = 'You login name contains invalid characters or is too short.';
var $A_COMP_USERS_MUST_EMAIL = 'You must provide an email address.';
var $A_COMP_USERS_ASSIGN = 'You must assign user to a group.';
var $A_COMP_USERS_NO_MATCH = 'Password do not match.';
var $A_COMP_USERS_DETAILS = 'User Details';
var $A_COMP_USERS_EMAIL = 'Email';
var $A_COMP_USERS_PASS = 'New Password';
var $A_COMP_USERS_VERIFY = 'Verify Password';
var $A_COMP_USERS_BLOCK = 'Block User';
var $A_COMP_USERS_SUBMI = 'Receive Submission Emails';
var $A_COMP_USERS_REG_DATE = 'Register Date';
var $A_COMP_USERS_VISIT_DATE = 'Last Visit Date';
var $A_COMP_USERS_CONTACT = 'Contact Information';
var $A_COMP_USERS_NO_DETAIL = 'No Contact details linked to this User:<br />See \'Components -> Contact -> Manage Contacts\' for details.';
var $A_COMP_USERS_CHANGE_INFO = 'To change this information:<br />See \'Components -> Contact -> Manage Contacts\'.';

//components/com_categories/admin.users.php
var $A_COMP_USERS_SUPER_ADMIN = 'Super Administrator';
var $A_COMP_USERS_CANNOT = 'You cannot delete a Super Administrator';

//components/com_categories/toolbar.users.html.php
var $A_COMP_USERS_LOGOUT = 'Force Logout';

//components/com_categories/admin.weblinks.html.php
var $A_COMP_WEBL_MANAGER = 'Weblink Manager';
var $A_COMP_WEBL_APPROVED = 'Approved';
var $A_COMP_WEBL_MUST_TITLE = 'Weblink item must have a title';
var $A_COMP_WEBL_MUST_CATEG = 'You must select a category.';
var $A_COMP_WEBL_MUST_URL = 'You must have a url.';
var $A_COMP_WEBL_WL = 'Weblink';

//components/com_installer/admin.installer.php
var $A_INSTALL_NOT_FOUND = "Installer not found for element ";
var $A_INSTALL_NOT_AVAIL = "Installer not available for element";
var $A_INSTALL_ENABLE_MSG = "The installer can't continue before file uploads are enabled. Please use the install from directory method.";
var $A_INSTALL_ERROR_MSG_TITLE = 'Installer - Error';
var $A_INSTALL_ZLIB_MSG = "The installer can't continue before zlib is installed";
var $A_INSTALL_NOFILE_MSG = 'No file selected';
var $A_INSTALL_NEWMODULE_ERROR_MSG_TITLE = 'Upload new module - error';
var $A_INSTALL_UPLOAD_PRE = 'Upload ';
var $A_INSTALL_UPLOAD_POST = ' - Upload Failed';
var $A_INSTALL_UPLOAD_POST2 = ' -  Upload Error';
var $A_INSTALL_SUCCESS = 'Success';
var $A_INSTALL_ERROR = 'Error';
var $A_INSTALL_FAILED = 'Failed';
var $A_INSTALL_SELECT_DIR = 'Please select a directory';
var $A_INSTALL_UPLOAD_NEW = 'Upload new ';
var $A_INSTALL_FAIL_PERMISSION = 'Failed to change the permissions of the uploaded file.';
var $A_INSTALL_FAIL_MOVE = 'Failed to move uploaded file to <code>/media</code> directory.';
var $A_INSTALL_FAIL_WRITE = 'Upload failed as <code>/media</code> directory is not writable.';
var $A_INSTALL_FAIL_EXIST = 'Upload failed as <code>/media</code> directory does not exist.';

//components/com_installer/admin.installer.html.php
var $A_INSTALL_WRITABLE = 'Writeable';
var $A_INSTALL_UNWRITABLE = 'Unwriteable';
var $A_INSTALL_CONTINUE = 'Continue ...';
var $A_INSTALL_UPLOAD_PACK_FILE = 'Upload Package File';
var $A_INSTALL_PACK_FILE = 'Package File:';
var $A_INSTALL_UPL_INSTALL = "Upload File &amp; Install";
var $A_INSTALL_FROM_DIR = 'Install from directory';
var $A_INSTALL_DIR = 'Install directory:';
var $A_INSTALL_DO_INSTALL = 'Install';

//components/com_installer/component/component.html.php
var $A_INSTALL_COMP_INSTALLED = 'Installed Components';
var $A_INSTALL_COMP_CURRENT = 'Currently Installed';
var $A_INSTALL_COMP_MENU = 'Component Menu Link';
var $A_INSTALL_COMP_AUTHOR = 'Author';
var $A_INSTALL_COMP_VERSION = 'Version';
var $A_INSTALL_COMP_DATE = 'Date';
var $A_INSTALL_COMP_AUTH_MAIL = 'Author Email';
var $A_INSTALL_COMP_AUTH_URL = 'Author URL';
var $A_INSTALL_COMP_NONE = 'There are no custom components installed';

//components/com_installer/component/component.php
var $A_INSTALL_COMP_UPL_NEW = 'Upload new component';

//components/com_installer/language/language.php
var $A_INSTALL_LANG = 'Upload new language';
var $A_INSTALL_BACK_LANG_MGR = 'Back to Language Manager';

//components/com_installer/language/language.class.php
var $A_INSTALL_LANG_NOREMOVE = 'Language id empty, cannot remove files';
var $A_INSTALL_LANG_UN_ERR = 'Uninstall -  error';
var $A_INSTALL_LANG_DELETING = 'Deleting';

//components/com_installer/mambot/mambot.html.php
var $A_INSTALL_MAMB_MAMBOTS = 'Mambots';
var $A_INSTALL_MAMB_CORE = 'Only those Mambots that can be uninstalled are displayed - some Core Mambots cannot be removed.';
var $A_INSTALL_MAMB_MAMBOT = 'Mambot';
var $A_INSTALL_MAMB_TYPE = 'Type';
var $A_INSTALL_MAMB_AUTHOR = 'Author';
var $A_INSTALL_MAMB_VERSION = 'Version';
var $A_INSTALL_MAMB_DATE = 'Date';
var $A_INSTALL_MAMB_AUTH_MAIL = 'Author Email';
var $A_INSTALL_MAMB_AUTH_URL = 'Author URL';
var $A_INSTALL_MOD_NO_MAMBOTS = 'There are no non-core, custom mambots installed.';

//components/com_installer/mambot/mambot.php
var $A_INSTALL_MAMB_INSTALL_MAMBOT = 'Install Mambot';

//components/com_installer/module/module.html.php
var $A_INSTALL_MOD_MODS = 'Modules';
var $A_INSTALL_MOD_FILTER = 'Filter:';
var $A_INSTALL_MOD_CORE = 'Only those Modules that can be uninstalled are displayed - some Core Modules cannot be removed.';
var $A_INSTALL_MOD_MOD = 'Module File';
var $A_INSTALL_MOD_CLIENT = 'Client';
var $A_INSTALL_MOD_AUTHOR = 'Author';
var $A_INSTALL_MOD_VERSION = 'Version';
var $A_INSTALL_MOD_DATE = 'Date';
var $A_INSTALL_MOD_AUTH_MAIL = 'Author Email';
var $A_INSTALL_MOD_AUTH_URL = 'Author URL';
var $A_INSTALL_MOD_NO_CUSTOM = 'No custom modules installed';

//components/com_installer/module/module.php
var $A_INSTALL_MOD_INSTALL_MOD = 'Install Module';
var $A_INSTALL_MOD_ADMIN_MOD = 'Admin Modules';

//components/com_install/template/template.php
var $A_INSTALL_TEMPL_INSTALL = 'Install ';
var $A_INSTALL_TEMPL_SITE_TEMPL = 'Site Template';
var $A_INSTALL_TEMPL_ADMIN_TEMPL = 'Administrator Template';
var $A_INSTALL_TEMPL_BACKTTO_TEMPL = 'Back to Templates';

//components/com_menus/admin.menus.html.php
var $A_COMP_MENUS_MAX_LVLS = 'Max Levels';
var $A_COMP_MENUS_MENU_ITEM = 'Menu Item';
var $A_COMP_MENUS_ADD_ITEM = 'Add Menu Item';
var $A_COMP_MENUS_SELECT_ADD = 'Select a Component to Add';
var $A_COMP_MENUS_MOVE_ITEMS = 'Move Menu Items';
var $A_COMP_MENUS_MOVE_MENU = 'Move to Menu';
var $A_COMP_MENUS_BEING_MOVED = 'Menu Items being moved';
var $A_COMP_MENUS_NEXT = 'Next';
var $A_COMP_MENUS_COPY_MENU = 'Copy to Menu';
var $A_COMP_MENUS_BEING_COPIED = 'Menu Items being copied';

//components/com_menus/admin.menus.php
var $A_COMP_MENUS_MOVED_TO = ' Menu Items moved to ';
var $A_COMP_MENUS_COPIED_TO = ' Menu Items Copied to ';
var $A_COMP_MENUS_WRAPPER = 'Wrapper';
var $A_COMP_MENUS_SEPERATOR = 'Separator / Placeholder';
var $A_COMP_MENUS_LINK = 'Link - ';
var $A_COMP_MENUS_STATIC = 'Static Content';
var $A_COMP_MENUS_URL = 'Url';
var $A_COMP_MENUS_CONTENT_ITEM = 'Content Item';
var $A_COMP_MENUS_COMP_ITEM = 'Component Item';
var $A_COMP_MENUS_CONT_ITEM = 'Contact Item';
var $A_COMP_MENUS_NEWSFEED = 'Newsfeed';
var $A_COMP_MENUS_COMP = 'Component';
var $A_COMP_MENUS_LIST = 'List';
var $A_COMP_MENUS_TABLE = 'Table';
var $A_COMP_MENUS_BLOG = 'Blog';
var $A_COMP_MENUS_CONT_SEC = 'Content Section';
var $A_COMP_MENUS_CONT_CAT = 'Content Category';
var $A_COMP_MENUS_CONT_SEC_MULTI = 'Content Section Multiple';
var $A_COMP_MENUS_CONT_CAT_MULTI = 'Content Category Multiple';
var $A_COMP_MENUS_CONT_SEC_ARCH = 'Content Section Archive';
var $A_COMP_MENUS_CONT_CAT_ARCH = 'Content Category Archive';
var $A_COMP_MENUS_CONTACT_CAT = 'Contact Category';
var $A_COMP_MENUS_WEBLINK_CAT = 'Weblink Category';
var $A_COMP_MENUS_NEWS_CAT = 'Newsfeed Category';

//components/com_menus/component_item_link/component_item_link.menu.html.php
var $A_COMP_MENUS_CIL_LINK_NAME = 'Link must have a name';
var $A_COMP_MENUS_CIL_SELECT_COMP = 'You must select a Component to link to';
var $A_COMP_MENUS_CIL_LINK_COMP = 'Component to Link';
var $A_COMP_MENUS_CIL_ON_CLICK = 'On Click, Open in';
var $A_COMP_MENUS_CIL_PARENT = 'Parent Item';
var $A_DETAILS = 'Details';

//components/com_menus/components/components.menu.html.php
var $A_COMP_MENUS_CMP_ITEM_NAME = 'Item must have a name';
var $A_COMP_MENUS_CMP_SELECT_CMP = 'Please select a Component';
var $A_COMP_MENUS_PARAMETERS_AVAILABLE = 'Parameter list will be available once you save this New menu item';
var $A_COMP_MENUS_CMP_ITEM_COMP = 'Menu Item :: Component';

//components/com_menus/contact_category_table/contact_category_table.menu.html.php
var $A_COMP_MENUS_CMP_CCT_CATEG = 'You must select a category';
var $A_COMP_MENUS_CMP_CCT_TITLE = 'This Menu item must have a title';
var $A_COMP_MENUS_CMP_CCT_BLANK = 'If you leave this blank the Category name will be automatically used';
var $A_COMP_MENUS_CMP_CCT_THETITLE = 'Title:';
var $A_COMP_MENUS_CMP_CCT_THECAT = 'Category:';

//components/com_menus/contact_item_link/contact_item_link.menu.html.php
var $A_COMP_MENUS_CMP_CIL_LINK_NAME = 'Link must have a name';
var $A_COMP_MENUS_CMP_CIL_SEL_CONT = 'You must select a Contact to link to';
var $A_COMP_MENUS_CMP_CIL_CONTACT = 'Contact to Link:';
var $A_COMP_MENUS_CMP_CIL_ONCLICK = 'On Click, Open in:';
var $A_COMP_MENUS_CMP_CIL_HDR = 'Menu Item :: Link - Contact Item';

//components/com_menus/wrapper/wrapper.menu.html.php
var $A_COMP_MENUS_WRAPPER_LINK = 'Wrapper Link';

//components/com_menus/separator/separator.menu.html.php
var $A_COMP_MENUS_SEPARATOR_PATTERN = 'Pattern';

//components/com_menus/content_typed/content_typed.menu.html.php
var $A_COMP_MENUS_TYPED_CONTENT_TO_LINK = 'Typed Content to Link';

//components/com_menus/content_item_link/content_item_link.menu.html.php
var $A_COMP_MENUS_CONTENT_TO_LINK = 'Content to Link';

//components/com_menus/newsfeed_link/newsfeed_link.menu.html.php
var $A_COMP_MENUS_NEWSFEED_TO_LINK = 'Newsfeed to Link';

}

?>