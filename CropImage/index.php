<?php

/**
 * https://github.com/tapmodo/Jcrop < Original
 * Jcrop image cropping plugin for jQuery
 * Example cropping script
 * @copyright 2008-2009 Kelly Hallman
 * More info: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
 * I changed copy paste convert function vs.vs.
*/

if (isset($_POST)){
	$targ_w = $targ_h = 150;
	$jpeg_quality = 90;
	$save=false;
	
	$src = 'demo_files/pool.jpg';
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

if($save)	imagejpeg($dst_r,"cropped.jpg",$jpeg_quality);
else{
	header('Content-type: image/jpeg');
	imagejpeg($dst_r,null,$jpeg_quality);
}
	exit;
}

?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" href="jquery.Jcrop.min.css" type="text/css" />
<script src="jquery.min.js"></script>
</head>
<body>

<img src="demo_files/sago.jpg" id="target" alt="[Jcrop Example]" />
<form action="crop.php" method="post" onsubmit="return checkCoords();">
<input type="hidden" id="x" name="x" />
<input type="hidden" id="y" name="y" />
<input type="hidden" id="w" name="w" />
<input type="hidden" id="h" name="h" />
<input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
</form>
<script src="jquery.Jcrop.min.js"></script>
<script type="text/javascript">

var jcrop_api;
jQuery(function($){
    initJcrop();
function initJcrop(){
      $('.requiresjcrop').hide();
      $('#target').Jcrop({
		onChange:   showCoords,
		allowSelect: true,
		allowMove:true,
		allowResize:true,
		aspectRatio: 16 / 6,
		bgOpacity: .4
		},function(){
        jcrop_api = this;
		jcrop_api.animateTo([0,0,1600,600]);
      });
    };

  function showCoords(c){
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    $('#w').val(c.w);
    $('#h').val(c.h);
	return;
  };

	/*
	jcrop_api.setSelect(getRandom());
	jcrop_api.animateTo(getRandom());
	jcrop_api.release();
	jcrop_api.disable();
	jcrop_api.enable();
  initJcrop();
	jcrop_api.destroy();
  jcrop_api.setImage('demo_files/sago.jpg');
	jcrop_api.setImage('demo_files/sago.jpg',function(){
	this.setOptions({bgOpacity: 1,outerImage: 'demo_files/sagomod.jpg'});
	this.animateTo(getRandom());
  
  jcrop_api.setOptions({allowSelect: false, allowMove:false, allowResize:false, aspectRatio: 4/3, bgOpacity: .6 });
	});
  jcrop_api.focus();
});

jcrop_api.setOptions({minSize: [ 80, 80 ],maxSize: [ 350, 350 ]});
jcrop_api.focus();

and detailed, original file in 
https://github.com/tapmodo/Jcrop

*/

});
</script>
</body>
</html>

