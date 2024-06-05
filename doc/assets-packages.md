# BitBag SyliusMailTemplatePlugin

[⬅️ Back to Installation](./installation.md)

## Overview
* [Installation - Add required packages directly to your project](#installation---add-required-packages-directly-to-your-project)
* [Installation - Add required packages using Yarn Workspaces](#installation---add-required-packages-using-yarn-workspaces)

## Installation - Add required packages directly to your project

1. Install packages required by the plugin:

```console
yarn add axios
yarn add codemirror@5.65.1
```

## Installation - Add required packages using Yarn Workspaces

1. Set package privacy and version settings.

```jsonc
// package.json

{
    "private": true,
    "version": "1.0.0",
}
```

2. Configure Yarn Workspaces

```jsonc
// package.json

{
    "private": true,
    "version": "1.0.0",
    "workspaces": [
        "vendor/bitbag/mailtemplate-plugin/package.json"
    ]
}
```

3. Install Dependencies:

```console
yarn install
```