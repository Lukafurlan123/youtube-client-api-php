<?php
/**
 * Created by PhpStorm.
 * User: Lukafurlan
 * Date: 8/7/2016
 * Time: 2:16 PM
 */

require_once("youtube.class.php");
$youtube = new Youtube(array('apiKey' => 'AIzaSyCmRIl331uJ-l7ntHcyaXDHlUiEflqUXfw'));
$youtube->setApiName('videos');
$youtube->setYoutubeId('2-DkkbRXeOQ');
$youtube->setYoutubePart('snippet');
$youtube->setYoutubeState('decoded');
$return = $youtube->execute();
echo '<pre>';
print_r($return);
echo '</pre>';