# Joomla component and plugin for Uploadcare

This repository holds a plugin and a component that lets
[Joomla](https://joomla.org) work with [Uploadcare](https://uploadcare.com).

The stuff in this repo is based on the
[uploadcare-php][https://github.com/uploadcare/uploadcare-php] library.

## Requirements

- Joomla 2.5+
- PHP 5.2+
- php-curl

## Install 

First of, grab the latest releases
[here][https://github.com/uploadcare/uploadcare-joomla#releases].
Further install is performed via "Extension Manager".
Use it for both "com_uploadcare" and "plg_uploadcare".
Once it's done, enable installed component and plugin.

Go to "Components" -> "Uploadcare" -> "Options" and set your
`public_key` and `secret_key`. If you're not sure about the
keys, here's a [hint](https://uploadcare.com/documentation/keys/).

## Usage

You're now ready to start adding new content.
Discover and click the freshly appeared "Uploadcare" button
under the editor. It brings a widget upfront in a new window.
Pick a file you'd like to upload and hit "Store".

In case you're uploading an image file, you'll be able to pick
operations to be applied to an image in a new window.
Hit "Insert" and your image will be inserted into the editor.

Check out our [docs](https://uploadcare.com/documentation/cdn/)
for more info about file operations.

## Releases

### com_uploadcare

**1.0.2**, [Get][com_102]
* New widget version 0.6.3

**1.0.1**, [Get][com_101]
* Bugfix

**1.0.0**, [Get][com_100]

### plg_uploadcare

**1.0.0**, [Get][plg_100]

## Contributors

- [@grayhound](https://github.com/grayhound)
- [@dmitry-mukhin](https://github.com/dmitry-mukhin)

## Security issues

If you think you ran into something in Uploadcare libraries
which might have security implications, please hit us up at
[bugbounty@uploadcare.com](mailto:bugbounty@uploadcare.com)
or Hackerone.

We'll contact you personally in a short time to fix an issue
through co-op and prior to any public disclosure.

[com_102]: https://ucarecdn.com/0c0babce-c1cf-4b6f-b429-ee8fb473cb68/com_uploadcare.zip
[com_101]: https://ucarecdn.com/72968548-786a-4c1c-9238-09abf9ea580c/com_uploadcare.zip
[com_100]: https://ucarecdn.com/c90ebb89-7e4f-44ce-9af5-decf116c35c5/com_uploadcare.zip
[plg_100]: https://ucarecdn.com/c69c82dd-a982-438b-944f-c89287e5e1e8/plg_uploadcare.zip
