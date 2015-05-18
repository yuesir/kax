<?php
	/**
	*
	**/
	class Image{
		//图片保存的路径
		private $path;

		function __construc($path="./"){
			$this->path = rtrim($path,"/")."/";
		}

		/*内部使用的方法，用来获取图片的相关信息（宽度高度和类型）*/
		private function getInfo($name, $path = "."){
			$spath = $path=="."? rtrim($this->path,"/")."/" : $path."/";

			$data = getimagesize($spath.$name);
			$imgInfo['width'] = $data[0];
			$imgInfo['height'] = $data[1];
			$imgInfo['type'] = $data[2];
			return $imgInfo;
		}

		/*用于创建各种支持各种图片资源*/
		private function getImg($name, $imgInfo, $path = "."){
			$spath = $path=="."? rtrim($this->path,"/")."/" : $path."/";
			$srcPic = $spath.$name;

			switch ($imgInfo) {
				case 1:
					$img = imagecreatefromgif($srcPic);
					break;
				case 2:
					$img = imagecreatefromjpeg($srcPic);
					break;
				case 3:
					$img = imagecreatefrompng($srcPic);
					break;

				default:
					return false;
					break;
			}
			return $img;
		}

		/*返回等比例缩放的图片宽度和高度，保证原图比例缩放后还保持不变*/
		private function getNewSize($name, $width, $height, $imgInfo){
			$size['width'] = $imgInfo['width'];
			$size['height'] = $imgInfo['height'];
			if($width < $imgInfo['width']){
				$size['width'] = $width; //缩放的宽度如果比原图小才重新设置宽度
			}
			if($height < $imgInfo['height']){
				$size['height'] = $height; //缩放的高度如果比原图小才重新设置高度
			}

			/*等比缩放的算法*/
			//下面的条件说明width这块压缩的更大，所以要以width为基准来计算高度
			if($imgInfo['width']*$size['width'] > $imgInfo['height'] * $size['height']){
				$size['height'] = $imgInfo['height']/$imgInfo['width']*$size[
					'width'];
			}else{
				$size['width'] = $imgInfo['width']/$imgInfo['height']*$size['width'];
			}
			return $size;
		}

		/*内部使用的私有方法，用于保存图片*/
		private function createNewImage($newimg, $newName, $imgInfo){
			$this->path = rtrim($this->path, "/")."/";
			switch($imgInfo['type']){
				case 1:
					$result = imageGIF($newimg, $this->path.$newName);
					break;
				case 2:
					$result = imageJPEG($newimg, $this->path.$newName);
					break;
				case 3:
					$result = imagePng($newimg, $this->path.$newName);
					break;
			}
			imagedestroy($newimg);
			return $newName;
		}

		/*内部方法，用于加水印时复制图像*/
		private function copyImage($groundImg, $waterImg, $size, $waterInfo){
			imagecopy($groundImg, $waterImg, $pos['posX'],$pos['posY'],0,0,$waterInfo['width'],$waterInfo['heig']);
			imagedestroy($waterImg);
			return $groundImg;
		}

		/*处理带有透明度的图片保持原样*/
		private function kidOfImage($srcImg, $size, $imgInfo){
			$newImg = imagecreatetruecolor($size['width'], $size['height']);
			$otsc = imagecolortransparent($srcImg);
			if($otsc >=0 && $otsc < imagecolorstotal($srcImg)){
				$transparentcolor = imagecolorsforindex($srcImg, $otsc);
				$newtransparentcolor = imagecolorallocate(
					$newImg,
					$transparentcolor('red'),
					$transparentcolor('green'),
					$transparentcolor('blue'),
					);
				imagefill($newImg, 0,0, $newtransparentcolor);
				imagecolortransparent($newImg, $newtransparentcolor);
			}
			imagecopyresized($newImg, $srcImg, 0, 0, 0, 0, $size['width'], $size['height'], $imgInfo['width'], $imgInfo['height']);
			imagedestroy($srcImg);
			return $newImg;
		}


		/**
		*对指定的图片进行缩放
		*@param string $name 需要处理的图片名称
		*@param string $width 缩放后的图片宽度
		*@param string $height 缩放后的图片高度
		*@param string $qz 新前图片的前缀
		*@return mixed 缩放后的图片名称，失败返回false
		**/

		function thumb($name, $width, $height, $qz="b_"){
			//获取图片的宽度、高度以及类型信息
			$imgInfo = $this->getInfo($name);
			//获取背景图片的资源
			$srcImg = $this->getImg($name, $imgInfo);
			//获取新的图片资源
			$size = $this->getNewSize($name, $width, $height, $imgInfo);
			/获取新的图片资源/
			$newImg = $this->kidOfImage($srcImg, $width, $height, $imgInfo);
			/*保存缩略图并返回新缩略图的名称，以b_为前缀*/
			return $this->createNewImage($newImg, $qz.$name, $imgInfo);
		}
	

	/**
	*
	*
	**/

	function waterMark($groundImg, $waterName, $waterPos= 0; $qz="wa_"){
		$curpath = rtrim($this->path,"/")."/";
		$dir = dirname($waterName);
		if($dir=="."){
			$wpath = $curpath;
		}else{
			$wpath = $dir."/";
		}

		if(file_exists($curpath, $groundName) && file_exists($wpath.$waterName)){
			$groundInfo = $this->getInfo($groundName);
			$waterInfo = $this->getInfo($waterName, $dir);
			if(!pos = $this->position($groundInfo, $waterInfo, $waterPos)){
				echo "水印不该比背景图片小";
				return false;
			}

			$groundImg = $this->getImg($groundName, $groundInfo); //获取背景图片资源
			$waterImg = $this->getImg($waterName, $waterInfo, $dir); //获取水印图片资源
			/调用私有方法将水印图片按照指定位置加到背景图片中/
			$groundImg = $this->copyImage($groundImg, $waterImg, $pos, $waterInfo);
			/通过本类方法，保存加水印图片并返回新图片的名称，默认以wa_开头/
			return $this->createNewImage($groundImg, $qz.$groundName, $groundInfo);
		}else{
			echo "图片或水印不存在";
			return false;
		}
	}

	/**
	*在一个大图片的指定位置剪切出指定区域的图片
	*@param string $name 需要剪切的背景图片
	*@param int $x 剪切图片左边开始的位置
	*@param int $y 剪切图片顶部开始的位置
	*@param int $width 图片剪切的宽度
	*@param int $height 图片剪切的高度
	*@param string $qz 新图片的名称前缀
	*@return mixed 剪切后的图片名称，失败返回false
	**/
	function cut($name, $x, $y, $width, $height, $qz="cu_"){
		$imgInfo = $this->getInfo($name); //获取图片信息
		if(($x + $width) > $imgInfo['width'] || ($y + $height) > $imgInfo['height']){
			echo "剪切的位置超出了背景图片范围";
			return false;
		}

		$back = $this->getImg($name, $imgInfo);
		$cutimg = imagecreatetruecolor($width, $height);//获取图片资源
		imagecopyresampled($cutimg, $back, 0, 0, $x, $y, $width, $height, $width, $height);
		imagedestroy($back);
		return $this->createNewImage($cutimg, $qz.$name, $imgInfo);
	}

	//内部使用的私有方法，用来确定水印的位置
	private function position($groundInfo, $waterInfo, $waterPos){
		//如果需要添加水印的图片的长度或者宽度比水印还小，则无法生存图片
		if($groundInfo['width'] < $waterInfo['width'] || ($groundInfo['height'] < $waterInfo['width'])){
			return false;
		}
		switch ($imgInfo['type']) {
			case 1:
				$posX = 0;
				$posY = 0;
				break;
			case 2:
				$posX = ($groundInfo['width'] - $waterInfo['width'])/2;
				$posY = 0;
				break;
			case 3:
				$posX = $groundInfo['width'] - $waterInfo['width'];
				$posY = 0;
				break;
			case 4:
				$posX = 0;
				$posY = ($groundInfo['height'] - $waterInfo['height'])/2;
				break;
			case 5: //5为中部
				$posX = ($groundInfo['width'] - $waterInfo['width']/2);
				$posY = ($groundInfo['height'] - $waterInfo['height'])/2;
				break;
			case 6:
				$posX = $groundInfo['width'] - $waterInfo['width'];
				$posY = ($groundInfo['height'] - $waterInfo['height'])/2;
				break;
			case 7:
				$posX = 0;
				$posY = $groundInfo['height'] - $waterInfo['height'];
				break;
			case 8:
				$posX = ($groundInfo['width'] - $waterInfo['width'])/2;
				$posY = $groundInfo['height'] - $waterInfo['height'];
				break;
			case 9:
				$posX = $groundInfo['width'] - $waterInfo['width'];
				$posY = $groundInfo['height'] - $waterInfo['height'];
				break;
			case 0:
			default:
				//随机
				$posX = rand(0, ($groundInfo['width'] - $waterInfo['width']));
				$posY = rand(0, ($groundInfo['width'] - $waterInfo['width']));
				break;
		}
		return array('posX'=>$posX, 'posY'=>$posY);
	}
}