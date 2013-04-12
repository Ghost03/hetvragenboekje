<?php
/*********************************************************************************
 *       Filename: brochures.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// brochures CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// brochures CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "brochures.php";
$template_filename = "brochures.html";
//===============================



//===============================
// brochures PageSecurity begin
check_security(3);
// brochures PageSecurity end
//===============================

//===============================
// brochures Open Event begin
// brochures Open Event end
//===============================

//===============================
// brochures OpenAnyPage Event start
// brochures OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// brochures Show begin

//===============================
// Perform the form's action
//-------------------------------
// Initialize error variables
//-------------------------------
$sBrochures2Err = "";

//-------------------------------
// Select the FormAction
//-------------------------------
switch ($sForm) {
  case "Brochures2":
    Brochures2_action($sAction);
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
Header_show();Form_show();titel_show();Brochures_show();Brochures2_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// brochures Show end

//===============================
// brochures Close Event begin
// brochures Close Event end
//===============================
//********************************************************************************


//===============================
// Display Grid Form
//-------------------------------
function Brochures_show()
{
//-------------------------------
// Initialize variables  
//-------------------------------
  
  global $tpl;
  global $db;
  global $sBrochuresErr;
  $sWhere = "";
  $sOrder = "";
  $sSQL = "";
  $sFormTitle = "Brochure overzicht";
  $HasParam = false;
  $iRecordsPerPage = 10;
  $iCounter = 0;
  $iPage = 0;
  $bEof = false;
  $iSort = "";
  $iSorted = "";
  $sDirection = "";
  $sSortParams = "";
  $sActionFileName = "brochures.php";


  $tpl->set_var("TransitParams", "");
  $tpl->set_var("FormParams", "");



//-------------------------------
// Build ORDER BY statement
//-------------------------------
  $sOrder = " order by f.foldernaam Asc";
  $iSort = get_param("FormBrochures_Sorting");
  $iSorted = get_param("FormBrochures_Sorted");
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
      $sSortParams = "FormBrochures_Sorting=" . $iSort . "&FormBrochures_Sorted=" . $iSort . "&";
    }
    else
    {
      $tpl->set_var("Form_Sorting", $iSort);
      $sDirection = " ASC";
      $sSortParams = "FormBrochures_Sorting=" . $iSort . "&FormBrochures_Sorted=" . "&";
    }
    if ($iSort == 1) $sOrder = " order by f.foldernaam" . $sDirection;
    if ($iSort == 2) $sOrder = " order by f.foldernaam_uk" . $sDirection;
  }

//-------------------------------
// Build base SQL statement
//-------------------------------
  $sSQL = "select f.folder_id as f_folder_id, " . 
    "f.foldernaam as f_foldernaam, " . 
    "f.foldernaam_uk as f_foldernaam_uk " . 
    " from folders f ";
//-------------------------------

//-------------------------------
// Brochures Open Event begin
// Brochures Open Event end
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
    $tpl->set_var("DListBrochures", "");
    $tpl->parse("BrochuresNoRecords", false);
    $tpl->set_var("BrochuresNavigator", "");
    $tpl->parse("FormBrochures", false);
    return;
  }
//-------------------------------

//-------------------------------
// Initialize page counter and records per page
//-------------------------------
  $iRecordsPerPage = 10;
  $iCounter = 0;
//-------------------------------

//-------------------------------
// Process page scroller
//-------------------------------
  $iPage = get_param("FormBrochures_Page");
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
    $fldedit_URLLink = "brochures.php";
    $fldedit_folder_id = $db->f("f_folder_id");
    $fldfolder_id = $db->f("f_folder_id");
    $fldfoldernaam = $db->f("f_foldernaam");
    $fldfoldernaam_uk = $db->f("f_foldernaam_uk");
    $next_record = $db->next_record();
    
//-------------------------------
// Brochures Show begin
//-------------------------------

//-------------------------------
// Brochures Show Event begin
$fldedit="<img border=0 src=files/ed.gif alt=Aanpassen>";
// Brochures Show Event end
//-------------------------------

//-------------------------------
// Replace Template fields with database values
//-------------------------------
    
    $tpl->set_var("folder_id", tohtml($fldfolder_id));
      $tpl->set_var("foldernaam", tohtml($fldfoldernaam));
      $tpl->set_var("foldernaam_uk", tohtml($fldfoldernaam_uk));
      $tpl->set_var("edit", $fldedit);
      $tpl->set_var("edit_URLLink", $fldedit_URLLink);
      $tpl->set_var("Prmedit_folder_id", urlencode($fldedit_folder_id));
    $tpl->parse("DListBrochures", true);
//-------------------------------
// Brochures Show end
//-------------------------------

//-------------------------------
// Move to the next record and increase record counter
//-------------------------------
    
    $iCounter++;
  }

  // Brochures Navigation begin
  $bEof = $next_record;
  // Parse Navigator
  if(!$bEof && $iPage == 1)
    $tpl->set_var("BrochuresNavigator", "");
  else 
  {
    if(!$bEof)
      $tpl->set_var("BrochuresNavigatorLastPage", "_");
    else
      $tpl->set_var("NextPage", ($iPage + 1));
    if($iPage == 1)
      $tpl->set_var("BrochuresNavigatorFirstPage", "_");
    else
      $tpl->set_var("PrevPage", ($iPage - 1));
    $tpl->set_var("BrochuresCurrentPage", $iPage);
    $tpl->parse( "BrochuresNavigator", false);
  }

//-------------------------------
// Brochures Navigation end
//-------------------------------

//-------------------------------
// Finish form processing
//-------------------------------
  $tpl->set_var( "BrochuresNoRecords", "");
  $tpl->parse( "FormBrochures", false);
//-------------------------------
// Brochures Close Event begin
// Brochures Close Event end
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
  $sFormTitle = "Brochure aanvraag beheer";

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
function Brochures2_action($sAction)
{
//-------------------------------
// Initialize variables  
//-------------------------------
  global $db;
  global $tpl;
  global $sForm;
  global $sBrochures2Err;
  $bExecSQL = true;
  $sActionFileName = "";
  $sWhere = "";
  $bErr = false;
  $pPKfolder_id = "";
  $fldfoldernaam = "";
  $fldfoldernaam_uk = "";
//-------------------------------

//-------------------------------
// Brochures2 Action begin
//-------------------------------
  $sActionFileName = "brochures.php";

//-------------------------------
// CANCEL action
//-------------------------------
  if($sAction == "cancel")
  {

//-------------------------------
// Brochures2 BeforeCancel Event begin
// Brochures2 BeforeCancel Event end
//-------------------------------
    header("Location: " . $sActionFileName);
    exit;
  }
//-------------------------------


//-------------------------------
// Build WHERE statement
//-------------------------------
  if($sAction == "update" || $sAction == "delete") 
  {
    $pPKfolder_id = get_param("PK_folder_id");
    if( !strlen($pPKfolder_id)) return;
    $sWhere = "folder_id=" . tosql($pPKfolder_id, "Number");
  }
//-------------------------------


//-------------------------------
// Load all form fields into variables
//-------------------------------
  $fldfoldernaam = get_param("foldernaam");
  $fldfoldernaam_uk = get_param("foldernaam_uk");

//-------------------------------
// Validate fields
//-------------------------------
  if($sAction == "insert" || $sAction == "update") 
  {
//-------------------------------
// Brochures2 Check Event begin
// Brochures2 Check Event end
//-------------------------------
    if(strlen($sBrochures2Err)) return;
  }
//-------------------------------


//-------------------------------
// Create SQL statement
//-------------------------------
  switch(strtolower($sAction)) 
  {
    case "insert":
//-------------------------------
// Brochures2 Insert Event begin
// Brochures2 Insert Event end
//-------------------------------
        $sSQL = "insert into folders (" . 
          "foldernaam," . 
          "foldernaam_uk)" . 
          " values (" . 
          tosql($fldfoldernaam, "Text") . "," . 
          tosql($fldfoldernaam_uk, "Text") . 
          ")";
    break;
    case "update":

//-------------------------------
// Brochures2 Update Event begin
// Brochures2 Update Event end
//-------------------------------
        $sSQL = "update folders set " .
          "foldernaam=" . tosql($fldfoldernaam, "Text") .
          ",foldernaam_uk=" . tosql($fldfoldernaam_uk, "Text");
        $sSQL .= " where " . $sWhere;
    break;
    case "delete":
//-------------------------------
// Brochures2 Delete Event begin
// Brochures2 Delete Event end
//-------------------------------
        $sSQL = "delete from folders where " . $sWhere;
    break;
  }
//-------------------------------
//-------------------------------
// Brochures2 BeforeExecute Event begin
// Brochures2 BeforeExecute Event end
//-------------------------------

//-------------------------------
// Execute SQL statement
//-------------------------------
  if(strlen($sBrochures2Err)) return;
  if($bExecSQL)
    $db->query($sSQL);
  header("Location: " . $sActionFileName);
  exit;
//-------------------------------
// Brochures2 Action end
//-------------------------------
}

//===============================
// Display Record Form
//-------------------------------
function Brochures2_show()
{
  global $db;
  global $tpl;
  global $sAction;
  global $sForm;
  global $sBrochures2Err;
  
  $fldfolder_id = "";
  $fldfoldernaam = "";
  $fldfoldernaam_uk = "";
//-------------------------------
// Brochures2 Show begin
//-------------------------------
  $sFormTitle = "Brochure aanpassen";
  $sWhere = "";
  $bPK = true;
//-------------------------------
// Load primary key and form parameters
//-------------------------------
  if($sBrochures2Err == "")
  {
    $fldfolder_id = get_param("folder_id");
    $pfolder_id = get_param("folder_id");
    $tpl->set_var("Brochures2Error", "");
  }
  else
  {
    $fldfolder_id = strip(get_param("folder_id"));
    $fldfoldernaam = strip(get_param("foldernaam"));
    $fldfoldernaam_uk = strip(get_param("foldernaam_uk"));
    $pfolder_id = get_param("PK_folder_id");
    $tpl->set_var("sBrochures2Err", $sBrochures2Err);
    $tpl->set_var("FormTitle", $sFormTitle);
    $tpl->parse("Brochures2Error", false);
  }
//-------------------------------

//-------------------------------
// Load all form fields

//-------------------------------

//-------------------------------
// Build WHERE statement
//-------------------------------
  
  if( !strlen($pfolder_id)) $bPK = false;
  
  $sWhere .= "folder_id=" . tosql($pfolder_id, "Number");
  $tpl->set_var("PK_folder_id", $pfolder_id);
//-------------------------------
//-------------------------------
// Brochures2 Open Event begin
// Brochures2 Open Event end
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Build SQL statement and execute query
//-------------------------------
  $sSQL = "select * from folders where " . $sWhere;
  // Execute SQL statement
  $db->query($sSQL);
  $bIsUpdateMode = ($bPK && !($sAction == "insert" && $sForm == "Brochures2") && $db->next_record());
//-------------------------------

//-------------------------------
// Load all fields into variables from recordset or input parameters
//-------------------------------
  if($bIsUpdateMode)
  {
    $fldfolder_id = $db->f("folder_id");
//-------------------------------
// Load data from recordset when form displayed first time
//-------------------------------
    if($sBrochures2Err == "") 
    {
      $fldfoldernaam = $db->f("foldernaam");
      $fldfoldernaam_uk = $db->f("foldernaam_uk");
    }
    $tpl->set_var("Brochures2Insert", "");
    $tpl->parse("Brochures2Edit", false);
//-------------------------------
// Brochures2 ShowEdit Event begin
// Brochures2 ShowEdit Event end
//-------------------------------
  }
  else
  {
    if($sBrochures2Err == "")
    {
      $fldfolder_id = tohtml(get_param("folder_id"));
    }
    $tpl->set_var("Brochures2Edit", "");
    $tpl->parse("Brochures2Insert", false);
//-------------------------------
// Brochures2 ShowInsert Event begin
// Brochures2 ShowInsert Event end
//-------------------------------
  }
  $tpl->parse("Brochures2Cancel", false);
//-------------------------------
// Brochures2 Show Event begin
// Brochures2 Show Event end
//-------------------------------

//-------------------------------
// Show form field
//-------------------------------
    $tpl->set_var("folder_id", tohtml($fldfolder_id));
    $tpl->set_var("foldernaam", tohtml($fldfoldernaam));
    $tpl->set_var("foldernaam_uk", tohtml($fldfoldernaam_uk));
  $tpl->parse("FormBrochures2", false);

//-------------------------------
// Brochures2 Close Event begin
// Brochures2 Close Event end
//-------------------------------

//-------------------------------
// Brochures2 Show end
//-------------------------------
}
//===============================
?>