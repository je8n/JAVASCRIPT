<?php
function post($veriadi,$code=false,$default=null){
	if(isset($_POST[$veriadi])){
		if($code) return $_POST[$veriadi];
		else return strip_tags($_POST[$veriadi]);
	}
	return $default;
}
function imagecreatecommon($file){
	$extension = strtolower(strrchr($file, '.'));
	switch ($extension) {
		case '.jpg':
		case '.jpeg':
		$img = imagecreatefromjpeg($file);break;
		case '.gif':
		$img = imagecreatefromgif($file);break;
		case '.png':
		$img = imagecreatefrompng($file);break;
		default:
		$img = false;break;
	}
	return $img;
}
function crop($ext){

	$image = imagecreatecommon($ext["file"]);
	$gen=imagesx($image);
	$yuk =imagesy($image);
	$yenigen = $ext["re_width"];
	$yeniyuk = $ext["re_height"];

	$x_bolen=($ext["crop_height"] * 100) / $ext["js_height"];
	$yukseklik=($yuk * $x_bolen) / 100;

	$y_bolen=($ext["crop_width"] * 100) / $ext["js_width"];
	$genislik=($gen * $y_bolen) / 100;

	$y=($ext["y"] * 100) / $ext["js_width"];
	$gerceky=($gen * $y) / 100;

	$x=($ext["x"] * 100) / $ext["js_height"];
	$gercekx=($yuk*$x) / 100;



	$image_p = imagecreatetruecolor($yenigen, $yeniyuk);
	imagecopyresampled($image_p, $image, 0, 0, $gercekx, $gerceky,$yenigen,$yeniyuk, $genislik, $yukseklik);
	imagejpeg($image_p, $ext["dest"], 95);
}
$ratio_width=1600;
$ratio_height=500;
if (isset($_POST)){
	move_uploaded_file($tmp_dosyadi,$duyuru_img_dizin.$dosyadi);
	$ext["file"]=$img;
	$ext["dest"]=$img;
	$ext["x"]=post("x");
	$ext["y"]=post("y");
	$ext["re_width"]=$ratio_width; // bottom page script find at replace > ratio 16 / 6
	$ext["re_height"]=$ratio_height;
	$ext["js_width"]=post("jsw");
	$ext["js_height"]=post("jsh");
	$ext["crop_height"]=post("h");
	$ext["crop_width"]=post("w");
	crop($ext);
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

<form method="post" onsubmit="return checkCoords();">
	<div class="form-group">
	<label class="control-label"><strong>Duyuru Görüntüsü </strong></label>
	<div class="input-group">
		<input type="text" readonly class="form-control">
		<div class="input-group-btn">
		<input  style="display:none;" type="file" if="goruntu" name="gorsel" onChange="goruntu(this)" accept="image/*"/>
		<a tabindex="-1" class="btn btn-info" onclick='$(this).prev().click();' type="button"><i class="fas fa-file"></i> Belge Seç</a>
		</div>
	</div>

	</div>

	<div class="form-group onizleme">
	<div class="input-group">
	<img id="target"/>
	</div>

	</div>
	
	<input type="hidden" id="x" name="x" />
	<input type="hidden" id="y" name="y" />
	<input type="hidden" id="w" name="w" />
	<input type="hidden" id="h" name="h" />
	<input type="hidden" id="jsw" name="jsw" />
	<input type="hidden" id="jsh" name="jsh" />
	<input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
</form>
<script src="jquery.Jcrop.min.js"></script>
<script type="text/javascript">

var jcrop_api=null;
//jQuery(function($){
	function initJcrop(){
		$('.requiresjcrop').hide();
		$('#target').Jcrop({
			onChange:   showCoords,
			allowSelect: true,
			allowMove:true,
			allowResize:true,
			aspectRatio: <?php echo $ratio_width; ?> / <?php echo $ratio_height; ?>,
			bgOpacity: .4
		},function(){
			jcrop_api = this;
			console.log(jcrop_api);
			//jcrop_api.animateTo([0,0,1600,600]);
		});
	}
//	initJcrop();
function showCoords(c){
	$('#x').val(c.x);
	$('#y').val(c.y);
	$('#w').val(c.w);
	$('#h').val(c.h);
	$("#jsw").val($(".jcrop-tracker:last").width());
	$("#jsh").val($(".jcrop-tracker:last").height());

};
//  jcrop_api.destroy();
	/*
	jcrop_api.setSelect(getRandom());
	jcrop_api.animateTo(getRandom());
	jcrop_api.release();
	jcrop_api.disable();
	jcrop_api.enable();
  initJcrop();
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
});
*/
	
function goruntu(input) {
	if(jcrop_api!=null){
		$(".jcrop-holder").remove();
		$(".onizleme img").remove();
		$(".onizleme").append('<img id="target"/>');
	}
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('.onizleme img').attr('src', e.target.result);
			$(input).parents(".input-group").find("input:first").val("Seçildi");
		}
		reader.readAsDataURL(input.files[0]);
	}
	setTimeout(function(){
		initJcrop();
		setTimeout(function(){jcrop_api.animateTo([0,0,<?php echo $ratio_width; ?>,<?php echo $ratio_height; ?>]);},1000);
	},3000);

}
});
</script>
</body>
</html>

