<?php
/*********************************************************************************
 *       Filename: paginabloktekst.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// paginabloktekst CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// paginabloktekst CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "paginabloktekst.php";
$template_filename = "paginabloktekst.html";
//===============================



//===============================
// paginabloktekst PageSecurity begin
check_security(3);
// paginabloktekst PageSecurity end
//===============================

//===============================
// paginabloktekst Open Event begin
// paginabloktekst Open Event end
//===============================

//===============================
// paginabloktekst OpenAnyPage Event start
// paginabloktekst OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// paginabloktekst Show begin

//===============================
// Perform the form's action
//-------------------------------
// Initialize error variables
//-------------------------------
$sbloktekstErr = "";

//-------------------------------
// Select the FormAction
//-------------------------------
switch ($sForm) {
  case "bloktekst":
    bloktekst_action($sAction);
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
Header_show();Form_show();titel_show();overzicht_show();bloktekst_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// paginabloktekst Show end

//===============================
// paginabloktekst Close Event begin
// paginabloktekst Close Event end
//===============================
//********************************************************************************


//===============================
// Display Menu Form
//-------------------------------
function titel_show()
{
  global $tpl;
  global $db;
  $sFormTitle = "Tekstblokken beheer";

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
function bloktekst_action($sAction)
{
//-------------------------------
// Initialize variables  
//-------------------------------
  global $db;
  global $tpl;
  global $sForm;
  global $sbloktekstErr;
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
  $fldtype = "";
//-------------------------------

//-------------------------------
// bloktekst Action begin
//-------------------------------
  $sActionFileName = "paginabloktekst.php";
  $sParams .= "categories_id=" . urlencode(get_param("Trn_categories_id"));

//-------------------------------
// CANCEL action
//-------------------------------
  if($sAction == "cancel")
  {

//-------------------------------
// bloktekst BeforeCancel Event begin
// bloktekst BeforeCancel Event end
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
  $fldtype = get_param("type");

//-------------------------------
// Validate fields
//-------------------------------
  if($sAction == "insert" || $sAction == "update") 
  {
    if(!is_number($fldtype))
      $sbloktekstErr .= "The value in field type is incorrect.<br>";
    
//-------------------------------
// bloktekst Check Event begin
// bloktekst Check Event end
//-------------------------------
    if(strlen($sbloktekstErr)) return;
  }
//-------------------------------


//-------------------------------
// Create SQL statement
//-------------------------------
  switch(strtolower($sAction)) 
  {
    case "insert":
//-------------------------------
// bloktekst Insert Event begin
// bloktekst Insert Event end
//-------------------------------
        $sSQL = "insert into teksten (" . 
          "tekst_id," . 
          "naam," . 
          "naam_uk," . 
          "tekst," . 
          "tekst_uk," . 
          "type)" . 
          " values (" . 
          tosql($fldtekst_id, "Number") . "," . 
          tosql($fldnaam, "Text") . "," . 
          tosql($fldnaam_uk, "Text") . "," . 
          tosql($fldtekst, "Text") . "," . 
          tosql($fldtekst_uk, "Memo") . "," . 
          tosql($fldtype, "Number") . 
          ")";
    break;
    case "update":

//-------------------------------
// bloktekst Update Event begin
// bloktekst Update Event end
//-------------------------------
        $sSQL = "update teksten set " .
          "naam=" . tosql($fldnaam, "Text") .
          ",naam_uk=" . tosql($fldnaam_uk, "Text") .
          ",tekst=" . tosql($fldtekst, "Text") .
          ",tekst_uk=" . tosql($fldtekst_uk, "Memo") .
          ",type=" . tosql($fldtype, "Number");
        $sSQL .= " where " . $sWhere;
    break;
    case "delete":
//-------------------------------
// bloktekst Delete Event begin
// bloktekst Delete Event end
//-------------------------------
        $sSQL = "delete from teksten where " . $sWhere;
    break;
  }
//-------------------------------
//-------------------------------
// bloktekst BeforeExecute Event begin
// bloktekst BeforeExecute Event end
//-------------------------------

//-------------------------------
// Execute SQL statement
//-------------------------------
  if(strlen($sbloktekstErr)) return;
  if($bExecSQL)
    $db->query($sSQL);
  header("Location: " . $sActionFileName . $sParams);
  exit;
//-------------------------------
// bloktekst Action end
//-------------------------------
}

//===============================
// Display Record Form
//-------------------------------
function bloktekst_show()
{
  global $db;
  global $tpl;
  global $sAction;
  global $sForm;
  global $sbloktekstErr;
  
  $fldtekst_id = "";
  $fldnaam = "";
  $fldnaam_uk = "";
  $fldtekst = "";
  $fldtekst_uk = "";
  $fldtype = "";
//-------------------------------
// bloktekst Show begin
//-------------------------------
  $sFormTitle = "Tekstblok {naam} aanpassen";
  $sWhere = "";
  $bPK = true;
//-------------------------------
// Load primary key and form parameters
//-------------------------------
  if($sbloktekstErr == "")
  {
    $fldtekst_id = get_param("tekst_id");
    $tpl->set_var("Trn_categories_id", get_param("categories_id"));
    $tpl->set_var("Rqd_tekst_id", get_param("tekst_id"));
    $ptekst_id = get_param("tekst_id");
    $tpl->set_var("bloktekstError", "");
  }
  else
  {
    $fldtekst_id = strip(get_param("tekst_id"));
    $fldnaam = strip(get_param("naam"));
    $fldnaam_uk = strip(get_param("naam_uk"));
    $fldtekst = strip(get_param("tekst"));
    $fldtekst_uk = strip(get_param("tekst_uk"));
    $fldtype = strip(get_param("type"));
    $tpl->set_var("Trn_categories_id", get_param("Trn_categories_id"));
    $ptekst_id = get_param("PK_tekst_id");
    $tpl->set_var("sbloktekstErr", $sbloktekstErr);
    $tpl->set_var("FormTitle", $sFormTitle);
    $tpl->parse("bloktekstError", false);
  }
//-------------------------------

//-------------------------------
// Load all form fields

//-------------------------------

//-------------------------------
// Build WHERE statement
//-------------------------------
  
  if( !strlen($ptekst_id)) $bPK = false;
  
  $sWhere .= "tekst_id=" . tosql($ptekst_id, "Number");
  $tpl->set_var("PK_tekst_id", $ptekst_id);
//-------------------------------
//-------------------------------
// bloktekst Open Event begin
// bloktekst Open Event end
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Build SQL statement and execute query
//-------------------------------
  $sSQL = "select * from teksten where " . $sWhere;
  // Execute SQL statement
  $db->query($sSQL);
  $bIsUpdateMode = ($bPK && !($sAction == "insert" && $sForm == "bloktekst") && $db->next_record());
//-------------------------------

//-------------------------------
// Load all fields into variables from recordset or input parameters
//-------------------------------
  if($bIsUpdateMode)
  {
    $fldtekst_id = $db->f("tekst_id");
    $fldtype = $db->f("type");
//-------------------------------
// Load data from recordset when form displayed first time
//-------------------------------
    if($sbloktekstErr == "") 
    {
      $fldnaam = $db->f("naam");
      $fldnaam_uk = $db->f("naam_uk");
      $fldtekst = $db->f("tekst");
      $fldtekst_uk = $db->f("tekst_uk");
    }
    $tpl->set_var("bloktekstInsert", "");
    $tpl->parse("bloktekstEdit", false);
//-------------------------------
// bloktekst ShowEdit Event begin
// bloktekst ShowEdit Event end
//-------------------------------
  }
  else
  {
    if($sbloktekstErr == "")
    {
      $fldtekst_id = tohtml(get_param("tekst_id"));
      $fldtype= "1";
    }
    $tpl->set_var("bloktekstEdit", "");
    $tpl->parse("bloktekstInsert", false);
//-------------------------------
// bloktekst ShowInsert Event begin
// bloktekst ShowInsert Event end
//-------------------------------
  }
  $tpl->parse("bloktekstCancel", false);
//-------------------------------
// bloktekst Show Event begin
// bloktekst Show Event end
//-------------------------------

//-------------------------------
// Show form field
//-------------------------------
    $tpl->set_var("tekst_id", tohtml($fldtekst_id));
    $tpl->set_var("naam", tohtml($fldnaam));
    $tpl->set_var("naam_uk", tohtml($fldnaam_uk));
    $tpl->set_var("tekst", tohtml($fldtekst));
    $tpl->set_var("tekst_uk", tohtml($fldtekst_uk));
    $tpl->set_var("type", tohtml($fldtype));
  $tpl->parse("Formbloktekst", false);

//-------------------------------
// bloktekst Close Event begin
// bloktekst Close Event end
//-------------------------------

//-------------------------------
// bloktekst Show end
//-------------------------------
}
//===============================

//===============================
// Display Grid Form
//-------------------------------
function overzicht_show()
{
//-------------------------------
// Initialize variables  
//-------------------------------
  
  global $tpl;
  global $db;
  global $soverzichtErr;
  $sWhere = "";
  $sOrder = "";
  $sSQL = "";
  $sFormTitle = "Overzicht tekstblokken";
  $HasParam = false;
  $iRecordsPerPage = 20;
  $iCounter = 0;
  $iPage = 0;
  $bEof = false;
  $iSort = "";
  $iSorted = "";
  $sDirection = "";
  $sSortParams = "";
  $sActionFileName = "paginabloktekst.php";


  $tpl->set_var("TransitParams", "");
  $tpl->set_var("FormParams", "");


  $sWhere = " WHERE type=1";

//-------------------------------
// Build ORDER BY statement
//-------------------------------
  $iSort = get_param("Formoverzicht_Sorting");
  $iSorted = get_param("Formoverzicht_Sorted");
  if(!$iSort)
  {
    $tpl->set_var("Form_Sorting", "");
  }
  else
  {
    if($iSort == $iSorted)
    {
      $tpl->set_var("Form_Sorting", "");
      $sDirection = " DESC";
      $sSortParams = "Formoverzicht_Sorting=" . $iSort . "&Formoverzicht_Sorted=" . $iSort . "&";
    }
    else
    {
      $tpl->set_var("Form_Sorting", $iSort);
      $sDirection = " ASC";
      $sSortParams = "Formoverzicht_Sorting=" . $iSort . "&Formoverzicht_Sorted=" . "&";
    }
    if ($iSort == 1) $sOrder = " order by t.naam" . $sDirection;
    if ($iSort == 2) $sOrder = " order by t.naam_uk" . $sDirection;
  }

//-------------------------------
// Build base SQL statement
//-------------------------------
  $sSQL = "select t.naam as t_naam, " . 
    "t.naam_uk as t_naam_uk, " . 
    "t.tekst_id as t_tekst_id, " . 
    "t.type as t_type " . 
    " from teksten t ";
//-------------------------------

//-------------------------------
// overzicht Open Event begin
// overzicht Open Event end
//-------------------------------

//-------------------------------
// Assemble full SQL statement
//-------------------------------
  $sSQL .= $sWhere . $sOrder;
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Process the link to the record page
//-------------------------------
  $tpl->set_var("FormAction", $sActionFileName);
//-------------------------------

//-------------------------------
// Process the parameters for sorting
//-------------------------------
  $tpl->set_var("SortParams", $sSortParams);
//-------------------------------

//-------------------------------
// Execute SQL statement
//-------------------------------
  $db->query($sSQL);
  $next_record = $db->next_record();
//-------------------------------
// Process empty recordset
//-------------------------------
  if(!$next_record)
  {
    $tpl->set_var("DListoverzicht", "");
    $tpl->parse("overzichtNoRecords", false);
    $tpl->set_var("overzichtNavigator", "");
    $tpl->parse("Formoverzicht", false);
    return;
  }
//-------------------------------

//-------------------------------
// Initialize page counter and records per page
//-------------------------------
  $iRecordsPerPage = 20;
  $iCounter = 0;
//-------------------------------

//-------------------------------
// Process page scroller
//-------------------------------
  $iPage = get_param("Formoverzicht_Page");
  if(!strlen($iPage)) $iPage = 1; else $iPage = intval($iPage);

  if(($iPage - 1) * $iRecordsPerPage != 0)
  {
    do
    {
      $iCounter++;
    } while ($iCounter < ($iPage - 1) * $iRecordsPerPage && $db->next_record());
    $next_record = $db->next_record();
  }

  $iCounter = 0;
//-------------------------------

//-------------------------------
// Display grid based on recordset
//-------------------------------
  while($next_record  && $iCounter < $iRecordsPerPage)
  {
//-------------------------------
// Create field variables based on database fields
//-------------------------------
    $fldedit_URLLink = "paginabloktekst.php";
    $fldedit_tekst_id = $db->f("t_tekst_id");
    $fldnaam = $db->f("t_naam");
    $fldnaam_uk = $db->f("t_naam_uk");
    $fldtekst_id = $db->f("t_tekst_id");
    $fldtype = $db->f("t_type");
    $next_record = $db->next_record();
    
//-------------------------------
// overzicht Show begin
//-------------------------------

//-------------------------------
// overzicht Show Event begin
$fldedit="<img border=0 src=files/ed.gif alt=Aanpassen>";
// overzicht Show Event end
//-------------------------------

//-------------------------------
// Replace Template fields with database values
//-------------------------------
    
    $tpl->set_var("tekst_id", tohtml($fldtekst_id));
    $tpl->set_var("type", tohtml($fldtype));
      $tpl->set_var("naam", tohtml($fldnaam));
      $tpl->set_var("naam_uk", tohtml($fldnaam_uk));
      $tpl->set_var("edit", $fldedit);
      $tpl->set_var("edit_URLLink", $fldedit_URLLink);
      $tpl->set_var("Prmedit_tekst_id", urlencode($fldedit_tekst_id));
    $tpl->parse("DListoverzicht", true);
//-------------------------------
// overzicht Show end
//-------------------------------

//-------------------------------
// Move to the next record and increase record counter
//-------------------------------
    
    $iCounter++;
  }

  // overzicht Navigation begin
  $bEof = $next_record;
  // Parse Navigator
  if(!$bEof && $iPage == 1)
    $tpl->set_var("overzichtNavigator", "");
  else 
  {
    if(!$bEof)
      $tpl->set_var("overzichtNavigatorLastPage", "_");
    else
      $tpl->set_var("NextPage", ($iPage + 1));
    if($iPage == 1)
      $tpl->set_var("overzichtNavigatorFirstPage", "_");
    else
      $tpl->set_var("PrevPage", ($iPage - 1));
    $tpl->set_var("overzichtCurrentPage", $iPage);
    $tpl->parse( "overzichtNavigator", false);
  }

//-------------------------------
// overzicht Navigation end
//-------------------------------

//-------------------------------
// Finish form processing
//-------------------------------
  $tpl->set_var( "overzichtNoRecords", "");
  $tpl->parse( "Formoverzicht", false);
//-------------------------------
// overzicht Close Event begin
// overzicht Close Event end
//-------------------------------
}
//===============================

?>