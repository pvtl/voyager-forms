# Voyager Forms

__The Missing Form Module for The Missing Laravel Admin.__

This [Laravel](https://laravel.com/) package adds dynamic form creation and shortcode insertion to a [Voyager](https://laravelvoyager.com/) project.

- Create & manage forms and their fields (add fields, drag/drop into order etc)
- Output forms on the frontend with an simple shortcode (`{!! forms(<FORM_ID>) !!}`)
- Each form's output on the frontend are overridable with custom layouts
- All submissions are emailed inside overridable HTML email templates
- All submissions are backed up to the database and accessible under Voyager Admins > Forms > Enquiries

Built by [Pivotal Agency](https://pivotal.agency/).

---

## Prerequisites

- Node & NPM Installed
- Composer Installed
- [Install Laravel](https://laravel.com/docs/installation)
- [Install Voyager](https://github.com/the-control-group/voyager)
- [Install Voyager Front-end](https://github.com/pvtl/voyager-frontend)

---

## Installation

```bash
# 1. Require this Package in your fresh Laravel/Voyager project
composer require pvtl/voyager-forms

# 2. Run the Installer
composer dump-autoload && php artisan voyager-forms:install

# 3. Configure to/from addresses
        -> Navigate to Admin -> Settings -> 'Forms' tab
        -> Adjust values

# 4. (optional) Add Google invisible reCAPTCHA
        -> Navigate to Admin -> Settings -> 'Admin' tab
        -> Insert Google reCATPCHA keys

``` 

---

## Displaying Forms

You can easily display your created forms on the front-end in any kind of output - we use shortcodes to render our forms so go ahead and add `{!! forms(1) !!}` to a page/post to see the default Contact form appear.

---

## Form Hooks

You may also wish to include custom logic and functionality when your form has been submitted (but before the submission has saved to the DB - eg. so that you can execute custom validation). This can be done with a __Form Hook__ Block - simply specify your controllers namespace'd path and the method you wish to call and the Voyager Forms module will automatically execute it upon submission. For example:

```php
Pvtl\AwesomeModule\Somewhere\ClassName::anExampleHey('hello world')
```

_Note that in the above example, the first param of the actual method will be the submission data and the second param will be 'hello world'_

---

## Custom Form Output

This module outputs forms on the frontend in a basic structure. However you have the ability to build your own form layouts very easily.

#### A completely custom layout:

- Create a new blade template in `views/vendor/voyager-forms/layouts`
- Edit the form in Voyager Admin and select the new layout you created

To get a completely custom output, you'll likely need to define the `<form>` html including each form field individually.

#### Override fields

You also have the ability to override `views/vendor/voyager-forms/forms/render.blade.php` to change the way form fields are styled.

---

## Custom Email Templates

This module sends a generic looking email with each submission. However you have the ability to build your own email templates very easily.

- Create a new blade template in `views/vendor/voyager-forms/email-templates` (you can also simply override `default.blade.php` in the same location)
- Edit the form in Voyager Admin and select the appropriate email template
