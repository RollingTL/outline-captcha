<?php
/**
 * Created by PhpStorm.
 * User: RollingTL
 * Date: 22.07.16
 * Time: 14:54
 */

// namespace App\Models\;

use Imagick;
use ImagickDraw;
use ImagickPixel;

class OutlineCapture
{
    const DEFAULT_FILE_TYPE = "png";
    const DEFAULT_LENGTH = 4;
    const DEFAULT_WIDTH = 150;
    const DEFAULT_HEIGHT = 50;
    const DEFAULT_COLOR = 'rgb(33, 33, 33)';
    const DEFAULT_BACKGROUND = 'rgb(244, 244, 244)';


    private $fileType;
    private $length;
    private $width;
    private $height;
    private $color;
    private $background;

    private $fontPath;


    private $fonts;

    public function __construct($options = null)
    {
        $this->fontPath = storage_path().'/app/captchaFonts/';
        $this->setOptions($options);
        $this->fonts = [
            'NTOutline.ttf',
            'GroticTitulOutlineHv.ttf',
            'JasperCapsOutlineNr.ttf'
        ];
        $this->fontsScaleFactors = [ 1.6, 1,0.9 ];
    }


    public function createCaptchaImage()
    {
        $captchaString =$this->generateRandomString($this->length);
        $stringLength = strlen($captchaString);
        $lettersStep = $this->width / $stringLength;

        $image = new Imagick();
        $image->newImage($this->width, $this->height, new ImagickPixel($this->background));
        $image->setImageFormat($this->fileType);


        for ($i = 0; $i < $stringLength; $i++) {

            $letter = substr($captchaString, $i, 1);
            $draw = new ImagickDraw();

            $draw->setStrokeWidth(1);
            $draw->setFillColor($this->color);

            $selectedFont = mt_rand(0, count($this->fonts) - 1);
            //$selectedFont = 0;
            $draw->setFont( $this->fontPath . $this->fonts[$selectedFont]);
            $draw->setFontSize(10);
            $metrics = $image->queryFontMetrics($draw, $letter);
            $letterWidth = $metrics["textWidth"];
            $letterHeight = $metrics["textHeight"];
            $scale = $this->calculateScale($this->height, $letterHeight);
            $draw->setFontSize(10*$scale*$this->fontsScaleFactors[$selectedFont]);

            $horizontalOffset = -$lettersStep/3 + $lettersStep * $i;
            $verticalOffset = $this->height;
            $angle =  mt_rand(-20, 20);

            $image->annotateImage($draw, $horizontalOffset, $verticalOffset, $angle, $letter);

            $draw->clear();
        }

        $imageData = $image->getImageBlob();
        $image->clear();

        $base64String = 'data:image/' . $this->fileType . ';base64,' . base64_encode($imageData);

        return ["string" => $captchaString , "image" => $base64String];
    }

    public function setFontPath ($path){
        $this->fontPath = rtrim($path, '/') . '/';
    }


    private function setOptions($options)
    {
        $this->setDefaultOptions();
        if (empty($options)) {
            return;
        }
        if (!empty($options["fileType"])) {
            $this->fileType = $options["fileType"];
        }
        if (!empty($options["length"])) {
            $this->length = $options["length"];
        }
        if (!empty($options["width"])) {
            $this->width = $options["width"];
        }
        if (!empty($options["height"])) {
            $this->height = $options["height"];
        }
        if (!empty($options["color"])) {
            $this->color = $options["color"];
        }
        if (!empty($options["background"])) {
            $this->background = $options["background"];
        }

    }

    private function setDefaultOptions()
    {
        $this->fileType = Captcha::DEFAULT_FILE_TYPE;
        $this->length = Captcha::DEFAULT_LENGTH;
        $this->width = Captcha::DEFAULT_WIDTH;
        $this->height = Captcha::DEFAULT_HEIGHT;
        $this->color = Captcha::DEFAULT_COLOR;
        $this->background = Captcha::DEFAULT_BACKGROUND;
    }

    private function calculateScale($imageHeight, $letterHeight){
        if($imageHeight>$letterHeight) {
            return $imageHeight/$letterHeight;
        }  else {
            return $letterHeight/$imageHeight;
        }
    }
    private function generateRandomString($length = 4) {
        $characters = 'ABCDEFGHKMNOPQRSUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}