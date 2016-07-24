#Outline Captcha

Light weight captcha image generator for php based web projects. It consists of just one file and tree sample fonts. ImageMagic is used for image generation. 

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
```php
$captchaOptions = [
            "width"=>150,
            "height"=>100,
            "length"=>3,
            "fileType"=>"png",
            "color"=>'rgb(133, 244, 199)',
            "background"=>'rgb(33, 77, 77)'
        ];

        $captcha =  $this->app->make('Captcha', [$captchaOptions]);

        $captchaInfo = $captcha->createCaptchaImage();
```

## License
The Outline Captcha utility is open-sourced software licensed under the MIT license.
