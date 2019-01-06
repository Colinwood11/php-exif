<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Max
 * Date: 07/02/13  \r\n
 * Time: 11:44 AM
 * 假设读取的远程图片都是 jpg 格式；同时假设不存在相同文件名的情况。
 */
$target = $_GET['imurl'];                    //获取远程图片 URL
$filename = basename($target);             //获取远程图片的文件名
$filename_full = "./cache/$filename"; //设定保存远程图片的完整路径
if ( file_exists($filename_full) ) {
    //如果该文件已经存在于本地，则读取其内容
    $content = file_get_contents($filename_full);
} else {
    //如果该文件并不存在，则读取其内容并保存在本地以供将来调用
    $content = file_get_contents($target);
    $fp = fopen("./imag/$filename", 'w+');
    fwrite($fp, $content);
    fclose($fp);
}
$exif = read_exif_data ($filename_full);//读EXIF等至变量
foreach ($exif as $_=>$__){
    if($_=='FileDateTime')  $__=date('Y-m-d H:i:s',$__);
    if($_=='FileSize') $__=sizecount($__);
    $_ = str_replace("FileName","文件名",$_);
    $_ = str_replace("FileSize","文件大小",$_);
    $_ = str_replace("FileDateTime","文件时间",$_);
    $_ = str_replace("Model","*手机型号",$_);
    $_ = str_replace("Software","照片处理软件",$_);
    $_ = str_replace("ImageDescription","图像描述",$_);
    $_ = str_replace("Orientation","定位",$_);
    $_ = str_replace("DateTime","日期时间",$_);
    $_ = str_replace("ResolutionUnit","分辨率单位",$_);
    $_ = str_replace("YCbCrPositioning","YCbCr定位",$_);
    $_ = str_replace("YResolution","Y分辨率",$_);
    $_ = str_replace("XResolution","X分辨率",$_);
    $_ = str_replace("Make","牌子",$_);
    $__ = str_replace("Meizu","魅族",$__);//可以识别手机型号更换为中文
    $_ = str_replace("ColorSpace","色彩空间",$_);
    $_ = str_replace("FNumber","光圈值",$_);
    $_ = str_replace("DateTimeOriginal","原始日期",$_);
    $_ = str_replace("DateTimeDigitized","数码日期",$_);
    $_ = str_replace("ExposureProgram","曝光程序",$_);
    $_ = str_replace("FocalLength","焦距",$_);
    $_ = str_replace("WhiteBalance","白平衡",$_);
    $_ = str_replace("ExifImageWidth","Exif图像宽度",$_);
    $_ = str_replace("MeteringMode","测光模式",$_);
    $_ = str_replace("LightSource","光源",$_);
    $_ = str_replace("ExposureMode","曝光模式",$_);
    $_ = str_replace("ComponentsConfiguration","曝光配置",$_);
    $_ = str_replace("SubSecTimeDigitized","SubSecTime数码化",$_);
    $_ = str_replace("ExifVersion","EXIF版本",$_);
    $_ = str_replace("Flash","闪光灯",$_);
    $_ = str_replace("SceneCaptureType","场景Capture类型",$_);
    $_ = str_replace("ISOSpeedRatings","ISO",$_);
    $_ = str_replace("FlashPixVersion","FlashPix版本",$_);
    $_ = str_replace("ExposureTime","曝光时间",$_);
    $_ = str_replace("DigitalZoomRatio","数码变焦比",$_);
    $bs.="{$_}: {$__}<br>";
}
function sizecount($filesize) {
 if($filesize >= 1073741824) {
  $filesize = round($filesize / 1073741824 * 100) / 100 . ' gb';
 } elseif($filesize >= 1048576) {
  $filesize = round($filesize / 1048576 * 100) / 100 . ' mb';
 } elseif($filesize >= 1024) {
  $filesize = round($filesize / 1024 * 100) / 100 . ' kb';
 } else {
  $filesize = $filesize . ' bytes';
 }
 return $filesize;
}
