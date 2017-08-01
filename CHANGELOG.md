#Teknoo Software - Mango Pay Bundle - Change Log

###[1.0.7] - 2017-08-01
###Updated
- Update dev libraries used for this project and use now PHPUnit 6.2 for tests.

###[1.0.6] - 2017-07-23
###Removed
- Remove support of PHP 5.6, because Doctrine stop support PHP 5.x

###Updated
- Set methods GET for _teknoo_mangopay_secure_flow_return and _teknoo_mangopay_card_regitration_return

###[1.0.5] - 2017-02-18
###Fix
- Code style fix
- License file follow Github specs
- Add tools to checks QA, use `make qa` and `make test`, `make` to initalize the project, (or `composer update`).
- Update Travis to use this tool
- Fix QA Errors

##[1.0.4] - 2017-01-27
###Removed
- Remove support of PHP5.5 (non supported by PHP Group and incompatibility with last versions of Twig)

###Added
- Add LegalPersonType transcription in UserTranscriber (Merge from quef)

###Fixed
- Missing LegalPersonType transcription in UserTranscriber

##[1.0.3] - 2016-08-04
###Fixed
- Improve optimization on call to native function and optimized
- Form type : Remove deprecated use canonical type class name instead of string identifier
- Fix tests issues

##[1.0.2] - 2016-07-26
###Fixed
- Fix code style with cs-fixer
- Remove legacy reference to Uni Alteri

###Added
- Improve documentation and add api documention

##[1.0.1] - 2016-04-09
###Fixed
- Fix code style with cs-fixer

##[1.0.0] - 2016-02-11
###Fixed
- Stable release

##[1.0.0-rc2] - 2016-02-02
###Fixed
- composer minimum requirements

##[1.0.0-rc1] - 2016-01-22
###Fixed
- .gitignore clean

##[1.0.0-beta2] - 2015-10-26
###Changed
- Migrate library from Uni Alteri Organization to Teknoo Software

##[1.0.0-beta1] - 2015-09-04
- First beta, extracted from Uni Alteri 's project VizitMe.

