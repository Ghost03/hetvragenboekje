<?php
/*********************************************************************************
 *       Filename: nieuwsRecord2.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// nieuwsRecord2 CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// nieuwsRecord2 CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "nieuwsRecord2.php";
$template_filename = "nieuwsRecord2.html";
//===============================



//===============================
// nieuwsRecord2 PageSecurity begin
check_security(3);
// nieuwsRecord2 PageSecurity end
//===============================

//===============================
// nieuwsRecord2 Open Event begin
// nieuwsRecord2 Open Event end
//===============================

//===============================
// nieuwsRecord2 OpenAnyPage Event start
// nieuwsRecord2 OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// nieuwsRecord2 Show begin

//===============================
// Perform the form's action
//-------------------------------
// Initialize error variables
//-------------------------------
$snieuwsErr = "";

//-------------------------------
// Select the FormAction
//-------------------------------
switch ($sForm) {
  case "nieuws":
    nieuws_action($sAction);
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
Header_show();Form_show();titel_show();nieuws_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// nieuwsRecord2 Show end

//===============================
// nieuwsRecord2 Close Event begin
// nieuwsRecord2 Close Event end
//===============================
//********************************************************************************


//===============================
// Action of the Record Form
//-------------------------------
function nieuws_action($sAction)
{
//-------------------------------
// Initialize variables  
//-------------------------------
  global $db;
  global $tpl;
  global $sForm;
  global $snieuwsErr;
  $bExecSQL = true;
  $sActionFileName = "";
  $sParams = "?";
  $sWhere = "";
  $bErr = false;
  $pPKnieuws_id = "";
  $fldtitel = "";
  $fldtitel_uk = "";
  $flddatum = "";
  $fldalinea1 = "";
  $fldalinea1_uk = "";
  $fldalinea2 = "";
  $fldalinea2_uk = "";
  $fldcategories_id = "";
//-------------------------------

//-------------------------------
// nieuws Action begin
//-------------------------------
  $sActionFileName = "nieuwsRecord.php";
  $sParams .= "nieuws_id=" . urlencode(get_param("Trn_nieuws_id"));

//-------------------------------
// CANCEL action
//-------------------------------
  if($sAction == "cancel")
  {

//-------------------------------
// nieuws BeforeCancel Event begin
// nieuws BeforeCancel Event end
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
    $pPKnieuws_id = get_param("PK_nieuws_id");
    if( !strlen($pPKnieuws_id)) return;
    $sWhere = "nieuws_id=" . tosql($pPKnieuws_id, "Number");
  }
//-------------------------------


//-------------------------------
// Load all form fields into variables
//-------------------------------
  $fldtitel = get_param("titel");
  $fldtitel_uk = get_param("titel_uk");
  $flddatum = get_param("datum");
  $fldalinea1 = get_param("alinea1");
  $fldalinea1_uk = get_param("alinea1_uk");
  $fldalinea2 = get_param("alinea2");
  $fldalinea2_uk = get_param("alinea2_uk");
  $fldcategories_id = get_param("categories_id");

//-------------------------------
// Validate fields
//-------------------------------
  if($sAction == "insert" || $sAction == "update") 
  {
    if(!is_number($fldcategories_id))
      $snieuwsErr .= "The value in field Type bericht is incorrect.<br>";
    
//-------------------------------
// nieuws Check Event begin
// nieuws Check Event end
//-------------------------------
    if(strlen($snieuwsErr)) return;
  }
//-------------------------------


//-------------------------------
// Create SQL statement
//-------------------------------
  switch(strtolower($sAction)) 
  {
    case "insert":
//-------------------------------
// nieuws Insert Event begin
// nieuws Insert Event end
//-------------------------------
        $sSQL = "insert into nieuws (" . 
          "titel," . 
          "titel_uk," . 
          "datum," . 
          "alinea1," . 
          "alinea1_uk," . 
          "alinea2," . 
          "alinea2_uk," . 
          "categories_id)" . 
          " values (" . 
          tosql($fldtitel, "Text") . "," . 
          tosql($fldtitel_uk, "Text") . "," . 
          tosql($flddatum, "Text") . "," . 
          tosql($fldalinea1, "Text") . "," . 
          tosql($fldalinea1_uk, "Text") . "," . 
          tosql($fldalinea2, "Text") . "," . 
          tosql($fldalinea2_uk, "Memo") . "," . 
          tosql($fldcategories_id, "Number") . 
          ")";
    break;
    case "update":

//-------------------------------
// nieuws Update Event begin
// nieuws Update Event end
//-------------------------------
        $sSQL = "update nieuws set " .
          "titel=" . tosql($fldtitel, "Text") .
          ",titel_uk=" . tosql($fldtitel_uk, "Text") .
          ",datum=" . tosql($flddatum, "Text") .
          ",alinea1=" . tosql($fldalinea1, "Text") .
          ",alinea1_uk=" . tosql($fldalinea1_uk, "Text") .
          ",alinea2=" . tosql($fldalinea2, "Text") .
          ",alinea2_uk=" . tosql($fldalinea2_uk, "Memo") .
          ",categories_id=" . tosql($fldcategories_id, "Number");
        $sSQL .= " where " . $sWhere;
    break;
    case "delete":
//-------------------------------
// nieuws Delete Event begin
// nieuws Delete Event end
//-------------------------------
        $sSQL = "delete from nieuws where " . $sWhere;
    break;
  }
//-------------------------------
//-------------------------------
// nieuws BeforeExecute Event begin
// nieuws BeforeExecute Event end
//-------------------------------

//-------------------------------
// Execute SQL statement
//-------------------------------
  if(strlen($snieuwsErr)) return;
  if($bExecSQL)
    $db->query($sSQL);
  header("Location: " . $sActionFileName . $sParams);
  exit;
//-------------------------------
// nieuws Action end
//-------------------------------
}

//===============================
// Display Record Form
//-------------------------------
function nieuws_show()
{
  global $db;
  global $tpl;
  global $sAction;
  global $sForm;
  global $snieuwsErr;
  
  $fldnieuws_id = "";
  $fldtitel = "";
  $fldtitel_uk = "";
  $flddatum = "";
  $fldalinea1 = "";
  $fldalinea1_uk = "";
  $fldalinea2 = "";
  $fldalinea2_uk = "";
  $fldcategories_id = "";
//-------------------------------
// nieuws Show begin
//-------------------------------
  $sFormTitle = "Nieuwsbericht: {titel}";
  $sWhere = "";
  $bPK = true;
  $scategories_idDisplayValue = "Algemeen";
//-------------------------------
// Load primary key and form parameters
//-------------------------------
  if($snieuwsErr == "")
  {
    $fldnieuws_id = get_param("nieuws_id");
    $tpl->set_var("Trn_nieuws_id", get_param("nieuws_id"));
    $pnieuws_id = get_param("nieuws_id");
    $tpl->set_var("nieuwsError", "");
  }
  else
  {
    $fldnieuws_id = strip(get_param("nieuws_id"));
    $fldtitel = strip(get_param("titel"));
    $fldtitel_uk = strip(get_param("titel_uk"));
    $flddatum = strip(get_param("datum"));
    $fldalinea1 = strip(get_param("alinea1"));
    $fldalinea1_uk = strip(get_param("alinea1_uk"));
    $fldalinea2 = strip(get_param("alinea2"));
    $fldalinea2_uk = strip(get_param("alinea2_uk"));
    $fldcategories_id = strip(get_param("categories_id"));
    $tpl->set_var("Trn_nieuws_id", get_param("Trn_nieuws_id"));
    $pnieuws_id = get_param("PK_nieuws_id");
    $tpl->set_var("snieuwsErr", $snieuwsErr);
    $tpl->set_var("FormTitle", $sFormTitle);
    $tpl->parse("nieuwsError", false);
  }
//-------------------------------

//-------------------------------
// Load all form fields

  $fldplaatjes = get_param("plaatjes");
//-------------------------------

//-------------------------------
// Build WHERE statement
//-------------------------------
  
  if( !strlen($pnieuws_id)) $bPK = false;
  
  $sWhere .= "nieuws_id=" . tosql($pnieuws_id, "Number");
  $tpl->set_var("PK_nieuws_id", $pnieuws_id);
//-------------------------------
//-------------------------------
// nieuws Open Event begin
// nieuws Open Event end
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Build SQL statement and execute query
//-------------------------------
  $sSQL = "select * from nieuws where " . $sWhere;
  // Execute SQL statement
  $db->query($sSQL);
  $bIsUpdateMode = ($bPK && !($sAction == "insert" && $sForm == "nieuws") && $db->next_record());
//-------------------------------

//-------------------------------
// Load all fields into variables from recordset or input parameters
//-------------------------------
  if($bIsUpdateMode)
  {
    $fldnieuws_id = $db->f("nieuws_id");
//-------------------------------
// Load data from recordset when form displayed first time
//-------------------------------
    if($snieuwsErr == "") 
    {
      $fldtitel = $db->f("titel");
      $fldtitel_uk = $db->f("titel_uk");
      $flddatum = $db->f("datum");
      $fldalinea1 = $db->f("alinea1");
      $fldalinea1_uk = $db->f("alinea1_uk");
      $fldalinea2 = $db->f("alinea2");
      $fldalinea2_uk = $db->f("alinea2_uk");
      $fldcategories_id = $db->f("categories_id");
    }
    $tpl->set_var("nieuwsInsert", "");
    $tpl->parse("nieuwsEdit", false);
//-------------------------------
// nieuws ShowEdit Event begin
// nieuws ShowEdit Event end
//-------------------------------
  }
  else
  {
    if($snieuwsErr == "")
    {
      $fldnieuws_id = tohtml(get_param("nieuws_id"));
    }
    $tpl->set_var("nieuwsEdit", "");
    $tpl->parse("nieuwsInsert", false);
//-------------------------------
// nieuws ShowInsert Event begin
// nieuws ShowInsert Event end
//-------------------------------
  }
  $tpl->parse("nieuwsCancel", false);
  if($snieuwsErr == "")
  {
//-------------------------------
// nieuws Show Event begin
$fldplaatjes="<a class=blue HREF=javascript:void(0) ONCLICK=open('../uploader/plaatjes.php','miniwin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=300,height=600')><LI>Plaatjes overzicht</LI>";
// nieuws Show Event end
//-------------------------------
  }

//-------------------------------
// Show form field
//-------------------------------
    $tpl->set_var("nieuws_id", tohtml($fldnieuws_id));
    $tpl->set_var("titel", tohtml($fldtitel));
    $tpl->set_var("titel_uk", tohtml($fldtitel_uk));
    $tpl->set_var("datum", tohtml($flddatum));
    $tpl->set_var("alinea1", tohtml($fldalinea1));
    $tpl->set_var("alinea1_uk", tohtml($fldalinea1_uk));
      $tpl->set_var("plaatjes", $fldplaatjes);
    $tpl->set_var("alinea2", tohtml($fldalinea2));
    $tpl->set_var("alinea2_uk", tohtml($fldalinea2_uk));
    $tpl->set_var("nieuwsLBcategories_id", "");
    $tpl->set_var("ID", "20");
    $tpl->set_var("Value", $scategories_idDisplayValue);
    $tpl->set_var("Selected", "");
    $tpl->parse("nieuwsLBcategories_id", true);
    $lookup_categories_id = db_fill_array("SELECT *  FROM `categories`  WHERE parent = 15");

    if(is_array($lookup_categories_id))
    {
      reset($lookup_categories_id);
      while(list($key, $value) = each($lookup_categories_id))
      {
        $tpl->set_var("ID", $key);
        $tpl->set_var("Value", $value);
        if($key == $fldcategories_id)
          $tpl->set_var("Selected", "SELECTED" );
        else 
          $tpl->set_var("Selected", "");
        $tpl->parse("nieuwsLBcategories_id", true);
      }
    }
    
  $tpl->parse("Formnieuws", false);

//-------------------------------
// nieuws Close Event begin
// nieuws Close Event end
//-------------------------------

//-------------------------------
// nieuws Show end
//-------------------------------
}
//===============================

//===============================
// Display Menu Form
//-------------------------------
function titel_show()
{
  global $tpl;
  global $db;
  $sFormTitle = "Nieuws aanpassen";

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

?>