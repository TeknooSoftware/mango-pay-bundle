Teknoo Software - Mango Pay bundle
===========================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a181daad-0db5-46f0-ab9d-34c9ba72fffa/mini.png)](https://insight.sensiolabs.com/projects/a181daad-0db5-46f0-ab9d-34c9ba72fffa) [![Build Status](https://travis-ci.org/TeknooSoftware/mango-pay-bundle.svg?branch=master)](https://travis-ci.org/TeknooSoftware/mango-pay-bundle)

Bundle to import the MangoPay official PHP client into Symfony 2.7+ and use it into your
Symfony project

Usages
------

All API Endpoint client are available as services, they follow the official documentation :

    @mangopay.sdk.api_user.service
    @mangopay.sdk.api_wallet.service
    @mangopay.sdk.api_pay_ins.service
    @mangopay.sdk.api_pay_outs.service
    @mangopay.sdk.api_transfert.service:
    @mangopay.sdk.api_cards.service
    @mangopay.sdk.api_card_registrations.service
    @mangopay.sdk.api_card_pre_authorizations.service:
    @mangopay.sdk.api_refunds.service
    
The bundle manage the connection and the authentication on Mango's servers, it needs only the 
definition of these parmeters
 
    mangopay.client_id: "Provided by MangoPay"
    mangopay.client_passphrase: "Provided by MangoPay"
    mangopay.base_url: "https://api.mangopay.com/"
    mangopay.debug_mode: true/false
    
The bundle provides also several services to perform some complexe operations on MangoPay :
    
    @teknoo.mangopaybundle.service.card_registration to register a card, via an embedded form in your application, 
    managing 3D Secure and result of Mango Pay API via token exchange
    
    @teknoo.mangopaybundle.service.user to register an user in your MangoPay account to create a wallet for it for 
    purchase, refund or bank transfert
    
    @teknoo.mangopaybundle.service.secure_flow to perform a payment via MangoPay between two users and with optional
    fees for your services and MangoPay.

Installation & Requirements
---------------------------
To install this bundle

    composer require teknoo/mango-pay-bundle
    
And add to your AppKernel : 

    new Teknoo\MangoPayBundle\TeknooMangoPayBundle(),
    
Set parameters
    
    mangopay.client_id: "Provided by MangoPay"
    mangopay.client_passphrase: "Provided by MangoPay"
    mangopay.base_url: "https://api.mangopay.com/"
    mangopay.debug_mode: true/false
    
This library requires :

    * PHP 5.5+
    * Composer
    * Symfony 2.7+
    * Mango Pay API

Testing
-------
To make the bundle testable without connecting to the official API simply create a service named `mangopay.sdk.http_client`.
This client must implement `MangoPay\Libraries\HttpBase`.

Credits
-------
Richard Déloge - <richarddeloge@gmail.com> - Lead developer.
Teknoo Software - <http://teknoo.software>

About Teknoo Software
---------------------
**Teknoo Software** is a PHP software editor, founded by Richard Déloge. 
Teknoo Software's DNA is simple : Provide to our partners and to the community a set of high quality services or software,
 sharing knowledge and skills.

License
-------
Mango Pay Bundle is licensed under the MIT Licenses - see the licenses folder for details

Contribute :)
-------------

You are welcome to contribute to this project. [Fork it on Github](CONTRIBUTING.md)
