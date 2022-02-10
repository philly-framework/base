<p align=center>
  <img src="https://raw.githubusercontent.com/elephox-dev/.github/main/profile/logo.svg" alt="Elephox Logo" height=100>
</p>

<p align=center>
  This is a library project providing building blocks for building your own PHP application.
</p>

<p align="center">
  <a href="https://packagist.org/packages/elephox/framework"><img src="https://poser.pugx.org/elephox/framework/v" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/elephox/framework"><img src="https://poser.pugx.org/elephox/framework/license" alt="License"></a>
  <a href="https://packagist.org/packages/elephox/framework"><img src="https://poser.pugx.org/elephox/framework/require/php" alt="PHP Version Require"></a>
  <a href="https://shepherd.dev/github/elephox-dev/framework"><img src="https://shepherd.dev/github/elephox-dev/framework/level.svg" alt="Psalm Level"></a>
  <a href="https://shepherd.dev/github/elephox-dev/framework"><img src="https://shepherd.dev/github/elephox-dev/framework/coverage.svg" alt="Type Coverage"></a>
  <a href="https://coveralls.io/github/elephox-dev/framework?branch=develop"><img src="https://coveralls.io/repos/github/elephox-dev/framework/badge.svg?branch=main" alt="Coverage Status"></a>
  <a href="https://dashboard.stryker-mutator.io/reports/github.com/elephox-dev/framework/develop"><img src="https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Felephox-dev%2Fframework%2Fdevelop" alt="Mutation Score Indicator"></a>
  <a href="https://github.com/elephox-dev/framework/actions/workflows/ci.yml"><img src="https://github.com/elephox-dev/framework/actions/workflows/ci.yml/badge.svg" alt="CI"></a>
</p>

## 📚 Documentation

Visit [elephox.dev](https://elephox.dev) for the documentation.

## 🎯 Goals

### 🔳 Open

- [ ] Caching Services
- [ ] Add a formatter (PHP CS Fixer)
- [ ] Add README, LICENSE and PHPUnit configs for all modules
- [ ] Finish PIE implementation (grouping)
- [ ] Add bin to Http module to update mime types (and extensions) automatically (wget -qO- http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types | egrep -v ^# | awk '{ for (i=2; i<=NF; i++) {print $i" "$1}}' | sort)
- [ ] Implement GitHub release in release script
- [ ] Provide an easier way to create a development environment (Docker, Vagrant, NixOS?)
- [ ] Publish PHPUnit HTML coverage report
- [ ] Publish benchmark report against baseline
- [ ] Implement [PSR-3](https://www.php-fig.org/psr/psr-3) adapter for Logging Services
- [ ] Implement [PSR-7](https://www.php-fig.org/psr/psr-7) adapter for HTTP
- [ ] Implement [PSR-17](https://www.php-fig.org/psr/psr-17) adapter for HTTP
- [ ] Implement [PSR-15](https://www.php-fig.org/psr/psr-15) adapter for Core
- [ ] Implement [PSR-6](https://www.php-fig.org/psr/psr-6) adapter for Caching Services
- [ ] Implement [PSR-16](https://www.php-fig.org/psr/psr-16) adapter for Caching Services
- [ ] Implement [PSR-14](https://www.php-fig.org/psr/psr-14) adapter for Event Bus
- [ ] Add [phpspy](https://github.com/adsr/phpspy) and flame graphs 🔥
- [ ] Maybe: Templating Adapter
- [ ] Maybe: Twig Adapter Implementation
- [ ] Create async application servers, like [laravel/octane](https://github.com/laravel/octane)
- [ ] Maybe: Implement [PSR-13](https://www.php-fig.org/psr/psr-13) adapter for Templating Adapter
- [ ] Maybe: Implement and provide [PSR-20](https://github.com/php-fig/fig-standards/blob/master/proposed/clock.md) adapter

### ☑️ Done

- [x] ~~Dependency Injection~~
- [x] ~~DI Container~~
- [x] ~~DI Dynamic object lifespan (request/transient)~~
- [x] ~~Implement [PSR-11](https://www.php-fig.org/psr/psr-11) in DI~~
- [x] ~~composer.json dependency sync~~ (see [elephox-dev/composer-module-sync](https://github.com/elephox-dev/composer-module-sync))
- [x] ~~Http Messages~~
- [x] ~~Optimize common workflow (re-use coverage data)~~
- [x] ~~(basic) Filesystem~~
- [x] ~~Routing (controller attributes)~~
- [x] ~~Logging Services~~
- [x] ~~Create a makefile with useful shortcuts~~ (Created composer.json scripts instead)
- [x] ~~Event Bus~~
- [x] ~~Split existing PSR implementations into different third-party adapters~~
- [x] ~~Integrate PIE into Collections~~
- [x] ~~New documentation solution~~ see [elephox.dev](https://elephox.dev)!

<!-- start annotations -->

## 📋 Source code annotations

### ✅ TODO

- [ ] [Collection/src/IsKeyedEnumerable.php](https://github.com/elephox-dev/framework/tree/main/modules/Collection/src/IsKeyedEnumerable.php)
  - [ ] rewrite more functions to use iterators
- [ ] [Collection/src/Iterator/OrderedIterator.php](https://github.com/elephox-dev/framework/tree/main/modules/Collection/src/Iterator/OrderedIterator.php)
  - [ ] cache keys
- [ ] [Http/src/ResponseCode.php](https://github.com/elephox-dev/framework/tree/main/modules/Http/src/ResponseCode.php)
  - [ ] go over the reason phrases and check them against standards

### 🤔 MAYBE

- [ ] [Collection/src/Iterator/ReverseIterator.php](https://github.com/elephox-dev/framework/tree/main/modules/Collection/src/Iterator/ReverseIterator.php)
  - [ ] only reverse key order if key is numeric


### 🚧 Open issues from other repositories

- [vimeo/psalm](https://github.com/vimeo/psalm)
  - [#7322](https://github.com/vimeo/psalm/issues/7322)

<!-- end annotations -->

- [PUGX/badge-poser](https://github.com/PUGX/badge-poser)
  - [#705](https://github.com/PUGX/badge-poser/issues/705)
