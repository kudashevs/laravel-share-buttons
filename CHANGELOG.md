# Changelog

All Notable changes to `laravel-share-buttons` will be documented in this file

## [v1.1.5 - 2021-12-22](https://github.com/kudashevs/laravel-share-buttons/compare/v1.1.5...v1.1.4)

- Update README.md file
- Fix README.md the language filename

## [v1.1.4 - 2021-12-21](https://github.com/kudashevs/laravel-share-buttons/compare/v1.1.4...v1.1.3)

- Add a hacker news share provider
- Add a skype share provider
- Some improvements

## [v1.1.3 - 2021-12-21](https://github.com/kudashevs/laravel-share-buttons/compare/v1.1.3...v1.1.2)

- Add a pocket share provider
- Fix ShareButtonsFacade docblock with signatures

This release requires the `share-buttons.php` config file update.

## [v1.1.2 - 2021-12-21](https://github.com/kudashevs/laravel-share-buttons/compare/v1.1.1...v1.1.2)

- Add a pocket share provider
- Update the facebook provider with default text
- Some style improvements

This release requires the `share-buttons.php` config file update.

## [v1.1.1 - 2021-12-21](https://github.com/kudashevs/laravel-share-buttons/compare/v1.1.0...v1.1.1)

- Add templaters to use in formatters
- Some improvements

## [v1.1.0 - 2021-12-20](https://github.com/kudashevs/laravel-share-buttons/compare/v1.0.2...v1.1.0)

- Move share URL query string to the config
- Add usage of templaters to the share provider abstraction
- Add a new options parsing flow to the share provider abstraction
- Update share providers with usage of a templater
- Refactor the providers factory to hide providers list
- Add createInstance() method to the providers factory
- Some improvements

This release requires the `share-buttons.php` config file update because of some changes in its format.  
Please update the `url` keys in `providers` section manually, or delete the file and then publish a new
config file with the `php artisan vendor:publish` command.

## [v1.0.2 - 2021-12-15](https://github.com/kudashevs/laravel-share-buttons/compare/v1.0.1...v1.0.2)

- Move share URL query string to providers
- Some style improvements

## [v1.0.1 - 2021-12-11](https://github.com/kudashevs/laravel-share-buttons/compare/v1.0.0...v1.0.1)

- Add Laravel 6 to run-tests action
- Some style improvements

## v1.0.0 - 2021-12-11

- Initial release
