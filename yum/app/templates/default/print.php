<?php 
dump($page);
$image = '';
if(extension_loaded('gd')) {
    $img = imagecreatefromjpeg($page['meta']['image']);
    $cropped = imagecrop($img, ['x' => 10 , 'y' => 10, 'width' => 430, 'height' => 300]);
    $saved_image = ABS_PATH.'/content/images/'.$page['meta']['slug'].'.jpg';
    imagejpeg($cropped, $saved_image);
    $image = '<img src="http://'.$_SERVER['SERVER_NAME'].'/content/images/'.$page['meta']['slug'].'.jpg" width="200" style="float:left; margin-right:25px; margin-bottom:25px;">';
}

echo '<style>@media print{
    .noprint{
        display:none;
    }
 }</style>';
echo '<button class="noprint" style="margin-top:15px; margin-bottom:15px; cursor:pointer;" onclick="window.print()">Print this page</button>';
echo '<hr style="margin-top:10px; margin-bottom:20px;" class="noprint"/>';
echo $image;
echo '<h4 style="display:inline-block; margin-top:0px;">'.$page['taxonomy']['diet'].'</h4>';
echo '<h2 style="margin-bottom:50px;">'.$page['meta']['title'].'</h2>';
echo '<div>&nbsp;</div>'. $page['content'];





