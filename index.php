<?php

require 'vendor/autoload.php';


function processVideo($videoSource,$reqExtension,$watermark)
{
    $ffmpeg = FFMpeg\FFMpeg::create();

    $video = $ffmpeg->open($videoSource);

    $format = new FFMpeg\Format\Video\X264('libmp3lame', 'libx264');

    if (!empty($watermark))
    {
        $video  ->filters()
                ->watermark($watermark, array(
                    'position' => 'relative',
                    'top' => 25,
                    'right' => 50,
                ));
    }

    $format
    -> setKiloBitrate(1000)
    -> setAudioChannels(2)
    -> setAudioKiloBitrate(256);

    $randomFileName = rand().".$reqExtension";
    $saveLocation = getcwd().$randomFileName;
    $video->save($format, $saveLocation);

    if (file_exists($saveLocation))
        return $randomFileName;
    else
        return "watermark.jpg";

}

echo $videoLocation =  processVideo("video.mp4","mp4","watermark.jpg");




?>