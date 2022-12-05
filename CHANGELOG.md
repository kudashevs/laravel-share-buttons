# Changelog

All Notable changes to `laravel-share-buttons` will be documented in this file

## [v3.0.0 - 2022-12-05](https://github.com/kudashevs/laravel-share-buttons/compare/v2.2.0...v3.0.0)

- Increase the minimum supported PHP version to 7.4
- Add support for PHP 8.2 version
- Add support for Laravel 9
- Add a `templater` configuration option
- Remove the `throwException` configuration option
- Change the `share` alias rename to `sharebuttons`
- Change config `providers` rename to `buttons`
- Update the Laravel service provider
- Update README.md
- Massive refactoring

Breaking change: the container binding alias has changed from `share` to `sharebuttons`.

## [v2.2.0 - 2022-03-04](https://github.com/kudashevs/laravel-share-buttons/compare/v2.1.3...v2.2.0)

- Add a Xing share provider
- Add a Value object for calls
- Fix missed `currentPage` method
- Update README.md
- Some improvements and refactoring

## [v2.1.3 - 2022-02-11](https://github.com/kudashevs/laravel-share-buttons/compare/v2.1.2...v2.1.3)

- Add Laravel 9 support
- Change ShareProvider classes to final 
- Update ShareButtonsFacade with direct alias
- Update README.md
- Some improvements

## [v2.1.2 - 2022-01-31](https://github.com/kudashevs/laravel-share-buttons/compare/v2.1.1...v2.1.2)

- Update TemplateFormatter massive refactoring
- Update exception message generations with sprintf
- Fix README.md fix missed `mail to` service
- Update README.md
- Some improvements

## [v2.1.1 - 2021-12-29](https://github.com/kudashevs/laravel-share-buttons/compare/v2.1.0...v2.1.1)

- Fix style prefix for copylink and mailto icons

## [v2.1.0 - 2021-12-29](https://github.com/kudashevs/laravel-share-buttons/compare/v2.0.0...v2.1.0)

- Add a mailto share provider
- Fix CHANGELOG.md compare links
- Some improvements

## v2.0.0 - 2021-12-22

- Change the package templater
- Move representations from a language file to config
- Update README.md

This is a major release which has a breaking change. It removes the language file with representations.
