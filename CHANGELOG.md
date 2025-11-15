# Changelog

All notable changes to this project will be documented in this file.

## Unpublished
### Added
- hide registration button if user self registration is disabled
- hide registration routes if user self registration is disabled
### Changed
- changed env variable name of user self registration
### Fixed
- sponsor package price column is now not nullable with default value of 0 and price will not be displayed if it is 0

## v0.8.11 - 2025-02-03
### Added
- email verified information on user management pages (overview, edit)
- verified middleware to the most important endpoints
- write verified email info from oauth token into user model

## v0.8.10 - 2025-02-02
### Added
- added admin user notification after registration of new user.
### Fixed
- birthday link is only visible for user with memberShow permission.

## v0.8.9 - 2025-02-02
### Added
- oAuth support
### Changed
- update composer and node packages
### Fixed
- update profile information works again now

## v0.8.8 - 2025-01-27
### Fixed
- end date of event copy works now

## v0.8.7 - 2025-01-10
### Fixed
- fixed full day ics events

## v0.8.6 - 2024-10-26
### Fixed
- files in sponsoring notifications work again (links have domain url now)
### Changed
- wording change for sponsoring overview mail

## v0.8.5 - 2024-10-25
### Fixed
- sending single sponsoring notification mail works again

## v0.8.4 - 2024-10-23
### Added
- add some cross-links for sponsoring
### Changed
- change url of sponsoring backer overview
### Fixed
- period csv export is working now

## v0.8.3 - 2024-10-21
### Added
- edit page for uploaded files (admin only)
- paused switch on member overview
- member backer assignment button on period overview
- a custom text can now be added for the sponsoring remember mail.
- add small period summary to dashboard overview
### Changed
- uploaded files column `forcePublic` changed to `isPublic`
- member filter has now buttons instead of checkboxes
### Fixed
- period files are now publicly available
- session persistent start and end in event filter
- redirect to event index after event deletion
- use correct date for event copy

## v0.8.2 - 2024-09-24
### Added
- button and modal for sending reminder to members of a sponsoring contract
- application logo is now beside the application name in the mail template header
- created_at time is displayed on period ad option overview

## v0.8.1 - 2024-09-21
### Added
- show members of previous periods on contract detail page
- member edit button on sponsoring period member assignment page
### Fixed
- member group on event filter works now
- when cloning events, the date is now set correctly

## v0.8.0 - 2024-09-20
### Added
- collapse/fold all feature for period member assignment
- show only assigned checkbox for period member assignment
- a member can be selected now on the quick backer add component, where a new contract will be created.
- add alpine directive for clipboard and tippy tooltips
- add tippy tooltip for period backer overview icons
- add icons to event overview, show type and member group on mobile
- member information section on user profile (if member with same mail address exists)
### Changed
- update to laravel 11 and php 8.3
- public files url are now the file controller too
- show loading icon on admin files view
- show contract list on backer overview, backer edit and contract details
### Fixed
- after changing the assignments multiple times in the member backer assignment page, the current selected backers are now displayed correctly

## v0.7.19 - 2024-09-13
### Fixed
- all events are no back on ics export

## v0.7.18 - 2024-09-12
### Added
- Page view tests for sponsoring and event feature
### Fixed
- no double separator lines on dashboard cards
- show 404 instead of exception when file is missing
- forgotten membergroup change for event calendar
- null saved in case of no token in event ics controller

## v0.7.17 - 2024-09-11
### Changed
- notification are now over a modal
- multi select dates for event copy is now possible
- hide unofficial packages from sponsor period edit/create form
- change event logged_in_only flag to a member group relation
- update dashboard view (header for management cards)
- uploaded files renamed to files, unknown files are now downloadable
### Added
- dashboard card for member sponsoring contracts
- added backup tool for files and db (stored only locally)

## v0.7.16 - 2024-09-06
### Changed
- date time local inputs are now components with separate inputs (for better mobile support)

## v0.7.15 - 2024-09-03
### Changed
- added notifications when forcing a web push on event or news
- accordion implementation (use label instead of title)
- uploaded file url now with base url
### Added
- add possibility of E-Mail notification to member backer assignment component
- german translation for email notification and member backer assignment
- glitchTip/sentry support
- add buttons for event and news on dashboard
### Fixed
- allow empty email on member edit (db unique exception beforehand null != empty string)
- notification message are now shown with livewire changes on member backer assignment
- default params for poll form (bool flags)

## v0.7.14 - 2024-08-29
### Added
- add period backer overview
- add period backer assignment with quick backer creation component
- first feature tests for sponsoring feature
### Fixed
- error of empty backer list enabled elements

