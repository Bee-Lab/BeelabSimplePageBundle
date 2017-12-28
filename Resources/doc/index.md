BeelabSimplePageBundle Documentation
====================================

1. [Installation](#1-installation)
2. [Configuration](#2-configuration)
3. [Usage](#3-usage)
4. [Complete configuration](#3-complete-configuration)

### 1. Installation

Run from terminal:

```bash
$ composer require beelab/simple-page-bundle
```

If you don't use Flex, enable bundle in the kernel:

```php
<?php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = [
        // ...
        new Beelab\SimplePageBundle\BeelabSimplePageBundle(),
    ];
}
```

### 2. Configuration

Create a `Page` entity class.
Example:

```php
<?php
// src/AppBundle/Entity
namespace AppBundle\Entity;

use Beelab\SimplePageBundle\Entity\Page as BasePage;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Page extends BasePage
{
    // add your custom properties and methods, if any
}
```

Insert in main configuration:

```yaml
# app/config/config.yml

# BeelabSimplePage Configuration
beelab_simple_page:
    page_class: AppBundle\Entity\Page
```

Add to your routing configuration:

```yaml
# app/config/routing.yml

# your other routes...

page:
    path: /{path}
    defaults: { _controller: BeelabSimplePageBundle:Default:show, path: '' }
    requirements:
        path: "^(?!img\/|css\/|js\/).+"
```

> ⚠️️ **Warning**: The `page` route must be placed at the very end of your routing file,
> since it uses a catch-all parameter. If you put any other route after `page` route,
> it won't work.

Note that `page` route is not matching for canonical URLs for images, styles and JavaScripts. Feel free to adapt
the regular expression to match your assets directories.

### 3. Usage

Just create some pages and use them in your website.

This bundle provides a basic template. You can create your custom template and tell the bundle
to use it.
Suppose you created a template inside `AppBundle\Resources\views\Page\default.html.twig`,
you can add this to configuration:

```yaml
# app/config/config.yml

# BeelabSimplePage Configuration
beelab_simple_page:
    page_class: AppBundle\Entity\Page
    resources_prefix: 'AppBundle:Page:'
```

If you prefer a solutions suitable with official best practices, you can use the same option like so:
```yaml
# app/config/config.yml

beelab_simple_page:
    resources_prefix: 'PageTemplate/'
```
and put your page templates under `app/Resources/views/PageTemplate/` directory of your project.

You can also create different templates with other names than `default`. If you do so, you should add that new
templates inside the `$templates` static property of your page entity.

Likely, you'll want to create a CRUD for pages. If so, you must be aware that the `path` property of
`Page` must not start with a slash (because of the way the `page` route is built).

### 4. Complete Configuration

The following is the complete configuration, with default values:

```yaml
beelab_simple_page:
    page_class: ~
    resources_prefix: 'BeelabSimplePageBundle:Default:'
    show_route: true
```

The last option can be used to customize the behavior of validation. The default validation checks if the path
submitted by user is contained in an existing route. Whit `show_route` options set to `true` (default value),
the name of the matching route is displayed in the error message. Using `false`, the route name will be omitted.
