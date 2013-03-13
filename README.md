#CatchamonkeyAsseticFilterBundle [![Build Status](https://secure.travis-ci.org/catchamonkey/CatchamonkeyAsseticFilterBundle.png?branch=master)](https://travis-ci.org/catchamonkey/CatchamonkeyAsseticFilterBundle)

Symfony2 bundles that provides a basic CSS minifier in the form of an assetic filter

##Installation

Step 1) Download

The recommended method is via composer.  
Add the bundle as a dependency to your composer.json file

```json
{
    "require": {
        "catchamonkey/assetic-filter-bundle": "v0.1.0"
    }
}
```

Now tell composer to install this new requirement

```bash
php composer.phar update
```

This will be installed into your vendor directory

Step 2) Register the Bundle in your kernel

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Catchamonkey\Bundle\AsseticFilterBundle\CatchamonkeyAsseticFilterBundle(),
    );
}
```

##Usage

Using the filter is as simple as adding it to a stylesheets tag

```smarty
#app/Resources/views/base.html.twig

{% stylesheets filter='catchamonkey_cssmin'
    '@AcmeDemoBundle/Resources/public/css/*.css'
%}
<link rel="stylesheet" type="text/css" href="{{ asset_url }}" />
{% endstylesheets %}
```


Or use it in your assetic config using apply_to

```yaml
#app/config/config.yml
# Assetic Configuration
assetic:
    debug:          %kernel.debug%
    use_controller: false
    bundles:        []
    filters:
        catchamonkey_cssmin:
            resource:
"%kernel.root_dir%/../vendor/catchamonkey/assetic-filter-bundle/Catchamonkey/Bundle/AsseticFilterBundle/Resources/config/services.xml"
            apply_to: "\.css$"
```
