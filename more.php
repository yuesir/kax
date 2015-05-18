<?php
	$dsn = "mysql:host=localhost;dbname=kax";
	$pdo = new PDO($dsn, "root","");
	$start = $_GET['pg']?intval($_GET['pg']):1;
	$start *= 30;
	/*如果这里每次不是添加30个的时候，start * 30 应该如何设置，这里因为第一次刚好展示的是30个，所以刚好可以接上 */
	$sql = "SELECT * FROM imgs LIMIT {$start}, 30";
	//echo $sql;
	$res = $pdo->query($sql);
	//定义空数组用来存放获得的图片地址
	if($res->rowcount() > 0){
		foreach($res as $k=>$v){
			//在读取数据的时候，将大图片的宽高也一起读到json里面去，方便前端在图片没有加载的时候也能直接获得图片的宽高
			$pic = "./pics/b_".$v['addr'];
			$picInfo = getimagesize($pic);
			$pics[$k]['src'] = "s_".$v['addr'];
			$pics[$k]['width'] = $picInfo[0];
			$pics[$k]['height'] = $picInfo[1];
			}
			$arr['data']['pics'] = $pics;
		echo json_encode($arr);
	}else{
		echo "false";
	}
	