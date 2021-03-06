Changelog
=========

3.0.14
-----

-   bugfix autoloading definition

3.0.12
-----

-   updated tx_mkforms_forms_IJSFramework interface

3.0.11
-----

-   updated licence as GPL-2.0+ is outdated
-   fixed compatibility issues in PHP 7 and TYPO3 8.7
-   support for absRefPrefix with some refactoring
-   added autoload in ext_emconf.php

3.0.10
-----

-   plugin changed to User and added toUserInt for all existing actions


3.0.9
-----

-   bugfix dont double encode ampersand in action attribute

3.0.8
-----

-   additional getter removed from maydey exception since parent owns it
-   bugfix form action attribute using current URL by default without creating it

3.0.7
-----

-   bugfix made method declaration of _sqlSearchClause compatible

3.0.6
-----

-   cleanup use $GLOBALS['EXEC_TIME'] for inserts/updates on crdate/tstamp database fields

3.0.5
-----

-   time tracking validation: threshold can be a userObj

3.0.4
-----

-   Ajax-Calls: restore TSFE before form for correct translation handling
-   csrf protection can be configured in XML structure

3.0.3
-----

-   [TASK] Remove hard-coded composer version
-   [BUGFIX] Override HTTP status response headers

3.0.2
-----

-   bugfix dependsonifstrict also on array values

3.0.1
-----

-   Hook in Mail-DataHandler added

3.0.0
-----

-   TYPO3 8.7 LTS Support
-   Templates for renderlet box fixed

2.0.6
-----

-   added missing load

2.0.5
-----

-   tx_mkforms_action_FormBase::getViewClassName() and tx_mkforms_action_FormBase::getTemplateName() now protected
-   database datahandler now removes all fields that are not in the TCA of the given table
-   moved tx_mkforms_widgets_damupload_Main to tx_mkforms_widgets_mediaupload_Main
-   new attribute isSaveable for all widgets. default is true except for the MEDIAUPLOAD widget
-   fixed FILE validator for MEDIAUPLOAD widget
-   Scroll to error box after validation on ajaxcalls
-   support for null as blank value in renderlets items
-   strict check option added to listbox
-   small refactoring

2.0.4
-----

-   first datahandler mail refactoring, template object by config added
-   Cleanup version properties in config for xmls
-   set default wrap class to mkforms
-   add runable support for some config paths in mail datahandler
-   add sucess callback for mail datahandler
-   converted documentation from reSt to markdown
-   support for fal references in image renderlet
-   tx_mkforms_util_Div::toRelPath is now static
-   minor bugfix
-   loadFirstReferenceUid uses entryId from datahandler


2.0.3
-----

-   Missing include added
-   Avoid js warning in console
-   Implemented majixSetHtml to replace content of boxes
-   new option renderLabelFirst in CHECKSINGLE

2.0.2
-----

-   Show mayday if codebehind js file was not found
-   visibility of methods set
-   JS wrapper extended
-   old js code fixed
-   fixed a missing include

2.0.1
-----

-   bugfix for syntax error

2.0.0
-----

-   added support for TYPO3 7.6

1.0.44
------

-   Main subpart configurable in view
-   bugfixes
-   getStoredData() of database datahandler returns record on first call
-   process tag for actionlet redirect added
-   new parameter viewData for add...Marker methods

1.0.43
------

-   cleanup

1.0.42
------

-   bugfixes

1.0.41
------

-   process typoscript in Formbase utility

1.0.40
------

-   Condition for includeXML fixed

1.0.39
------

-   Feature first-active for radiobuttons added
-   get TypoScript for forms xml and templates added
-   unique validator refactored, skipedition check and disabled option added
-   New template method to get the form id

1.0.38
------

-   cleanup
-   new config to disable strict check for validator dependson

1.0.37
------

-   refactoring

1.0.36
------

-   bugfix falls hasError in einem Template direkt aufgerufen wird und ein Widgetname übergeben bekommt

1.0.35
------

-   recursive includeXml inclusion now possible
-   cleanup filename in the normal upload widget just like in the FAL/DAM upload widget

1.0.33
------

-   some cleanup

1.0.32
------

-   [BUGFIX] mkwrapper in framework.js ergaenzt
-   new static country feature for form field data (see manual - static-country-feature)

1.0.26
------

-   removed old documentation
-   [BUGFIX] prevent js error on newer query versions for rowInput fields
-   [CLEANUP] Autoformat the PHP files (thanks to Oliver Klee)

