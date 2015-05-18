<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>文件上传</title>
</head>
<body>
	<?php
		require("functions.php");
		$files = $_FILES['pic'];
		if(!empty($files)){
			$path = "./pics/";
			$typelist = array("image/png","image/jpeg","image/gif","image/pjpeg");
			$oriInfo =  fileupload($files, $path, $typelist);
			if($oriInfo['info']){
				imageZoom($oriInfo['info'],'./pics/',800,800,"b_");
				imageZoom($oriInfo['info'],'./pics/',200,200,"s_");
				$dsn = "mysql:host=localhost;dbname=kax";
				$pdo = new PDO($dsn, 'root',"");
				$sql = "INSERT INTO imgs(addr, likes, clicks) VALUES(\"{$oriInfo['info']}\",0,0)";
				$res = $pdo->query($sql);
				if($res->rowcount() > 0){
					echo "上传成功！";
				}else{
					echo "上传失败！";
				}
			}

		}
			
	?>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<input type="file" name="pic"/>
		<input type="submit" value="上传"/>
	</form>
</body>
</html>