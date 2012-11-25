#CatchamonkeyAsseticFilterBundle

Symfony2 bundles that provides a basic CSS minifier in the form of an assetic filter

##Installation

Step 1) Download

The recommended method is via composer.  
Add the bundle as a dependency to your composer.json file

    {
        "require": {
            "catchamonkey/AsseticFilterBundle": "v0.1.0"
        }
    }

Now tell composer to install this new requirement

    php composer.phar update catchamonkey/AsseticFilterBundle

This will be installed into your vendor directory

Step 2) Register the Bundle in your kernel

    ```php
    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Catchamonkey\Bundle\AsseticFilterBundle\CatchamonkeyAsseticFilterBundle(),
        );
    }
    ```

Step 3) Configuration

Add the filter to the available filters in your assetic config

    ```yml
    #app/config/config.yml

    assetic:
        # ...
        filters:
            # ...
            catchamonkey_cssmin: ~

##Usage

Using the filter is as simple as adding it to a stylesheets tag

    ```twig
    #app/Resources/views/base.html.twig

    {% stylesheets filter='catchamonkey_cssmin'
        '@AcmeDemoBundle/Resources/public/css/*.css'
    %}
    <link rel="stylesheet" type="text/css" href="{{ asset_url }}" />
    {% endstylesheets %}