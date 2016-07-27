#Outline Captcha
 ![Outline capture](/samples/outline.png "title")
 
 
Light weight captcha image generator for php based web projects. It consists of just one file and three sample fonts. ImageMagic is used for image generation. 

## How it looks
### Default settings


| ![Outline capture default](/samples/default1.png "Default 1") | ![Outline capture default](/samples/default2.png "Default 2") | ![Outline capture default](/samples/default3.png "Default 3") |
| ------------- |:-------------:| -----:|
| sample 1      | sample 2 | sample 3 | 



### Deviations

One can adjust generated string length, resulting image size in pixels, text color and background color. 

| ![Outline capture sample](/samples/possible1.png "Sample 4") | ![Outline capture sample](/samples/possible3.png "Sample 5") | ![Outline capture sample](/samples/possible4.png "Sample 6") |
| ------------- |:-------------:| -----:|
| sample 4      | sample 5 | sample 6 | 

## How to use
PHP in general
```php
$captcha =  new OutlineCaptcha();
$captcha->setFontPath('/path/to/fonts'); 
$captchaInfo = $captcha->createCaptchaImage();

$captchaString = $captchaInfo["string"];
$captchaImage = $captchaInfo["image"];
```
```php
<img src="<?php $captchaImage ?>"/>
```
Laravel
```php
$captcha =  $this->app->make('OutlineCaptcha');
$captchaInfo = $captcha->createCaptchaImage();

$captchaString = $captchaInfo["string"];
$captchaImage = $captchaInfo["image"];
```
```php
<img src="{!! $captchaImage !!}"/>
```
Overriding default settings
```php
$captchaOptions = [
            "width"=>150,
            "height"=>100,
            "length"=>3,
            "fileType"=>"png",
            "color"=>'rgb(133, 244, 199)',
            "background"=>'rgb(33, 77, 77)'
        ];
$captcha =  new OutlineCaptcha($captchaOptions);
// Laravel
// $captcha =  $this->app->make('OutlineCaptcha', [$captchaOptions]);
```
## How to install

Copy OutlineCaptcha.php to your application classes directory. Copy outlineFonts folder to your application resources.
For the program to know where the fonts are you should either:

* Call __setFontPath__ funtion like $captcha->setFontPath('/path/to/fonts') every time you create __OutlineCaptcha__ class.

or:

* Adjust the fisrt line of  __OutlineCaptcha__ class constructor. 

## Some more information

Some options can result in totally unreadable captcha image. 
* When you decrease image pixel length it is harder to read the resulting captcha and reverse. 
* When you increase captcha string length it is harder to read the resulting captcha and reverse. 

Try to use simple and distinctive colors.




## License
The Outline Captcha utility is open-sourced software licensed under the MIT license.
