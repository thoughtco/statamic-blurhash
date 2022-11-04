
![Screenshot](./screenshot.png)

## Blur Hash

An add-on for Statamic that encodes, decodes and generates [Blur Hash](https://github.com/woltapp/blurhash) images to use as placeholders during image loading.

## Installation

First, require BlueHash as a Composer dependency:

```
composer require thoughtco/statamic-blurhash
```

Optionally, you may publish the config file for the [BlurHash library](https://github.com/bepsvpt/blurhash) this addon makes use of, allowing you finer control over the image output.

```
php artisan vendor:publish --provider="Bepsvpt\Blurhash\BlurHashServiceProvider"
```


## Usage

This add-on provides a number of tags:

### Outputting a BlurHash image

 `{{ blur_hash:image }}` or `{{ blur_hash image="path_or_asset" }}`

This tag will output an encoded image in the following format:

`<img src="data:image/png;base64,iVBOR…8f8luO3RPLKe4AAAAAElFTkSuQmCC" />`

Any other parameters you pass will be added to the tag, for example:

 `{{ blur_hash:image width="640" height="640" onload="console.log('loaded')" }}`

will output as:

`<img src="data:image/png;base64,iVBOR…8f8luO3RPLKe4AAAAAElFTkSuQmCC" width="640" height="640" onload="console.log('loaded')" />`

If you want to override the output, you can publish the view to your own views folder by running:

```
php artisan vendor:publish --tag="statamic-blurhash"
```

it will then be found at `resources/views/vendor/statamic-blurhash/output.blade.php`


### Encoding a BlurHash image

`{{ blur_hash:encode image="path_or_asset" }}`

This will return a BlurHash encoded URL, useful if you want to return this to JavaScript or a 3rd party service (such as Algolia).


### Decoding a BlurHash image

`{{ blur_hash:decode hash="string" }}`

This will decode an BlurHash string to an image, following the same conventions as `Outputting a BlurHash image`.


## Support

BlurHash is a free addon so support is provided on an as-we-have-capacity basis. If you have a feature request or experience a bug, please [open a GitHub Issue](https://github.com/thoughtco/statamic-blurhash).

Only the latest version of this addon is supported. If you open a bug report using an old version, your issue will be closed.
