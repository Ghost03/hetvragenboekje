<?php
/*********************************************************************************
 *       Filename: paginatekst.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// paginatekst CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// paginatekst CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "paginatekst.php";
$template_filename = "paginatekst.html";
//===============================



//===============================
// paginatekst PageSecurity begin
check_security(3);
// paginatekst PageSecurity end
//===============================

//===============================
// paginatekst Open Event begin
// paginatekst Open Event end
//===============================

//===============================
// paginatekst OpenAnyPage Event start
// paginatekst OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// paginatekst Show begin

//===============================
// Perform the form's action
//-------------------------------
// Initialize error variables
//-------------------------------
$stekstenErr = "";

//-------------------------------
// Select the FormAction
//-------------------------------
switch ($sForm) {
  case "teksten":
    teksten_action($sAction);
  break;
}
//===============================

//===============================
// Display page
//-------------------------------
// Load HTML template for this page
//-------------------------------
$tpl = new Template($app_path);
$tpl->load_file($template_filename, "main");
//-------------------------------
// Load HTML template of Header and Footer
//-------------------------------
$tpl->load_file($header_filename, "Header");
$tpl->load_file($footer_filename, "Footer");
//-------------------------------
$tpl->set_var("FileName", $filename);



//-------------------------------
// Step through each form
//-------------------------------
Header_show();Form_show();titel_show();teksten_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// paginatekst Show end

//===============================
// paginatekst Close Event begin
// paginatekst Close Event end
//===============================
//********************************************************************************


//===============================
// Display Menu Form
//-------------------------------
function titel_show()
{
  global $tpl;
  global $db;
  $sFormTitle = "Pagina tekst beheer";

//-------------------------------
// titel Open Event begin
// titel Open Event end
//-------------------------------

//-------------------------------
// Set URLs
//-------------------------------
//-------------------------------
// titel Show begin
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// titel BeforeShow Event begin
// titel BeforeShow Event end
//-------------------------------

//-------------------------------
// Show fields
//-------------------------------
  $tpl->parse("Formtitel", false);

//-------------------------------
// titel Show end
//-------------------------------
}
//===============================


//===============================
// Action of the Record Form
//-------------------------------
function teksten_action($sAction)
{
//-------------------------------
// Initialize variables  
//-------------------------------
  global $db;
  global $tpl;
  global $sForm;
  global $stekstenErr;
  $bExecSQL = true;
  $sActionFileName = "";
  $sParams = "?";
  $sWhere = "";
  $bErr = false;
  $pPKtekst_id = "";
  $fldnaam = "";
  $fldnaam_uk = "";
  $fldtekst = "";
  $fldtekst_uk = "";
//-------------------------------

//-------------------------------
// teksten Action begin
//-------------------------------
  $sActionFileName = "pagina.php";
  $sParams .= "categories_id=" . urlencode(get_param("Trn_categories_id"));

//-------------------------------
// CANCEL action
//-------------------------------
  if($sAction == "cancel")
  {

//-------------------------------
// teksten BeforeCancel Event begin
// teksten BeforeCancel Event end
//-------------------------------
    header("Location: " . $sActionFileName . $sParams);
    exit;
  }
//-------------------------------


//-------------------------------
// Build WHERE statement
//-------------------------------
  if($sAction == "update" || $sAction == "delete") 
  {
    $pPKtekst_id = get_param("PK_tekst_id");
    if( !strlen($pPKtekst_id)) return;
    $sWhere = "tekst_id=" . tosql($pPKtekst_id, "Number");
  }
//-------------------------------


//-------------------------------
// Load all form fields into variables
//-------------------------------
  $fldtekst_id = get_param("Rqd_tekst_id");
  $fldnaam = get_param("naam");
  $fldnaam_uk = get_param("naam_uk");
  $fldtekst = get_param("tekst");
  $fldtekst_uk = get_param("tekst_uk");

//-------------------------------
// Validate fields
//-------------------------------
  if($sAction == "insert" || $sAction == "update") 
  {
//-------------------------------
// teksten Check Event begin
// teksten Check Event end
//-------------------------------
    if(strlen($stekstenErr)) return;
  }
//-------------------------------


//-------------------------------
// Create SQL statement
//-------------------------------
  switch(strtolower($sAction)) 
  {
    case "update":

//-------------------------------
// teksten Update Event begin
// teksten Update Event end
//-------------------------------
        $sSQL = "update teksten set " .
          "naam=" . tosql($fldnaam, "Text") .
          ",naam_uk=" . tosql($fldnaam_uk, "Text") .
          ",tekst=" . tosql($fldtekst, "Text") .
          ",tekst_uk=" . tosql($fldtekst_uk, "Memo");
        $sSQL .= " where " . $sWhere;
    break;
    case "delete":
//-------------------------------
// teksten Delete Event begin
// teksten Delete Event end
//-------------------------------
        $sSQL = "delete from teksten where " . $sWhere;
    break;
  }
//-------------------------------
//-------------------------------
// teksten BeforeExecute Event begin
// teksten BeforeExecute Event end
//-------------------------------

//-------------------------------
// Execute SQL statement
//-------------------------------
  if(strlen($stekstenErr)) return;
  if($bExecSQL)
    $db->query($sSQL);
  header("Location: " . $sActionFileName . $sParams);
  exit;
//-------------------------------
// teksten Action end
//-------------------------------
}

//===============================
// Display Record Form
//-------------------------------
function teksten_show()
{
  global $db;
  global $tpl;
  global $sAction;
  global $sForm;
  global $stekstenErr;
  
  $fldtekst_id = "";
  $fldnaam = "";
  $fldnaam_uk = "";
  $fldtekst = "";
  $fldtekst_uk = "";
//-------------------------------
// teksten Show begin
//-------------------------------
  $sFormTitle = "Tekst van pagina {naam} aanpassen";
  $sWhere = "";
  $bPK = true;
//-------------------------------
// Load primary key and form parameters
//-------------------------------
  if($stekstenErr == "")
  {
    $fldtekst_id = get_param("tekst_id");
    $tpl->set_var("Trn_categories_id", get_param("categories_id"));
    $tpl->set_var("Rqd_tekst_id", get_param("tekst_id"));
    $ptekst_id = get_param("tekst_id");
    $tpl->set_var("tekstenError", "");
  }
  else
  {
    $fldtekst_id = strip(get_param("tekst_id"));
    $fldnaam = strip(get_param("naam"));
    $fldnaam_uk = strip(get_param("naam_uk"));
    $fldtekst = strip(get_param("tekst"));
    $fldtekst_uk = strip(get_param("tekst_uk"));
    $tpl->set_var("Trn_categories_id", get_param("Trn_categories_id"));
    $ptekst_id = get_param("PK_tekst_id");
    $tpl->set_var("stekstenErr", $stekstenErr);
    $tpl->set_var("FormTitle", $sFormTitle);
    $tpl->parse("tekstenError", false);
  }
//-------------------------------

//-------------------------------
// Load all form fields

  $fldplaatjes = get_param("plaatjes");
//-------------------------------

//-------------------------------
// Build WHERE statement
//-------------------------------
  
  if( !strlen($ptekst_id)) $bPK = false;
  
  $sWhere .= "tekst_id=" . tosql($ptekst_id, "Number");
  $tpl->set_var("PK_tekst_id", $ptekst_id);
//-------------------------------
//-------------------------------
// teksten Open Event begin
// teksten Open Event end
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Build SQL statement and execute query
//-------------------------------
  $sSQL = "select * from teksten where " . $sWhere;
  // Execute SQL statement
  $db->query($sSQL);
  $bIsUpdateMode = ($bPK && !($sAction == "insert" && $sForm == "teksten") && $db->next_record());
//-------------------------------

//-------------------------------
// Load all fields into variables from recordset or input parameters
//-------------------------------
  if($bIsUpdateMode)
  {
    $fldtekst_id = $db->f("tekst_id");
//-------------------------------
// Load data from recordset when form displayed first time
//-------------------------------
    if($stekstenErr == "") 
    {
      $fldnaam = $db->f("naam");
      $fldnaam_uk = $db->f("naam_uk");
      $fldtekst = $db->f("tekst");
      $fldtekst_uk = $db->f("tekst_uk");
    }
    $tpl->set_var("tekstenInsert", "");
    $tpl->parse("tekstenEdit", false);
//-------------------------------
// teksten ShowEdit Event begin
// teksten ShowEdit Event end
//-------------------------------
  }
  else
  {
    if($stekstenErr == "")
    {
      $fldtekst_id = tohtml(get_param("tekst_id"));
    }
    $tpl->set_var("tekstenEdit", "");
    $tpl->set_var("tekstenInsert", "");
//-------------------------------
// teksten ShowInsert Event begin
// teksten ShowInsert Event end
//-------------------------------
  }
  $tpl->parse("tekstenCancel", false);
  if($stekstenErr == "")
  {
//-------------------------------
// teksten Show Event begin
$fldedit="<img border=0 src=files/ed.gif alt=Aanpassen>";
$fldplaatjes="<a class=blue HREF=javascript:void(0) ONCLICK=open('../uploader/plaatjes.php','miniwin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=300,height=600')><LI>Plaatjes overzicht</LI>";
// teksten Show Event end
//-------------------------------
  }

//-------------------------------
// Show form field
//-------------------------------
    $tpl->set_var("tekst_id", tohtml($fldtekst_id));
    $tpl->set_var("naam", tohtml($fldnaam));
    $tpl->set_var("naam_uk", tohtml($fldnaam_uk));
      $tpl->set_var("plaatjes", $fldplaatjes);
    $tpl->set_var("tekst", tohtml($fldtekst));
    $tpl->set_var("tekst_uk", tohtml($fldtekst_uk));
  $tpl->parse("Formteksten", false);

//-------------------------------
// teksten Close Event begin
// teksten Close Event end
//-------------------------------

//-------------------------------
// teksten Show end
//-------------------------------
}
//===============================
?>