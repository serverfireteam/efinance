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
6. put efinance.wsdl in storage\app

7. edit the config file : efinance.php


## Simple Code 

1. submit new applications
    ```php
        Route::get('/', function(){

            $bef = new Serverfireteam\Efinance\bef_submitNewApplication();

            $bef->build_proposal('ProposalTypeCode', 'FTBNPS');
            $bef->build_proposal('InterestRateType', 1);
            $bef->build_proposal('InterestRate', '9.84');
            $bef->build_proposal('Term', 5);
            $bef->build_proposal('DeferralPeriod', 6);
            $bef->build_proposal('ClientReference', 'A11');
            $bef->build_proposal('CashPrice', 600);
            $bef->build_proposal('Deposit', 0);
            $bef->build_proposal('ThirdPartyCharge', 0);

            $bef->build_customer('Title', 'Mr');
            $bef->build_customer('Forename', 'Test');
            $bef->build_customer('Surname', 'Person');
            $bef->build_customer('EmailAddress', 'test@test.com');

            $bef->build_address('HouseNumber', '1');
            $bef->build_address('Street', 'A Street');
            $bef->build_address('District', 'A Locality');
            $bef->build_address('Town', 'A Town');
            $bef->build_address('County', 'A County');
            $bef->build_address('Postcode', 'A1 1AA');

            $bef->build_goods('CY0', 'Generic Bike', 1);
            $bef->build_goods('CY0', 'Generic Bike 2', 1);
            $bef->build_goods('CY0', 'Generic Bike 3', 1);

            $bef->call();

            echo 'Token:<br />';
            echo $bef->get_token();

            echo '<br /><br />Proposal ID:<br />';
            echo $bef->get_proposal_id();
        });
    ```
2. Cancel agreement


    ```php
        $bef = new Serverfireteam\Efinance\bef_cancelAgreement();

        $bef->build_customer('Title', 'Mr');
        $bef->build_customer('Forename', 'Test');
        $bef->build_customer('Surname', 'Person');
        $bef->build_customer('EmailAddress', 'test@test.com');

        $bef->build_agreement('AgreementNumber', '1');
        $bef->build_agreement('OriginalLoanAdvance', '1000.00');
        $bef->build_agreement('CancellationAmount', '1000.00');
        $bef->build_agreement('NewLoanAdvance', '0.00');
        $bef->build_agreement('CancellationType', 'full');
        $bef->build_agreement('ClientRequestReference', 'A4');

        $bef->call();
    ```
3. submit notification batch

    ```php
        $bef = new Serverfireteam\Efinance\bef_submitNotificationBatch();

        $bef->build_batch_reference('Test Batch');

        $bef->build_notifications('8435', '', 'A7', '600.00');
        $bef->build_notifications('8435', '', 'A7', '600.00');
        $bef->build_notifications('8435', '', 'A7', '600.00');

        $bef->call();

        echo 'Batch ID:<br />';
        echo $bef->get_batch_id();

        echo '<br /><br />Total Accepted:<br />';
        echo $bef->get_total_accepted();

        echo '<br /><br />Total Rejected:<br />';
        echo $bef->get_total_rejected();

        if($bef->get_total_rejected() > 0)
        {
            $rejections = $bef->get_rejection_reasons();

            echo '<pre>'; print_r($rejections); echo '</pre>';
        }
    ```
4. notification batch enquiry

    ```php
        $bef = new Serverfireteam\Efinance\bef_notificationBatchEnquiry();

        $bef->add_data('BatchID', 1234);
        $bef->add_data('Reference', 'Test Batch');

        $bef->call();
    ```
5. soap 
    ```php
        $bef = new Serverfireteam\Efinance\bef_proposalEnquiry();

        $bef->add_data('ClientReference', 'A4');
        $bef->add_data('ProposalID', 8323);

        $bef->call();
    ```