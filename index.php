<?php

$file1 = "csv/sample1.csv";
$file2 = "csv/sample2.csv";
//$file1 = "csv/20120517.csv";
//$file2 = "csv/20120530.csv";

$tss = microtime(true); 

require_once 'csvdiffs.php';

/**
 * rows in file-1 where col 1 not in file-2 
 */
$difi1 = diffsCol($difR, $difR1, 1);
/**
 * rows in file-2 where col 1 not in file-1
 */
$difi2 = diffsCol($difR1, $difR, 1); 
/**
 * rows in file-1 where col1 in file2 the same but other cols changed
 */ 
$difi3 = diffsUCol($difR, $difR1, 1);
/**
 * rows in file-2 where col1 in file1 the same but other cols changed
 */ 
$difi4 = diffsUCol($difR1, $difR, 1);
$tse = microtime(true);
echo '<!DOCTYPE HTML>
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title>csvDiffs.php Demo  </title>
  <style type="text/css"> 
body {
	text-align: center;
}
p {margin:5px 0 5px;
}
li{
  margin:8px 0 8px 10px;
}
.result{
  display:block;
  margin-left:10px;
  color: #888;
  font-family:curior;
}
#container {
	width: 1000px;
	margin: 0 auto;
	margin-top: 50px;
	text-align: left;
}
  </style>
  </head>
  <body>';
echo '
<h1>csvDiffs.php Demo</h1>

<div id="container"><p>Time to process: '.round($tse-$tss, 5).' seconds</p>
<p>File-1: '.$file1.'</p>
<p>File-2: '.$file2.'</p>';
echo '<ul>
<li>Rows in file-1 with no exact match in file-2: <div class="result">'.stripcslashes(json_encode($difR)).'</div></li>
<li>Rows in file-2 with no exact match in file-1: <div class="result">'.stripcslashes(json_encode($difR1)).'</div></li>
<li>Rows in file-1 where col#1 not in file-2: <div class="result">'.stripcslashes(json_encode($difi1)).'</div></li>
<li>Rows in file-2 where col#1 not in file-1: <div class="result">'.stripcslashes(json_encode($difi2)).'</div></li>
<li>Rows in file-1 where col#1 in file-2 the same but other cols different: <div class="result">'.stripcslashes(json_encode($difi3)).'</div></li>
<li>Rows in file-2 where col#1 in file-1 the same but other cols different: <div class="result">'.stripcslashes(json_encode($difi4)).'</div></li>
</ul>';
echo '</div>
</body>
</html>';
?>
