# Rolebase System

[![Latest Version on Packagist](https://img.shields.io/packagist/v/role/rolebasesystem.svg?style=flat-square)](https://packagist.org/packages/role/rolebasesystem)
[![Total Downloads](https://img.shields.io/packagist/dt/role/rolebasesystem.svg?style=flat-square)](https://packagist.org/packages/role/rolebasesystem)
[![License](https://img.shields.io/github/license/kaushaltest/rolebasesystem.svg?style=flat-square)](LICENSE.md)

The Role-Based System Laravel Package provides a robust and flexible role management solution for Laravel applications. Easily implement and manage user roles, permissions, and access control with this package.

## Features

- Define and manage user roles with associated permissions.
- Grant or revoke permissions to roles and individual users.
- Protect routes and actions based on user roles and permissions.
- Simplified and intuitive API for role and permission management.
- Integration with Laravel's built-in authentication system.
- Easily extendable and customizable to fit your application's needs.

## Installation

You can install the package via composer:

```bash
composer require role/rolebasesystem
```
## Migration

- After you install package you have to migrate tables. 
- You must check first you env file have DB connection ? if no then first connect you DB. 
- Your DB connection is success then hit this command:

```bash
php artisan migrate
```