## v0.7.13 - 2024-05-28
### Added
- logged on user can record attendance on event detail page for member with same email
### Changed
- better mobile/responsive view for poll list
### Fixed
- use application logo for notifications instead of default logo

## v0.7.12 - 2024-05-28
### Added
- dashboard modules for members, polls and sponsoring
- last member birthday module for dashboard

## v0.7.11 - 2024-05-27
### Added
- imprint and privacy policy page, editable via settings
- flag for public poll statistic, if checked poll stats can be shown to everyone with link
- personal custom link for navigation
### Changed
- email in member table is now unique (validation in member form added)
- hide past on event overview is now default true

## v0.7.10 - 2024-05-05
### Added
- switch to show unattended members in attendance display
- add vat to sponsor backer (incl forms, contract overview)
- delete button for all attendance records
### Changed
- sort member in overview sorted by name

## v0.7.9 - 2024-05-01
### Added
- manifest file for PWA, necessary for (iOS and webpush)
- gitlab pipeline deployment
- de translations for public polls and event detail
### Changed
- ad option backer overview is now an order list and button is exchanged with caret
- webpush notification refactored
- store event text search in session
- order member in selection statistic event overview on lastname

## v0.7.8 - 2024-04-16
### Added
- add member list for attendance poll statistic
- show unknown files on storage app on uploaded files page
- show log files on developer page
- add log files to development page and make downloadable
### Changed
- hide past switch is session persistent now on event filter
- create and use development middleware class instead of function in router
- when enabling the development mode, it is only enabled a limited time (10 min)
- period - adOption overview is refreshing now after saving ad placement
### Fixed
- fixed uploaded file page error on null storer files

## v0.7.7 - 2024-04-11
### Added
- add development page with different details, and a config to enable (public) access to it
- add possibility to update page title
- add uploaded file page incl navigation to see all files (only for admin)
### Changed
- input switch works now with events
- update and changed legend of period backer overview
- show red icons on contract, ad data and paid if package is already selected
- sponsoring contracts, uploaded files and ad placement will be deleted if parent is deleted

## v0.7.6 - 2024-04-08
### Added
- add user id at push notifications for future features
- add back symfony/filesystem composer module for enabling relative symlinks (`artisan storage:link --relative` is now possible)
### Changed
- group/list switch selection in attendance record is now cached in the session
- less abrasive push notification asking, only on click on icon
### Fixed
- attendance record shows correct member sets after filter change (without the need of a reload)
- deleting app icon does not delete all uploaded files anymore
- correct image will be displayed on app icon settings
- display correct logo from app icon

## v0.7.5 - 2024-04-06
### Added
- ad placement modal on period/adOption overview
- sort functionality via form of event type and member type
- add info field to member
- add config for guest layout text (login, new password, etc.)
### Changed
- removed relative symlinks and unused composer module
- file access management will now managed via interface in the storer models
- notification message progress will now be stored in the storage
- move member import adaptions into member migration
- move attendance poll migration to base migration
### Fixed
- modal overlay over navigation
- event navigation dropdown works now for eventEdit permission

## v0.7.4 - 2024-03-31
### Added
- appearance setting part (set application name, and logo)
### Changed
- attendance display group list switcher is frontend managed again, removed member filter
- add today switch for event filter, update accordion component
- change default logo from a club specific to an own application logo
### Fixed
- attendance display and record render works now after group/list switch
- fix deployment problem with permissions on uploaded files

## v0.7.3 - 2024-03-26
### Changed
- update sponsor buttons to dropdown
- move helpful links of attendance views into header bar
- dont render list and group in attendance view
- add attended cnt to attendance display, move statistic calculation into own class
- add attendance statistic to parent member groups
- dont show member in attendance statistic only if not in member AND no records available

## v0.7.2 - 2024-03-22
### Changed
- show full formatted news in news overview
- update news form buttons to button dropdown
- change form buttons for member forms
- change form buttons for user forms
- change form buttons for events forms
- change form buttons for event polls
### Fixed
- event calendar can hold apos now
- fix public poll bug (when no events can be selected)
- missing member in poll statistic

## v0.7.1 - 2024-03-21
### Added
- page size selector for event overview
### Fixed
- birthday list print button on mobile does not wrap now
- fix inputs with double types

## v0.7.0 - 2024-03-20
### Changed
- Change whole navigation to sidebar navigation
- reworked some button in the header
- logger channels updated
### Fixed
- period - ad option overview works now with illegal(not in packages) options

## v0.6.6 - 2024-03-15
- remove button dropdown item blade template, use dedicated css instead

