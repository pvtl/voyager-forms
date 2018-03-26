# Voyager Forms

__The Missing Form Module for The Missing Laravel Admin.__

This [Laravel](https://laravel.com/) package adds dynamic form creation and shortcode insertion to a [Voyager](https://laravelvoyager.com/) project.

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
```

## Creating Forms

This module will allow you to create dynamic forms and output them on the frontend of your website - mailing/execution is all handled by the module itself, you just have to provide the details and off you go.

You can manage all forms and enquiries through the Voyager admin area, there will be a new menu item called "Forms" which provides all the basics for getting started.

## Displaying Forms

You can easily display your created forms on the front-end in any kind of output - we use shortcodes to render our forms so go ahead and add `{!! forms(1) !!}` to a page/post to see the default Contact form appear.

## Form Hooks

You may also wish to include custom logic and functionality after your form has been submitted. This can be done with a __Form Hook__ Block - simply specify your controllers namespace'd path and the method you wish to call and the Voyager Forms module will automatically execute it upon submission.

## Overriding Form Views
When you're ready to start structuring the display of your form, you'll need to create a blade template (located at `views/vendor/voyager-forms/layouts`) and use the accessors you defined in your module's configuration file to fetch each fields data (`{!! $form->inputs or '' !!}`) - you can have as many layouts as you wish.
