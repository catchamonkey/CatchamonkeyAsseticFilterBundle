##CatchamonkeyAsseticFilterBundle

[![Build Status](https://secure.travis-ci.org/catchamonkey/CatchamonkeyAsseticFilterBundle.png?branch=master)](https://travis-ci.org/catchamonkey/CatchamonkeyAsseticFilterBundle)  
[![Scrutinizer](https://scrutinizer-ci.com/g/catchamonkey/CatchamonkeyAsseticFilterBundle/badges/quality-score.png?b=master)](https://travis-ci.org/catchamonkey/CatchamonkeyAsseticFilterBundle)  
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8223103c-1bf3-4c14-bf0e-784f8994eda3/small.png)](https://scrutinizer-ci.com/g/catchamonkey/CatchamonkeyAsseticFilterBundle/)


Symfony2 bundles that provides a basic CSS minifier in the form of an assetic filter

##Installation via composer

Step 1)

```bash
composer require "catchamonkey/assetic-filter-bundle"
```

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


Or use it in your assetic config using apply_to (added in v0.2.0)

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
