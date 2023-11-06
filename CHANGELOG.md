# Changelog

All notable changes to this project will be documented in this file.

## Unpublished

### Added

- event detail page added with route and controller

### Fixed

- excel Birthday list export birthday column type
- missing member filter on poll statistic

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
