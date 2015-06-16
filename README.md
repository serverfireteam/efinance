# efinance for Laravel



##Installations for laravel 5

1. First you need to create a laravel 5 project

2. Add our package to require section of composer :

    ```json
    {
        "require": {
            "serverfireteam/efinance": "dev-master"
        },
    }
    ```
3. composer update 


4. Add the ServiceProvider of the package to the list of providers in the config/app.php file

    ```php
    'providers' => array(
        'Serverfireteam\Efinance\EfinanceServiceProvider'
    )
    ```

5. Run the following command in order to publish configs, views and assets.  

    ```bash
    php artisan vendor:publish

    ```

