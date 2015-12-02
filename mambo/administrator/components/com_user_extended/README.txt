#################################################
#                                               #
#  User Extended Component                      #
#  Version: 1.2.3 (for 4.5.1)                   #
#                                               #
#                                               #
#  Authors:                                     #
#                                               #
#  Component and Extensions Developer           #
#    Name   : Bernhard Zechmann (MamboZ)        #
#    Email  : mamboz@zechmann.com               #
#    Website: www.zechmann.com                  #
#                                               #
#  Former Addon Hack Version: 1.0.1[Elizabeth]  #
#    Name   : Phil Taylor                       #
#    Website: www.phil-taylor.com               #
#                                               #
#  Language detection & multilanguage support   #
#    Name   : Michael Magler (mic)              #
#    Email  : mic@egi.at                        #
#    Website: www.egi.at                        #
#                                               #
#################################################

BACKUP!BACKUP!BACKUP!BACKUP!BACKUP!BACKUP!BACKUP!
BACKUP!      YOU HAVE BEEN WARNED!        BACKUP!
BACKUP!BACKUP!BACKUP!BACKUP!BACKUP!BACKUP!BACKUP!


1.Intoduction
  This component extends the core mambo user
  registration system by providing 15 extra
  customizable text fields. The labels of the
  fields can be set by the admin in the backend.

  This component is based on addon UserExtended
  hack provided by Phil Taylor.


2.Update
  Take a look in the file changelog.txt
  You will find in line

  - database modification: NO
  You can just overwrite all files in the
  following directories:
    components/com_user_extended/
    administrator/components/com_user_extended

  - database modification: YES
  >>> BACKUP YOUR DATABASE OR EVEN THE TABLES
  "mos_user_extended" AND "user_extended_config"

  Then unsinstall the component and install the
  new version. Fill in all tables or restore the
  content of the tables.


3.Installation
  Insert the following URL links into user menu
  or modify the module login (modules/login.php):

    Registration:
    index.php?option=com_user_extended&task=register

    Lost Password:
    index.php?option=com_user_extended&task=lostPassword


  Insert the following URL link into user menu
  to allow users to modify their entries:

    Edit/Update User Details:
    index.php?option=com_user_extended&task=UserDetails


    View My Details (own user extended details)
    index.php?option=com_user_extended&task=UserView

    View User Details (other users entries)
    index.php?option=com_user_extended&task=UserView&userid=XXX
    (replace XXX with the according id of user to be viewed)


4.Administration
  You access the component from the menu in the
  Components/UserExtended menu.


5.Automatic language detection
  The language os taken from your global Mambo settings.
  If your language is not delivered with UserExtended
  english is default.


6.Adding a language
  To add additional languages just edit one of the
  language files in the folder
    components/com_user_extended/language/<LANGUAGE>.php
  and save it with the new languagename.


7.Supported languages
  - English
  - French
  - German (germanf & germani)
  - Italian
  - Spanish
  - Dutch

  Feel free to translate as many languages.
  Please send a copy also to: mic@egi.at

#################################################