<?php
//********************************************************************************


//===============================
// Display Menu Form
//-------------------------------
function Header_show()
{
  global $tpl;
  global $db;
  $sFormTitle = "";

//-------------------------------
// Header Open Event begin
// Header Open Event end
//-------------------------------

//-------------------------------
// Set URLs
//-------------------------------
  $fldField8 = "index.php";
  $fldField5 = "pagina.php";
  $fldField6 = "paginabloktekst.php";
  $flduploader = "";
  $fldField1 = "nieuwsRecord.php";
  $fldField2 = "informatieRecord.php";
  $fldField10 = "brochures.php";
  $fldField4 = "linksRecord.php";
  $fldField7 = "gebruikers.php";
  $fldteller = "";
  $fldlogin = "Login.php";
//-------------------------------
// Header Show begin
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Header BeforeShow Event begin
$flduploader="<a class=blue HREF=javascript:void(0) ONCLICK=open('http://www.profiltra.nl/uploader/upload.php','miniwin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=400,height=600')><font color=#000000>- Uploader";
$fldteller="<a href=http://www.nedstatbasic.net/s?tab=1&link=1&id=2195621 target=_blank></a><font color=#000000>- Teller";
// Header BeforeShow Event end
//-------------------------------

//-------------------------------
// Show fields
//-------------------------------
  $tpl->set_var("Field8", $fldField8);
  $tpl->set_var("Field5", $fldField5);
  $tpl->set_var("Field6", $fldField6);
  $tpl->set_var("uploader", $flduploader);
  $tpl->set_var("Field1", $fldField1);
  $tpl->set_var("Field2", $fldField2);
  $tpl->set_var("Field10", $fldField10);
  $tpl->set_var("Field4", $fldField4);
  $tpl->set_var("Field7", $fldField7);
  $tpl->set_var("teller", $fldteller);
  $tpl->set_var("login", $fldlogin);
  $tpl->parse("FormHeader", false);

//-------------------------------
// Header Show end
//-------------------------------
}
//===============================

?>