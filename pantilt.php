<?php
$pandeg = strval(intval(isset($_GET['pd'])?$_GET['pd']:90));
$tiltdeg = strval(intval(isset($_GET['td'])?$_GET['td']:90));

echo "<html>";

echo $pandeg.'</br>';
echo $tiltdeg.'</br>';

echo $_SERVER['HTTP_HOST'];

if ( $_SERVER['HTTP_HOST'] == 'coco.local' )
{
	system('echo '.$pandeg.' '.$tiltdeg.' > /tmp/cam_pos');
	system('/usr/bin/sudo /opt/bin/servo.py '.$pandeg.' '.$tiltdeg);
}else
{
	system('echo '.$pandeg.' '.$tiltdeg.' > /tmp/cam_pos');
	system('wget "http://coco.local/camera/pantilt.php?pd='.$pandeg.'&td='.$tiltdeg.'" -O /dev/null');
}

echo "</html>";

?>
