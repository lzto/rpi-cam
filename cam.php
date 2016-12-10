<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portal">

		<title>Camera</title>

		<link rel="icon" type="image/png" href="images/favicon.png" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link href="css/simple-sidebar.css" rel="stylesheet">
		<link href="css/dashboard.css" rel="stylesheet">
	</head>

<body>
	<script src="js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="cam.php?date=current">
				<img alt="coco" src="coco.png" width="32" height="32">
				</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
				<li class="active">
					<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Record Date</a>
				</li>
				</ul>
			</div>
		</div>

	</nav>
	<div id="wrapper">
	<div id="sidebar-wrapper">
		<ul class="sidebar-nav">
		<li class="sidebar-brand">Date</li>
<?php
$pwd='/mnt/usb/cam';
$contents = scandir($pwd,SCANDIR_SORT_DESCENDING);

function scan_dir($dir) {
	$ignored = array('.', '..', '.svn', '.htaccess');

	$files = array();
	foreach (scandir($dir) as $file) {
		if (in_array($file, $ignored)) continue;
		$files[$file] = filemtime($dir . '/' . $file);
	}

	arsort($files);
	$files = array_keys($files);

	return ($files) ? $files : false;
}


$c_date = basename(isset($_GET['date']) ? $_GET['date'] : date("Y_m_d"));
if($c_date=='live')
{
	echo '<li class="active"><a href=cam.php?date=live>live</a></br></li>';
}else
{
	echo '<li><a href=cam.php?date=live>live</a></br></li>';
}
echo "\n";

foreach($contents as $d)
{
	if(is_dir($pwd."/".$d))
	{
		if(($d!='.')&&($d!='..')&&preg_match("/^[0-9]/",$d))
		{
			if($c_date==$d)
			{
				echo '<li class="active">';
			}else
			{
				echo "<li>";
			}
			echo '<a href=cam.php?date='.$d.'&m=1>'
			.'<span class="glyphicon glyphicon-play" aria-hidden="true"></span>'.$d.'</a>';
			echo '</li>';
			echo "\n";
		}
	}
}
?>
			</ul><!--nav nav-sidebar-->
		</div>
		<!-- /#sidebar-wrapper -->
		<div id="page-content-wrapper">
		<div class="jumbotron">
		<div class="container-fluid">
<?php

function get() {
	$c_date = basename(isset($_GET['date']) ? $_GET['date'] : date("Y_m_d"));
	$c_page = basename(isset($_GET['page']) ? $_GET['page'] : 0);

	if($c_date=='live')
	{
		echo '<div class="well">';
		echo '<center>';
		echo '<img class="img-responsive" style="width:512px" src="http://znbs.space:8081/">';
		echo '<p><span class="glyphicon glyphicon-record" aria-hidden="true"><h4>Live</h4></span></p>';
		echo '<p><h1>'.
			'<a href="#" onclick="pantilt(10,0)"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>'.
			'<a href="#" onclick="pantilt(0,-10)"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>'.
			'<a href="#" onclick="pantilt(0,10)"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>'.
			'<a href="#" onclick="pantilt(-10,0)"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>'.
			'</h1></p>';
		echo '</center>';
		echo '</div>'."\n";
		echo '</div>'."\n";
		echo '</div>'."\n";
		$pd='90';
		$td='90';
		$r = file_get_contents("/tmp/cam_pos");
		if ($r!='')
		{
			$pos=explode(" ",$r);
			$pd=$pos[0];
			$td=$pos[1];
		}
		echo '<script>'.
			'var pd='.$pd.'; var td='.$td.';'.
			'function pantilt(delta_pd,delta_td){'.
				'pd=pd+delta_pd;td=td+delta_td;'.
				'if(pd>180) pd=180;'.
				'if(pd<0) pd=0;'.
				'if(td>180) td=180;'.
				'if(td<0) td=0;'.
				'var xmlhttp = new XMLHttpRequest();'.
				'xmlhttp.open("GET", "pantilt.php?pd=" + pd + "&td=" + td, true);'.
				'xmlhttp.send();'.
			'}'.
			'</script>';
		return;
	}

	if($c_date=='current')
	{
		echo '<div class="well">';
		echo '<center>';
		echo '<img src="lastsnap.jpg" class="img-responsive" alt="lastsnap.jpg" style="width:512px">';
		echo '<p><span class="glyphicon glyphicon-flash" aria-hidden="true"><h4>Current Snapshot</h4></span></p>';
		echo '<a href=cam.php?date=live><span class="glyphicon glyphicon-record" aria-hidden="true"></span> Switch to live</a>';
		echo '</center>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		return;
	}

	if($c_date=='')
	{
		$c_date=date("Y_m_d");
	}

	$mvideo = isset($_GET['m']) ? $_GET['m'] : 0;
	
	if($mvideo==1)
	{
		echo '<div class="well">';
		echo '<center>';
		echo '<img src="mvideo.php?date='.$c_date.'" class="img-responsive" alt="mvideo.php" style="width:512px">';
		echo '<p><span class="glyphicon glyphicon-play" aria-hidden="true"><h4>>></h4></span></p>';
		echo '<a href=cam.php?date='.$c_date.'><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> List Frames</a>';
		echo '</center>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		return;
	}

	$page = isset($_GET['p']) ? $_GET['p'] : 0;

	$pwd='/mnt/usb/cam/'.$c_date;
	$contents = array_reverse(scan_dir($pwd));
	$cnt = 0;
	echo '<div class="container-fluid">';
	echo '<div class="row">';
	#50 images per page
	foreach($contents as $d)
	{
		if(!is_dir($pwd."/".$d))
		{
			if( ($cnt>=($c_page*50)) && ($cnt<(($c_page+1)*50)) )
			{
				echo '<div class="col-xs-6 col-sm-4">';
				echo '<a href="#" class="thumbnail">';
				echo '<img src="'.$c_date.'/'.$d.'" alt="'.$d.'" style="width:300px">';
				echo '</a>';
				echo '</div>';
			}
			$cnt++;
		}
	}
	echo "</div>\n";
	$totalpages=ceil($cnt/50);
	echo "<nav>\n";
	echo '
	<ul class="pagination">
';
	$xp = $c_page;
	if($xp>0)
	{
		$xp--;
		$genurl="cam.php?date=$c_date&page=$xp";
		echo '<li><a href="'.$genurl.'" aria-label="Previous">';
	}else
	{
		echo '<li class="disabled"><a href="#" aria-label="Previous">';
	}
	echo '			<span aria-hidden="true">&laquo;</span>
		</a>
		</li>
';
	$xp=0;
	while($xp<$totalpages)
	{
		$genurl="cam.php?date=$c_date&page=$xp";
		if($xp==$c_page)
		{
			echo '<li class="active"><a href=:'.$genurl.'">'.$xp.'</a></li>';
		}else
		{
			echo '<li><a href="'.$genurl.'">'.$xp.'</a></li>';
		}
		$xp++;
	}
	$xp = $c_page;
	if(($xp+1)<$totalpages)
	{
		$xp++;
		$genurl="cam.php?date=$c_date&page=$xp";
		echo '<li>';
		echo '<a href='.$genurl.' aria-label="Next">';
		echo '		<span aria-hidden="true">&raquo;</span>
			</a>
			</li>';
	}else
	{
		echo '<li class="disabled">';
		echo '<a href="#" aria-label="Next">';
		echo '		<span aria-hidden="true">&raquo;</span>
			</a>
			</li>';
	}
	echo '</ul>';
	echo "</nav>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";
}

function main() {
	get();
}

main();

?>
    </div>


</div>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>


</body>
</html>

