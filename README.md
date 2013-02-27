# Joomla component and plugin for Uploadcare

A plugin and a component for [Joomla][5] to work with [Uploadcare][1]

It's based on a [uploadcare-php][4] library.

## Requirements

- Joomla 2.5+
- PHP 5.2+
- php-curl

## Install 

[Download the latest releases][3]. 

Install both "com_uploadcare*" and "plg_uploadcare" using "Extension Manager".

Enable component and plugin.

Go to "Components" -> "Uploadcare" -> "Options" and set publickey and secretkey.

## Usage

Start adding new content.

Under the editor you will find a "Uploadcare" button. Press it.

In new window you will see a widget. Select a file to upload and press "Store".

In new window select operations to be implemented on image.

Press "Insert" and image will be inserted inside editor.

[More information on file operations can be found here][2]

## Releases

### com_uploadcare

**1.0.1** ([Download](https://ucarecdn.com/72968548-786a-4c1c-9238-09abf9ea580c/com_uploadcare.zip))
* Bugfix

**1.0.0** ([Download](https://ucarecdn.com/c90ebb89-7e4f-44ce-9af5-decf116c35c5/com_uploadcare.zip))

### plg_uploadcare

**1.0.0**([Download](https://ucarecdn.com/c69c82dd-a982-438b-944f-c89287e5e1e8/plg_uploadcare.zip))

[1]: https://uploadcare.com/
[2]: https://uploadcare.com/documentation/reference/basic/cdn.html
[3]: https://github.com/uploadcare/uploadcare-joomla#releases
[4]: https://github.com/uploadcare/uploadcare-php
[5]: http://joomla.org/
