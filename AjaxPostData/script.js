function form_gonder(formid,urlx="",mFc="",dev=false){
	var data="";
	var cachex= true;
	var contentTypex= "application/x-www-form-urlencoded; charset=UTF-8";
	var processDatax= true;
	if(urlx=="")urlx="ajax.php";
	if(typeof formid==="object"){
		datax=formid;
	}else{
		var formel = $("#"+formid);
		var bos=0;
		if($("#"+formid).is('[bos]')){var bosatla=true;}else{bosatla=false;}
		if(!bosatla){
			formel.find("input,select,textarea").each(function(){
				if((!$(this).is('[bos]'))&&($(this).val()=="")){
					bos=1;
					$(this).css("border","1px solid #f00");
				}else{
					$(this).css("border","1px solid #0b0");
				}
				if($(this).is('[type]')&&($(this).attr("type")=="email")){
					if(!validateEmail($(this).val())){
						bos=2	;
						$(this).css("border","1px solid #f00");	
					}else{
						$(this).css("border","1px solid #0b0");
					}
				}
			});
		}
		if($("#"+formid).find('input[type="file"]').length>0){
			cachex= false;
			contentTypex= false;
			processDatax= false;	
			datax = new FormData(formel[0]);
		}else
			datax = formel.serialize();

	}
	if(bos==1){mFc("bosalan");return;}
	else if(bos==2){mFc("gecersiz");mFc($json);return;}
	else{
		$.ajax({
			data: datax,
			url: urlx,
			cache: cachex,
			contentType: contentTypex,
			processData: processDatax,
			method: "POST",
			success: function(msg){
				if(dev) console.log(msg);
				try{
					var json=JSON.parse(msg);
					if(mFc!="") mFc(json);
				}catch(e){
					if(mFc=="") alert("JSON Parse Hatası");
					else mFc("");
				}
			},
			error: function(msg){alert("Sunucu Hatası");}
		});
	}
}