## v0.6.5 - 2024-03-15
### Added
- add setting for include member birthdays into public ics export
- add button-dropdown menu at member birthday lists
- notification for login and logoff
### Changed
- use standard notification message for click on calendar link on dashboard
- store member filter selection in database instead of browser
- if members are in multiple groups the other components get now update if one changes in attendance record
- use member filter config also for birthday list (incl print)
- birthday list is now livewire page with member filter
- remove button-link blade template and use css class instead
- remove default-button blade template and use css class instead
- dont use blade template for user nav dropdown, use x-anchor instead
### Fixed
- navigation fix of login button underline/active
- Event Type title is required in form
- navigation active state is now shown for subpages too

## v0.6.4 - 2024-03-11
### Added
- icon legend on backer period overview
### Changed
- allow bmp and webp for backer file upload
- period contract overview
  - show green contract icon even without timestamp
  - show blue ad data icon if files are available
- make file area droppable, add progress bar and cancel button
- notification messages, update to colored background
- add standard notification message functions to facade

## v0.6.3 - 2024-03-09
### Changed
- change event filter date persistence to cookieStorage
- redesigned notification messages
- update message adding
### Added
- Delete button in poll edit form
### Fixed
- only show create user button on member edit if userEditPermission and email
- show member Birthday button on member show permission

## v0.6.2 - 2024-03-07
### Added
- backer count on backer overview
- show disabled or closed sponsors at the end of the backer period overview
- x-anchor for member and event filter and exports
### Fixed
- public poll error - missing default for dropdown member filter

## v0.6.1 - 2024-02-26
all changes made for sponsoring feature
### Fixed
- small language fixes for sponsoring
- show only available packages, inofficial packages are only in contract available
### Changed
- show package price in contract edit dropdown
### Added
- add history of backer contracts on contract edit
- period and backer edit links on contract edit form

## v0.6.0 - 2024-02-26
### Added
- Sponsoring feature - Manage your Sponsors
  - periods
  - Backer
  - ad options
  - packages
  - contracts

## v0.5.11 - 2024-02-25
### Added
- event export with csv and Excel files
### Updated
- member overview table is now (more) responsive
### Fixed
- correct working disableLastYearEvents functionality
- current day marker in birthday list is now after members with birthday on this day

## v0.5.10 - 2024-02-02
### Added
- add settings section/page for global settings:
  * default event start and end
  * member filter for public polls
### Changed
- use Enum for configuration keys
- colors for member overview (use text colors and less background colors)
### Fixed
- web push scheduler: do not notify disabled events (daily pushes)

## v0.5.9 - 2024-01-30
### Added
- more logging for creates updates and deletes
### Changed
- make events statistic year persistent via session
### Fixed
- remove misplaced character in member edit form

## v0.5.8 - 2024-01-21
### Added
- Event statistic - page with year selector, shows how many events per type are in a specific year
### Fixed
- multiple web notification for same event (hourly)

## v0.5.7 - 2023-12-24
### Added
- make sort direction of event overview persistent.
- member statistic for attendance poll statistics.
- added event start/end date update function from edit to create form too.

## v0.5.6 - 2023-12-22
### Added
- add rich text formatter for news content
### Changed
- add member birthdays for last and next year to ical export
- move member filter class in subfolder
- change event filter (remove past flag, added start and end date picker)

## v0.5.5 - 2023-11-27
### Added
- Print member birthday list

## v0.5.4 - 2023-11-27
### Fixed
- fix the fix

## v0.5.3 - 2023-11-27
### Fixed
- new line bug on Calendar (json parse problem)

## v0.5.2 - 2023-11-27
### Added
- button on member edit form to create a user from member data
- calendar page (with fullCalendar plugin)
### Changed
- update birthday list styling

## v0.5.1 - 2023-11-25
### Fixed
- 500 response for guests on dashboard (missing null check)

## v0.5.0 - 2023-11-25
### Added
- configuration management (table, model)
- configurable dashboard buttons
### Fixed
- show member birthday in personal calendar link only with member show or edit permissions

## v0.4.5 - 2023-11-18
### Added
- new feature: personal calendar link (with personal access token)

## v0.4.4 - 2023-11-09
### Added
- event detail page with route and controller
- news detail page with route and controller
- edit news button on dashboard
### Fixed
- excel Birthday list export birthday column type
- missing member filter on poll statistic
- web push notification only for news without the flag loggedInOnly
### Changed
- web push notification button points now to detail pages

## v0.4.3 - 2023-11-02
### Added
- Birthday list link on dashboard (if permissions)
- Excel (xlsx) file export for members
### Changed
- moved memberGroup filter to memberFilter
- move member import btn after member list
- move member group selection into filter with possibility to no use
- member export (former birthday list export) considers the member filter now

