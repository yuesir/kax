<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>咔嚓网-记录自己的成长</title>
		<link rel="stylesheet" type="text/css" href="./css/style.css"/>
		<script type="text/javascript" src="./js/waterfall.js"></script>
	</head>
	<body>
		<div id="mask"></div>
		<!--topnav开始-->
		<div class="topnav">
			<div class="category" id="category">
				<a href="#" id="decoration"></a>
			</div>
			<div id="nav">
				<ul id="center">
					<li><a href="javascript:;">我的关注</a></li>
					<li><a href="javascript:;">最新采集</a></li>
					<li><a href="javascript:;">视频</a></li>
				</ul>
				<ul id="list">
					<li><a href="javascript:;">家居</a></li>
					<li><a href="javascript:;">旅游</a></li>
					<li><a href="javascript:;">美食</a></li>
					<li><a href="javascript:;">时尚</a></li>
					<li><a href="javascript:;">服饰</a></li>
					<li><a href="javascript:;">时尚</a></li>
					<li><a href="javascript:;">艺术</a></li>
					<li><a href="javascript:;">设计</a></li>
					<li><a href="javascript:;">插画</a></li>
					<li><a href="javascript:;">UI</a></li>
				</ul>
			</div>
			<div class="search">
				<form action="search.php" method="get">
					<input type="text" class="s" name="s" placeholder="搜索下更喜欢"/>
					<input type="submit" class="sosuo" value="搜索"/>
				</form>
			</div>
			<div class="action">
				<a href="#" id="logbtn">登录</a> | 
				<a href="#">注册</a>
			</div>
		</div>
		<!--topnav结束-->
		<div id="main">
		<?php
			$dsn = "mysql:host=localhost;dbname=kax";
			$pdo = new PDO($dsn, "root","");
			$sql = "SELECT * FROM imgs LIMIT 30";
			$res = $pdo->query($sql);
			foreach ($res as $row) {
				$pic = "pics/b_".$row['addr'];
				$picInfo = getimagesize($pic);
				echo '<div class="box">
					<div class="pic"><img src="pics/s_'.$row['addr'].'" data-big="pics/b_'.$row['addr'].'" data-b-width="'.$picInfo[0].'" data-b-height="'.$picInfo[1].'"/></div>
					</div>';
			}
			
		?>
		<!-- 
			<div class="box">
				<div class="pic"><img src="images/meinv001.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv002.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv003.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv004.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv005.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv006.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv007.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv008.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv009.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv010.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv011.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv012.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv013.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv014.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv015.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv016.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv017.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv018.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv019.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv020.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv021.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv022.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv023.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv024.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv025.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv026.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv027.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv028.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv029.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv030.jpg"/></div>
			</div>
			<div class="box">
				<div class="pic"><img src="images/meinv031.jpg"/></div>
			</div> -->
		</div>
		

			<div id="login">
				<div class="words">使用第三方帐号登录</div>
				<div class="buttons">
					<a href="#" class="weibo"></a>
					<a href="#" class="qzone"></a>
					<a href="#" class="douban"></a>
					<a href="#" class="renren"></a>
				</div>
				<div id="loginwrap">
					<div class="with-line">
						使用邮箱登录
					</div>
					<form action="#" method="post" class="maillogin">
						<input type="text" placeholder="邮箱地址" class="clear-input"/>
						<input type="password" placeholder="密码" class="clear-input"/>
						<a href="#" class="btn"><span>登录</span></a>
					</form>
					<div class="moreact">
						<a href="#" class="find-pass">忘记密码»</a>
						<div class="switch-back">
							还没有咔擦帐号？<a href="#">点击注册»</a>
						</div>
					</div>
				</div>
			</div>
			
	</body>
	<script type="text/javascript" src="./js/my.js"></script>
</html>