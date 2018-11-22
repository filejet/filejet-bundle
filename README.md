# FileJet bundle

Provides seamless integration of FileJet service with your [Symfony](https://symfony.com/) based project.

For plain PHP library and FileJet documentation visit [filejet/filejet-php](https://github.com/filejet/filejet-php) repository.

## Installation

You can install FileJet bundle easily via [Composer](https://getcomposer.org/):

```bash
composer require filejet/filejet-bundle ^1.0
```

After installation [register the bundle](https://symfony.com/doc/3.4/bundles.html) with Symfony's bundles system.

## Configuration

You need to provide API key and Storage ID within your config file:

```yaml
file_jet:
    storage_id: <your storage id>
    api_key: <your api key>
```

## Usage

Bundle provides a Twig extension for generating the public and private (signed) URLs of your files.

```twig
file_url(publicFile, 'sz_100_100')
private_file_url(privateFileIdentifier, expiresInSeconds)
```

`file_url` accepts object which needs to implement `FileJet\FileInterface` interface. As second argument you can optionally provide mutation string (if you want to generate URL of image) - see [mutations documentation](https://github.com/filejet/filejet-php)

`private_file_url` accepts file identifier string as first argument and number of seconds the signed URL will be valid. The function internaly contacts FileJet API and returns signed URL for private files. This function can be used for files with sensitive information because the file is not publicly accessible the download link is valid only for the selected time period and then it expires. Each call of this function is contacting FileJet API hence the function cam be quite costly. 

Bundle also provides `@FileJet\FileJet` service which is automatically wired to the Symfony's container. The documentation can be found at [filejet/filejet-php](https://github.com/filejet/filejet-php/blob/master/mutators.md).
