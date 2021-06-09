//找到第几个标签
onload = function() {
    var lis = document.getElementsByClassName("xiugai");
    var funny = function(i){
		lis[i].onclick = function(){
        //alert("第" + (i+1) + "个");
		update(i);
        }
    }
    for(var i=0;i<lis.length;i++){
		funny(i);
    }
}
// 获取图片预览地址函数
function getObjectURL(file) {  
	var url = null;   
	if (window.createObjectURL!=undefined) {  
		url = window.createObjectURL(file) ;  
	} else if (window.URL!=undefined) { // mozilla(firefox)  
		url = window.URL.createObjectURL(file) ;  
	} else if (window.webkitURL!=undefined) { // webkit or chrome  
		url = window.webkitURL.createObjectURL(file) ;  
	}  
	return url ;  
}
function uploader(e){
	// 将图片信息通过getObjectURL函数处理出预览地址
	var s = getObjectURL(e[0]);
	// 获取img元素，label元素，div[上传按钮]元素
	var img=document.getElementById('o_photo_img');
	
	// 设置图片展示样式
	img.style.padding='3px';
	img.style.borderStyle='solid';
	img.style.borderColor='#eee';
	img.style.borderWidth='1px';
	// 设置img的src值实现图片预览
	img.src=s;
	
}
