
/*延时菜单的设置开始*/
	var oCategory = document.getElementById("category");
	var oNav = document.getElementById("nav");
	var timer = null;
	oCategory.onmouseover = function(){
		clearTimeout(timer);
		oNav.style.display = "block";
	}

	oCategory.onmouseout = function(){
		timer = setTimeout(function(){
			oNav.style.display = "none";
		},1000);
	}
	oNav.onmouseover = function(){
		clearTimeout(timer);
		this.style.display = "block";
	}

	oNav.onmouseout = function(){
		timer = setTimeout(function(){
			oNav.style.display = "none";
		},500);
	}
/*延时菜单的设置结束*/

/*登录效果开始*/
/*创建的mask层需要放到body元素的一开始，另外css定位中需要使用fixed，因为如果使用absolute定位的话，100%的宽高只是相对于document，而document的宽高等于可视区的宽高*/
var oLogBtn = document.getElementById("logbtn");
var oLogin = document.getElementById("login");
var oMask = document.getElementById("mask");
var pageHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
var pageWidth = document.documentElement.scrollWidth || document.body.scrollWidth;
var viewHeight = document.documentElement.clientHeight;
var viewWidth = document.documentElement.clientWidth;

oLogBtn.onclick = function(){
	oMask.style.display = "block";
	oLogin.style.display = "block";
	var loginWidth = oLogin.offsetWidth;
	var loginHeight = oLogin.offsetHeight;

	oLogin.style.left = (viewWidth - loginWidth)/2 + "px";
	oLogin.style.top = (viewHeight - loginHeight)/2 + "px";
}


oMask.onclick = function(){	
	oMask.style.display = "none";
	oLogin.style.display = "none";
}

/*图片放大效果开始*/
var oMain = document.getElementById("main");
//定义zoom函数
function zoom(){
var aImgs = oMain.getElementsByTagName("img");
//console.log(aImgs.length);
var imgMask = null;
var oCover = null;

for(var i=0;i<aImgs.length;i++){
	aImgs[i].show = false;
	aImgs[i].onclick = function(e){
			//取消冒泡，不然会冒泡到document的click身上..
			var ev = e || event;
			ev.cancelBubble = true;
			//建立覆盖层
			oCover = document.createElement("div");
			oCover.id = "cover";
			oCover.style.width = pageWidth + "px";
			oCover.style.height = pageHeight + "px";
			//document.body.appendChild(oCover);
			document.body.insertBefore(oCover,document.body.children[0]);

			imgMask = document.createElement("div");
			imgMask.id = "imgmask";
			var popImg = document.createElement("img");
			// popImg.src = "pics/b_"+this.src.split("s_")[1]; 这种方法不能够及时的获得图片的宽高--图片还没有来得及加载
			popImg.src = this.getAttribute('data-big');
			//alert(popImg.src);
			imgMask.appendChild(popImg);
			console.log(imgMask);
			document.body.appendChild(imgMask);
			var maskWidth = imgMask.offsetWidth;
			//var maskHeight = imgMask.offsetHeight;
			var maskHeight = this.getAttribute('data-b-height');
			//var maskHeight = imgMask.offsetHeight; //图片没有加载的时候，获取不到值，所以需要php后台传数据的时候就顺带把宽高数据传过来
			console.log(maskWidth, maskHeight);

			imgMask.style.left = (viewWidth - maskWidth)/2 + "px" ;
			imgMask.style.top = (viewHeight - maskHeight)/2 + "px" ;
			
	}

	document.onclick = function(){
		imgMask && document.body.removeChild(imgMask);
		oCover && document.body.removeChild(oCover);
	}
	}
}
//调用zoom函数
zoom()