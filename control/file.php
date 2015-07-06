<?
/*
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
*/

include("config.php");

function Image($image, $crop = null, $size = null) {
    // $image = ImageCreateFromString(file_get_contents($image));
    if (is_resource($image) === true) {
        $x = 0;
        $y = 0;
        $width = imagesx($image);
        $height = imagesy($image);

        /* CROP (Aspect Ratio) Section */
        if (is_null($crop) === true) {
            $crop = array($width, $height);
        }

        else {
            $crop = array_filter(explode(':', $crop));
            if (empty($crop) === true) {
                $crop = array($width, $height);
            }

            else {
                if ((empty($crop[0]) === true) || (is_numeric($crop[0]) === false))
                {
                    $crop[0] = $crop[1];
                }
                else if ((empty($crop[1]) === true) || (is_numeric($crop[1]) === false)) {
                    $crop[1] = $crop[0];
                }
            }

            $ratio = array (
                0 => $width / $height,
                1 => $crop[0] / $crop[1],
                );

            if ($ratio[0] > $ratio[1]) {
                $width = $height * $ratio[1];
                $x = (imagesx($image) - $width) / 2;
            }

            else if ($ratio[0] < $ratio[1]) {
                $height = $width / $ratio[1];
                $y = (imagesy($image) - $height) / 2;
            }

                /*
                How can I skip (join) this operation
                with the one in the Resize Section?
                */
                $result = ImageCreateTrueColor($width, $height);

                if (is_resource($result) === true) {
                    ImageSaveAlpha($result, true);
                    ImageAlphaBlending($result, false);
                    ImageFill($result, 0, 0, ImageColorAllocateAlpha($result, 255, 255, 255, 127));

                    ImageCopyResampled($result, $image, 0, 0, $x, $y, $width, $height, $width, $height);

                    $image = $result;
                }
            }

            /* Resize Section */
            if (is_null($size) === true) {
                $size = array(imagesx($image), imagesy($image));
            }

            else {
                $size = array_filter(explode('x', $size));
                if (empty($size) === true) {
                    $size = array(imagesx($image), imagesy($image));
                }

                else {
                    if ((empty($size[0]) === true) || (is_numeric($size[0]) === false)) {
                        $size[0] = round($size[1] * imagesx($image) / imagesy($image));
                    }

                    else if ((empty($size[1]) === true) || (is_numeric($size[1]) === false)) {
                        $size[1] = round($size[0] * imagesy($image) / imagesx($image));
                    }
                }
            }

            $result = ImageCreateTrueColor($size[0], $size[1]);

            if (is_resource($result) === true) {
                ImageSaveAlpha($result, true);
                ImageAlphaBlending($result, true);
                ImageFill($result, 0, 0, ImageColorAllocate($result, 255, 255, 255));
                ImageCopyResampled($result, $image, 0, 0, 0, 0, $size[0], $size[1], imagesx($image), imagesy($image));
                header('Content-Type: image/jpeg');
                ImageInterlace($result, true);
                ImageJPEG($result, null, 90);
            }
        }

        return false;
    }

    ini_set('display_errors', 1);

    $id=$_GET["id"];
    $table=$_GET["table"];
    $field=$_GET["field"];
    $width=$_GET["width"];
    $height=$_GET["height"];
    $action=$_GET["action"];
    $ratio=$_GET["ratio"];
    $Types = array(
    "474946383761"=>"image/gif",                        //GIF87a type gif
    "474946383961"=>"image/gif",                        //GIF89a type gif
    "89504E470D0A1A0A"=>"image/png",
    "FFD8FFE0"=>"image/jpeg",                           //JFIF jpeg
    "FFD8FFE1"=>"image/jpeg",                           //EXIF jpeg
    "FFD8FFE8"=>"image/jpeg",                           //SPIFF jpeg
    "25504446"=>"application/pdf",
    "377ABCAF271C"=>"application/zip",                  //7-Zip zip file
    "504B0304"=>"application/zip",                      //PK Zip file ( could also match other file types like docx, jar, etc )
    );

//include ("admin/config.php");
//$query = "select `media` from `media` where id=$id ";
//echo $query;
//$result = $dbpdo->query($query);

    $stmt = $dbpdo->prepare("select `media` from `media` where id=:id ");
// echo "select id from users WHERE title = '$_GET[site_title]'  ";
    $stmt->execute(array(':id' => $id));
    $mysql_result = $stmt->fetch(PDO::FETCH_BOTH);

//$mysql_result = $result->fetch(PDO::FETCH_BOTH);
//$mysql_result = (array) $mysql_result;

$Signature = substr($mysql_result[0],0,6); //get first 60 bytes shouldnt need more then that to determine signature
$Signature = array_shift(unpack("H*",$Signature));
//if( stripos($Signature,$MagicNumber) === 0 )   echo $Mime;
if ($Signature=='89504e470d0a') {
    header("Content-type: image/png");
    echo  $mysql_result[0];
}
else {
    header("Content-type: image/jpeg");
    $im =  imagecreatefromstring($mysql_result[0]);
// list( $uploadWidth, $uploadHeight, $uploadType ) = getimagesize( $mysql_result[0]);
    $ex=imagesx($im);
// echo exif_imagetype($mysql_result[0]);
    $ey=imagesy($im);

    if ($width<=$ex && $action=='thumb') {
        $ratio=$ex/$width;
        $nw=$width;
        $nh=$ey/$ratio;
    // echo $exaize; echo $eyaize;
        $image_p = imagecreatetruecolor($nw,$nh);
        imagecopyresampled($image_p, $im, 0, 0, 0, 0, $nw, $nh, $ex, $ey);
        imagejpeg($image_p);
    }
    else if ($width<=$ex && $action=='const') {
    // echo $ex.'<br />';
    // echo $ey.'<br />';
        if ($ex>=$ey){
            $ratio=$ex/$width;
            $nw=$width;
            $nh=$ey/$ratio;
        }

        if ($ey>=$ex){
            $ratio=$ey/$width;
            $nh=$width;
            $nw=$ex/$ratio;
        }

    // echo $exaize; echo $eyaize;
        $image_p = imagecreatetruecolor($nw,$nh);
        imagecopyresampled($image_p, $im, 0, 0, 0, 0, $nw, $nh, $ex, $ey);
        imagejpeg($image_p);
    }
    else if ($width<=$ex && $action=='crop'){
        $nh=$width.'x'.$height;
        Image(  $im , $ratio, $nh);
    /*
    $original_aspect = $ex / $ey;
    $thumb_aspect = $width / $height;
    if($original_aspect >= $thumb_aspect) {
        // If image is wider than thumbnail (in aspect ratio sense)
        $new_height = $ey;
        $new_width = $ex / ($ey / $height);
        }
    else {
        // If the thumbnail is wider than the image
        $new_width = $width;
        $new_height = $ey/ ($ex / $width);
    }
    $thumb = imagecreatetruecolor($width, $height);
    imagecopyresampled($thumb,
    $im,
    0 - ($new_width - $width) / 2, // Center the image horizontally
    0 - ($new_height - $height) / 2, // Center the image vertically
    0, 0,
    $new_width, $new_height,
    $ex, $ey);
    imagejpeg($thumb);
    */
}
else{
    imagejpeg($im);
}
  // imagejpeg($im);
imagedestroy($im);
}
?>
