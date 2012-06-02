<?php
/**
 * csvDiffs.php finds and returns arrays of differences between two .csv files
 * version 0.1 finds all unique rows and rows where one column matches but any other columm differs
 * requires PHP >=5.3 
 *  
 * Released under the GNU/LGPL licences -- David Collins -- June, 2012 
 *  
 * You may freely use, modify or redistribute this script provided this header remains intact
 *    
 * @title      csvDiffs.php 
 * @author     David Collins <collidavid@gmail.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS:0.1 $Id:$
 * @link       https://github.com/davidcollins/xlsx2csv
 */

/**
 * define files to be handled if not set elsewhere
 */  
if(!isset($file1)){
 $file1="";
};
if(!isset($file2)){
 $file2="";
};

/**
 * set an error message for no file selected
 */ 
 
$no_file_error="no file selected";

/**
 *  put CSV files into single-diminesion json encoded array
 *  to compare it as a string
 */ 
 
function fcsv2Ajsn($f){
 global $no_file_error;
 if(file_exists($f)){
  $f = fopen($f, 'r');
 } 
 else {
  die($no_file_error);
 };
 while(($line = fgets($f)) !== FALSE){
  $arr[]= json_encode($line);
 };
 fclose($f);
 return $arr;
} ; 

 /**
  * make array of all rows in file 1 where #col not in file 2
  */         
function diffsCol($arr1, $arr2, $col){
 if($col!="0"){
  $col--;
 };
 $vc=array();
 $uc=array();
 foreach($arr1 as $v){
  $vc[] = $v[$col];
  $arr3[$v[$col]]=$v;
 };
 foreach($arr2 as $u){  
  $uc[] = $u[$col]; 
 };  
 $d = array_diff($vc, $uc);  
 $d = array_flip($d);
 $d = array_intersect_key($arr3,$d); 
 return $d;
 };

 /**
 * find all rows in file 1 where col in file 2 the same but other cols changed:
 * works best if needle column has unique values
 * decrement $col to synch array[$col] with csv column count 
 */   
function diffsUCol($arr1, $arr2, $col ){
 if ($col!="0"){$col--;};
 $dif=array();
 foreach($arr1 as $val)
 {
  foreach($arr2 as $v)
  {
   if($val[$col]==$v[$col]){
    $tdif=array();
    $tdif[] = array_merge($val,$v); 
    $dif[] = $tdif;
   };
  };
 };
 return $dif;
};

$indx1 = fcsv2Ajsn($file1);
$indx2 = fcsv2Ajsn($file2);

/**
 * get all rows in file1 that don't have matching rows in  file2
 * go through it both ways to find unique rows in each file. 
 */     

$difRs = array_diff($indx1,$indx2);
$difRs1 = array_diff($indx2,$indx1);
 
/**
 * find unique rows where selected columns match in each file 
 */  

foreach($difRs as $val){
 $difR[]=str_getcsv(json_decode($val));
};

foreach($difRs1 as $val){
 $difR1[]=str_getcsv(json_decode($val));
};
 
?>