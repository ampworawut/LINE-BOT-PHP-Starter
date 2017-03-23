<?php

include('includes/json.php');

if($_GET['q'] !== "" ) {

//Initial DB connection
$host="localhost";
$username="root";
$password="511022";
$database="intranet";
$connect=mysql_connect($host,$username,$password)or die(mysql_error);
mysql_select_db($database,$connect) or die (mysql_error);
mysql_query("SET NAMES TIS620");

//
$strSearch = trim($_POST["txtSearch"]);

//$objDB = mssql_select_db("Nstda_Integrate");

$strSQL = "SELECT [NANO_PhoneSystem].[dbo].[DEPARTMENT].[DEPARTMENTID]
	  ,[NANO_PhoneSystem].[dbo].[DEPARTMENT].[DEPARTMENTNAMETHAI]
      ,[NANO_PhoneSystem].[dbo].[DEPARTMENT].[EMAIL]
      ,[NANO_PhoneSystem].[dbo].[DEPARTMENT].[Ext]
  FROM [NANO_PhoneSystem].[dbo].[DEPARTMENT]
  WHERE     ([NANO_PhoneSystem].[dbo].[DEPARTMENT].[DEPARTMENTID] LIKE '%".$strSearch."%') OR ([NANO_PhoneSystem].[dbo].[DEPARTMENT].[DEPARTMENTNAMETHAI] LIKE '%".$strSearch."%')
  OR ([NANO_PhoneSystem].[dbo].[DEPARTMENT].[EMAIL] LIKE '%".$strSearch."%') OR ([NANO_PhoneSystem].[dbo].[DEPARTMENT].[Ext] LIKE '%".$strSearch."%')
  ORDER BY [NANO_PhoneSystem].[dbo].[DEPARTMENT].[DEPARTMENTID]";

if($num>0){

while($objResult = mssql_fetch_array($objQuery))
$sid = substr($objResult["EMPLOYEEID"],0,-4);


      $json = new json();

      $object = new stdClass();
      $object->NUM = $num;
      $object->EMPLOYEEID = $objResult["EMPLOYEEID"];
      $object->GIVENNAMETHAI = $objResult["GIVENNAMETHAI"];
      $object->EMAIL = $objResult["EMAIL"];
      $object->NICKNAME = $objResult["NICKNAME"];
      $object->EXT = $objResult["Ext"];
      $object->Mobile = $objResult["Mobile"];


if($total == 0)
{
      $object->NUM = $num;
}
mssql_close($objConnect);
}
}
 ?>
