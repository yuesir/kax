window.onload = function(){
	waterFall("main","box");
	var dataInt = {"data":[{"src":"images/meinv032.jpg"},{"src":"images/meinv033.jpg"},{"src":"images/Meinv034.jpg"},{"src":"images/Meinv035.jpg"},{"src":"images/Meinv036.jpg"},{"src":"images/Meinv037.jpg"},{"src":"images/Meinv038.jpg"},{"src":"images/Meinv039.jpg"},{"src":"images/Meinv040.jpg"},{"src":"images/Meinv041.jpg"},{"src":"images/Meinv042.jpg"},{"src":"images/Meinv043.jpg"},{"src":"images/Meinv044.jpg"},{"src":"images/Meinv045.jpg"},{"src":"images/Meinv046.jpg"},{"src":"images/Meinv047.jpg"},{"src":"images/Meinv048.jpg"},{"src":"images/Meinv049.jpg"},{"src":"images/Meinv050.jpg"},{"src":"images/Meinv051.jpg"},{"src":"images/Meinv052.jpg"},{"src":"images/Meinv053.jpg"},{"src":"images/Meinv054.jpg"},{"src":"images/Meinv055.jpg"},{"src":"images/Meinv056.jpg"}]};
	var pg = 1;
	var more = true;
	var oParent = document.getElementById("main");
	window.onscroll = function(){
		console.log(more);
		if(checkScrollSlide() && more){
			//从这里发送ajax从服务器获取图片地址
			var xhr = null;
			more = false; //将more的值设为false
			if(window.XMLHttpRequest){
				xhr = new XMLHttpRequest();
			}else{
				var versions = ['Microsoft.XMLHTTP', 'MSXML6.XMLHTTP'];
				//利用for循环针对不同的IE版本创建不同的XMLHttpRequest对象
				for(var i=0;i<versions.length;i++){
					try{
						//这里如果xhr创建成功怎会执行到下面的break跳出循环，如果错误，则会抛出错误，执行
						//else的异常处理部分
						xhr = new ActiveXObject(versions[i]);
						break;
					}catch(e){
						//如果执行到这里，则会跳出本次循环，继续执行下一个for循环
						continue;
					}
				}
			}

			xhr.open("get","more.php?pg="+pg+ "&random="+new Date().getTime(),true);
			xhr.send();
			
			xhr.onreadystatechange = function(){
						if(xhr.readyState == 4 && xhr.status == 200){
							var data = xhr.responseText;
							// var dataInt = data.pics;
							if(data!="false"){
								var dataInt = JSON.parse(data).data.pics;
								//console.log(data);
								reload(dataInt);
								//每次加载数据的时候，重新调用waterFall函数以及zoom函数，不然后加入的
								//图片没有zoom的效果,也可以使用事件代理来完成.
								waterFall("main","box");
								zoom();
								pg++;
							}else{
								alert('后面没有妹子了哟');
								// more = false;
								return;
							}
							
						}
					}			


			function reload(dataInt){
				for(var i=0;i<dataInt.length;i++){
					var oBox = document.createElement("div");
					oBox.className = "box";
					oParent.appendChild(oBox);
					var oPic = document.createElement("div");
					oPic.className = "pic";
					oBox.appendChild(oPic);
					var oImg = document.createElement("img");
					oImg.src = "pics/"+dataInt[i].src;
					//计算图片的高度，避免出现图片没有加载的时候出现计算不出来的情况
					oImg.style.height = dataInt[i].height / dataInt[i].width * 165 + "px";
					oImg["data-big"] = "pics/b_"+dataInt[i].src.substring(2);
					oImg["data-b-width"] = dataInt[i].width;
					oImg["data-b-height"] = dataInt[i].height;
					oImg.setAttribute("data-big", "pics/b_"+dataInt[i].src.substring(2));
					oImg.setAttribute("data-b-width", dataInt[i].width);
					oImg.setAttribute("data-b-height", dataInt[i].height);
					oPic.appendChild(oImg);
				}
				more = true;
			}
			
		}
	}
}

//定义waterFall核心函数
function waterFall(oparent,classname){
	var oContainer = document.getElementById(oparent);
	//获取oparent下面所有class为classname的元素
	var aBoxs = getByClassname(oparent,classname);
	//判断一行可以放几列，获取到每一个盒子的高度
	var oboxW = aBoxs[0].offsetWidth;//获取盒子的宽度
	var clientW = document.documentElement.clientWidth;
	var cols = Math.floor(clientW / oboxW); //向下取整,判断页面可以放几列

	//设置外边container的宽度并进行居中设置
	oContainer.style.cssText = "width:"+(cols*oboxW)+"px;margin:0 auto;";

	//声明一个数组用来存储每列的高度数据
	var aColsH = [];
	//遍历aBoxs对每个box的位置等css样式进行设置
	for(var i=0;i<aBoxs.length;i++){
		if(i<cols){
			//第一行的时候直接把整个盒子的高度塞进数组，第一行的盒子css样式不需要进行任何设置
			aColsH.push(aBoxs[i].offsetHeight);
			aBoxs[i].style.top = "0px";
			aBoxs[i].style.left = (i * oboxW) + "px";  
		}else{
			//对第行列及以后的盒子的css样式进行设置
			var minH = Math.min.apply(null,aColsH);
			//console.log(minH);
			//console.log(aColsH);
			//需要知道acolsH当中值为minH的列是那一列,
			var windex = 0;
			for(var j=0;j<aColsH.length;j++){
				if(aColsH[j] == minH){
					windex = j;
					break;
				}
			}
			
			aBoxs[i].style.top = aColsH[windex] + "px";
			aBoxs[i].style.left = (windex * oboxW) + "px";
			aColsH[windex] += aBoxs[i].offsetHeight;
			//console.log(aColsH);
			// aBoxs[i].style.left = 
		}
	}
}

//获取某个父元素下面类名为clsname的所有元素
function getByClassname(parent,clsname){
	var oParent = document.getElementById(parent);
	var aEles = oParent.getElementsByTagName("*");
	var aBox = [];
	for(var i=0;i<aEles.length;i++){
		if(aEles[i].className == clsname){
			aBox.push(aEles[i]);
		}
	}
	return aBox;
}

//用于判断加载条件，最后加载的哪一个一定是最短的？
function checkScrollSlide(){
	var oBoxs = getByClassname("main","box");
	var lstBoxH = oBoxs[oBoxs.length-1].offsetTop;
	var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	var clientH = document.documentElement.clientHeight || document.body.clientHeight;
	var res = lstBoxH < (scrollTop + clientH) ? true : false;
	return res;
}