## v0.4.2 - 2023-10-30
### Added
- new hourly cronjob for event web push notification
- Admin with the permission user management can send password reset links
### Changed
- member group tree accordions are now initial shown
- general message for event web push notification (it cant be ensured when the notification will be read)

## v0.4.1 - 2023-10-26
### Added
- location to event overview
- this change log file
### Changed
- event overview is responsive now
### Fixed
- event livecycle (date update) on event forms

## v0.4.0 - 2023-10-20
### Changed
- upgrade livewire to v3
- use livewire forms for
  - news
  - event
  - event type
  - member
  - member group
  - attendance polls
  - user management

## v0.3.10 - 2023-10-11
### Fixed
- event filter works now correctly

## v0.3.9 - 2023-09-30
### Added
- add sort order button to event filter dropdown

## v0.3.8 - 2023-09-30
### Added
- event filter on event overview page

## v0.3.7 - 2023-09-30
### Changed
- event past filter is now calculated via end datetime instead of start

## v0.3.6 - 2023-09-27
### Added
- links for events on overview
- links on public attendance poll view
- new event model functions for formatted start and end
### Changed
- do not show time if event is a full day event

## v0.3.5 - 2023-09-24
### Added
- german translations
### Changed
- remove full birthday list button (this is default now)
- show only future events in attendance poll
### Fixed
- member group in attendance selection view

## v0.3.4 - 2023-08-10
### Changed
- cron webpush notification not for logged_in_only events
- 
## v0.3.3 - 2023-08-10
### Fixed
- Today/Yesterday event webpush bug

## v0.3.2 - 2023-08-06
### Changed
- get vapid public key via api for the webpush registration

## v0.3.1 - 2023-08-06
### Fixed
- duplicated route name

## v0.3.0 - 2023-08-06
### Added
- webpush notifications
  - service worker
  - cron job for events
  - icon in navbar
  - push notification for events and news

## v0.2.7 - 2023-07-31
### Fixed
- correct events are shown (future instead of past)

## v0.2.6 - 2023-07-31
### Added
- attendance poll: member group relation

## v0.2.5 - 2023-07-27
### Changed
- poll statistic: sort events due to start date

## v0.2.4 - 2023-07-27
### Changed
- public poll: sort events due to start date

## v0.2.3 - 2023-07-27
### Changed
- Attendance poll form: do not show already selected events in list.

## v0.2.2 - 2023-07-25
### Changed
- Filtered members implementation
  - Dropdown
  - Own Filter Model
### Added
- Full birthday list export.
- Member Filter for attendance selection
- Attendance poll form: checkbox to show/hide disabled events

## v0.2.1 - 2023-07-24
### Fixed
- empty attendance poll table (show message instead)
- attendance poll form: wrong member-group dropdown list
- member create bug
### Changed
- attendance selection: show message if no members to display
### Added
- Member delete button

## v0.2.0 - 2023-07-24
### Changed
- hide section of missing birthdays (if nothing to display)
### Added
- Attendance and poll
  - model, factory, migration and seeders for attendance 
  - attendance selection member group view
  - attendance selection member list view
  - attendance statistic page
  - Poll form
  - poll overview
  - Public poll view
- Helper function in event model
### Changed
- hide navbar on outside click

## v0.1.5 - 2023-07-04
### Fixed
- member group query of leaf groups

## v0.1.4 - 2023-07-03
### Added
- datalist for event form (location and dress code)

## v0.1.3 - 2023-07-03
### Changed
- member import: Disable button while file upload
### Added
- loading overlay while loading

## v0.1.2 - 2023-07-03
### Added
- German translations
### Changed
- exchanged member property: removed special, added paused

## v0.1.1 - 2023-07-03
### Changed
- user computed properties for member overview

## v0.1.0 - 2023-07-03
### Added
- Titles and active flag for members
- Member import from csv
- Today line in birthday list
- Filter for member overview

## v0.0.7 - 2023-06-26
### Fixed
- Full day event on ics event export
### Added
- Location to ics event export
### Changed
- update default logger for daily log rotation
- Button in event overview (own row)

## v0.0.6 - 2023-06-23
### Added
- Member functionallity
  - table, relation, seeder for member and member group
  - member and member group overview
  - member and member group forms
  - birthday lists with csv export

## v0.0.5 - 2023-06-07
### Added
- Add last login column in user table (incl fill logic)
- Add column in user overview and in form (for last login)

## v0.0.4 - 2023-06-06
### Fixed
- user create/edit bug

## v0.0.3 - 2023-06-06
### Added
- save and stay button for event form
- German Translations
### Changed
- some button alignment and style changes

## v0.0.2 - 2023-06-05

### Fixed
- html tax not displayed in news overview
### Added
- german translations
### Changed
- button default style

## v0.0.1 - 2023-06-05
First deployed version
