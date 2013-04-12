<?php
/*********************************************************************************
 *       Filename: linksRecord.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// linksRecord CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// linksRecord CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "linksRecord.php";
$template_filename = "linksRecord.html";
//===============================



//===============================
// linksRecord PageSecurity begin
check_security(3);
// linksRecord PageSecurity end
//===============================

//===============================
// linksRecord Open Event begin
// linksRecord Open Event end
//===============================

//===============================
// linksRecord OpenAnyPage Event start
// linksRecord OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// linksRecord Show begin

//===============================
// Perform the form's action
//-------------------------------
// Initialize error variables
//-------------------------------
$slinks1Err = "";

//-------------------------------
// Select the FormAction
//-------------------------------
switch ($sForm) {
  case "links1":
    links1_action($sAction);
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
Header_show();Form_show();titel_show();links_show();links1_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// linksRecord Show end

//===============================
// linksRecord Close Event begin
// linksRecord Close Event end
//===============================
//********************************************************************************


//===============================
// Display Grid Form
//-------------------------------
function links_show()
{
//-------------------------------
// Initialize variables  
//-------------------------------
  
  global $tpl;
  global $db;
  global $slinksErr;
  $sWhere = "";
  $sOrder = "";
  $sSQL = "";
  $sFormTitle = "Linksoverzicht";
  $HasParam = false;
  $iRecordsPerPage = 20;
  $iCounter = 0;
  $iPage = 0;
  $bEof = false;
  $iSort = "";
  $iSorted = "";
  $sDirection = "";
  $sSortParams = "";
  $sActionFileName = "linksRecord.php";


  $tpl->set_var("TransitParams", "");
  $tpl->set_var("FormParams", "");



//-------------------------------
// Build ORDER BY statement
//-------------------------------
  $sOrder = " order by l.naam Asc";
  $iSort = get_param("Formlinks_Sorting");
  $iSorted = get_param("Formlinks_Sorted");
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
      $sSortParams = "Formlinks_Sorting=" . $iSort . "&Formlinks_Sorted=" . $iSort . "&";
    }
    else
    {
      $tpl->set_var("Form_Sorting", $iSort);
      $sDirection = " ASC";
      $sSortParams = "Formlinks_Sorting=" . $iSort . "&Formlinks_Sorted=" . "&";
    }
    if ($iSort == 1) $sOrder = " order by l.naam" . $sDirection;
    if ($iSort == 2) $sOrder = " order by l.naam_uk" . $sDirection;
  }

//-------------------------------
// Build base SQL statement
//-------------------------------
  $sSQL = "select l.links_id as l_links_id, " . 
    "l.naam as l_naam, " . 
    "l.naam_uk as l_naam_uk " . 
    " from links l ";
//-------------------------------

//-------------------------------
// links Open Event begin
// links Open Event end
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
    $tpl->set_var("DListlinks", "");
    $tpl->parse("linksNoRecords", false);
    $tpl->set_var("linksNavigator", "");
    $tpl->parse("Formlinks", false);
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
  $iPage = get_param("Formlinks_Page");
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
    $fldedit_URLLink = "linksRecord.php";
    $fldedit_links_id = $db->f("l_links_id");
    $fldlinks_id = $db->f("l_links_id");
    $fldnaam = $db->f("l_naam");
    $fldnaam_uk = $db->f("l_naam_uk");
    $next_record = $db->next_record();
    
//-------------------------------
// links Show begin
//-------------------------------

//-------------------------------
// links Show Event begin
$fldedit="<img border=0 src=files/ed.gif alt=Bekijk>";
// links Show Event end
//-------------------------------

//-------------------------------
// Replace Template fields with database values
//-------------------------------
    
    $tpl->set_var("links_id", tohtml($fldlinks_id));
      $tpl->set_var("naam", tohtml($fldnaam));
      $tpl->set_var("naam_uk", tohtml($fldnaam_uk));
      $tpl->set_var("edit", $fldedit);
      $tpl->set_var("edit_URLLink", $fldedit_URLLink);
      $tpl->set_var("Prmedit_links_id", urlencode($fldedit_links_id));
    $tpl->parse("DListlinks", true);
//-------------------------------
// links Show end
//-------------------------------

//-------------------------------
// Move to the next record and increase record counter
//-------------------------------
    
    $iCounter++;
  }

  // links Navigation begin
  $bEof = $next_record;
  // Parse Navigator
  if(!$bEof && $iPage == 1)
    $tpl->set_var("linksNavigator", "");
  else 
  {
    $iCounter = 1;
    $iHasPages = $iPage;
    $iDisplayPages = 0;
    $iNumberOfPages = 10;
    while($next_record && $iHasPages < $iPage + $iNumberOfPages)
    {
      if($iCounter == $iRecordsPerPage)
      {
        $iCounter = 0;
        $iHasPages = $iHasPages + 1;
      }
      $iCounter++;
      $next_record = $db->next_record();
    }
    if(!$next_record && $iCounter > 1) $iHasPages++;
    if (($iHasPages - $iPage) < intval($iNumberOfPages / 2))
      $iStartPage = $iHasPages - $iNumberOfPages;
    else
      $iStartPage = $iPage - $iNumberOfPages + intval($iNumberOfPages / 2);
    
    if($iStartPage < 0) $iStartPage = 0;
    for($iPageCount = $iStartPage + 1;  $iPageCount <= $iPage - 1; $iPageCount++)
    {
      $tpl->set_var( "NavigatorPageNumber", $iPageCount);
      $tpl->set_var( "NavigatorPageNumberView", $iPageCount);
      $tpl->parse( "linksNavigatorPages", true);
      $iDisplayPages++;
    }
    $tpl->set_var( "NavigatorPageSwitch", "_");
    $tpl->set_var( "NavigatorPageNumber", $iPage);
    $tpl->set_var( "NavigatorPageNumberView", $iPage);
    $tpl->parse( "linksNavigatorPages", true);
    $iDisplayPages++;
    $tpl->set_var( "NavigatorPageSwitch", "");
    $iPageCount = $iPage + 1;
    while ($iDisplayPages < $iNumberOfPages && $iStartPage + $iDisplayPages < $iHasPages)
    {
      $tpl->set_var( "NavigatorPageNumber", $iPageCount);
      $tpl->set_var( "NavigatorPageNumberView", $iPageCount);
      $tpl->parse( "linksNavigatorPages", true);
      $iDisplayPages++;
      $iPageCount++;
    }
    if(!$bEof)
      $tpl->set_var("linksNavigatorLastPage", "_");
    else
      $tpl->set_var("NextPage", ($iPage + 1));
    if($iPage == 1)
      $tpl->set_var("linksNavigatorFirstPage", "_");
    else
      $tpl->set_var("PrevPage", ($iPage - 1));
    $tpl->set_var("linksCurrentPage", $iPage);
    $tpl->parse( "linksNavigator", false);
  }

//-------------------------------
// links Navigation end
//-------------------------------

//-------------------------------
// Finish form processing
//-------------------------------
  $tpl->set_var( "linksNoRecords", "");
  $tpl->parse( "Formlinks", false);
//-------------------------------
// links Close Event begin
// links Close Event end
//-------------------------------
}
//===============================


//===============================
// Action of the Record Form
//-------------------------------
function links1_action($sAction)
{
//-------------------------------
// Initialize variables  
//-------------------------------
  global $db;
  global $tpl;
  global $sForm;
  global $slinks1Err;
  $bExecSQL = true;
  $sActionFileName = "";
  $sWhere = "";
  $bErr = false;
  $pPKlinks_id = "";
  $fldnaam = "";
  $fldnaam_uk = "";
  $fldurl = "";
  $fldomschrijving = "";
  $fldomschrijving_uk = "";
//-------------------------------

//-------------------------------
// links1 Action begin
//-------------------------------
  $sActionFileName = "linksRecord.php";

//-------------------------------
// CANCEL action
//-------------------------------
  if($sAction == "cancel")
  {

//-------------------------------
// links1 BeforeCancel Event begin
// links1 BeforeCancel Event end
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
    $pPKlinks_id = get_param("PK_links_id");
    if( !strlen($pPKlinks_id)) return;
    $sWhere = "links_id=" . tosql($pPKlinks_id, "Number");
  }
//-------------------------------


//-------------------------------
// Load all form fields into variables
//-------------------------------
  $fldnaam = get_param("naam");
  $fldnaam_uk = get_param("naam_uk");
  $fldurl = get_param("url");
  $fldomschrijving = get_param("omschrijving");
  $fldomschrijving_uk = get_param("omschrijving_uk");

//-------------------------------
// Validate fields
//-------------------------------
  if($sAction == "insert" || $sAction == "update") 
  {
    if(!strlen($fldnaam_uk))
      $slinks1Err .= "The value in field Naam<br><b><font color=red>Engels</font></b> is required.<br>";
    
    if(!strlen($fldomschrijving_uk))
      $slinks1Err .= "The value in field Omschrijving<br><b><font color=red>Engels</font></b> is required.<br>";
    
//-------------------------------
// links1 Check Event begin
// links1 Check Event end
//-------------------------------
    if(strlen($slinks1Err)) return;
  }
//-------------------------------


//-------------------------------
// Create SQL statement
//-------------------------------
  switch(strtolower($sAction)) 
  {
    case "insert":
//-------------------------------
// links1 Insert Event begin
// links1 Insert Event end
//-------------------------------
        $sSQL = "insert into links (" . 
          "naam," . 
          "naam_uk," . 
          "url," . 
          "omschrijving," . 
          "omschrijving_uk)" . 
          " values (" . 
          tosql($fldnaam, "Text") . "," . 
          tosql($fldnaam_uk, "Text") . "," . 
          tosql($fldurl, "Text") . "," . 
          tosql($fldomschrijving, "Text") . "," . 
          tosql($fldomschrijving_uk, "Memo") . 
          ")";
    break;
    case "update":

//-------------------------------
// links1 Update Event begin
// links1 Update Event end
//-------------------------------
        $sSQL = "update links set " .
          "naam=" . tosql($fldnaam, "Text") .
          ",naam_uk=" . tosql($fldnaam_uk, "Text") .
          ",url=" . tosql($fldurl, "Text") .
          ",omschrijving=" . tosql($fldomschrijving, "Text") .
          ",omschrijving_uk=" . tosql($fldomschrijving_uk, "Memo");
        $sSQL .= " where " . $sWhere;
    break;
    case "delete":
//-------------------------------
// links1 Delete Event begin
// links1 Delete Event end
//-------------------------------
        $sSQL = "delete from links where " . $sWhere;
    break;
  }
//-------------------------------
//-------------------------------
// links1 BeforeExecute Event begin
// links1 BeforeExecute Event end
//-------------------------------

//-------------------------------
// Execute SQL statement
//-------------------------------
  if(strlen($slinks1Err)) return;
  if($bExecSQL)
    $db->query($sSQL);
  header("Location: " . $sActionFileName);
  exit;
//-------------------------------
// links1 Action end
//-------------------------------
}

//===============================
// Display Record Form
//-------------------------------
function links1_show()
{
  global $db;
  global $tpl;
  global $sAction;
  global $sForm;
  global $slinks1Err;
  
  $fldlinks_id = "";
  $fldnaam = "";
  $fldnaam_uk = "";
  $fldurl = "";
  $fldomschrijving = "";
  $fldomschrijving_uk = "";
//-------------------------------
// links1 Show begin
//-------------------------------
  $sFormTitle = "Links aanpassen";
  $sWhere = "";
  $bPK = true;
//-------------------------------
// Load primary key and form parameters
//-------------------------------
  if($slinks1Err == "")
  {
    $fldlinks_id = get_param("links_id");
    $plinks_id = get_param("links_id");
    $tpl->set_var("links1Error", "");
  }
  else
  {
    $fldlinks_id = strip(get_param("links_id"));
    $fldnaam = strip(get_param("naam"));
    $fldnaam_uk = strip(get_param("naam_uk"));
    $fldurl = strip(get_param("url"));
    $fldomschrijving = strip(get_param("omschrijving"));
    $fldomschrijving_uk = strip(get_param("omschrijving_uk"));
    $plinks_id = get_param("PK_links_id");
    $tpl->set_var("slinks1Err", $slinks1Err);
    $tpl->set_var("FormTitle", $sFormTitle);
    $tpl->parse("links1Error", false);
  }
//-------------------------------

//-------------------------------
// Load all form fields

//-------------------------------

//-------------------------------
// Build WHERE statement
//-------------------------------
  
  if( !strlen($plinks_id)) $bPK = false;
  
  $sWhere .= "links_id=" . tosql($plinks_id, "Number");
  $tpl->set_var("PK_links_id", $plinks_id);
//-------------------------------
//-------------------------------
// links1 Open Event begin
// links1 Open Event end
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Build SQL statement and execute query
//-------------------------------
  $sSQL = "select * from links where " . $sWhere;
  // Execute SQL statement
  $db->query($sSQL);
  $bIsUpdateMode = ($bPK && !($sAction == "insert" && $sForm == "links1") && $db->next_record());
//-------------------------------

//-------------------------------
// Load all fields into variables from recordset or input parameters
//-------------------------------
  if($bIsUpdateMode)
  {
    $fldlinks_id = $db->f("links_id");
//-------------------------------
// Load data from recordset when form displayed first time
//-------------------------------
    if($slinks1Err == "") 
    {
      $fldnaam = $db->f("naam");
      $fldnaam_uk = $db->f("naam_uk");
      $fldurl = $db->f("url");
      $fldomschrijving = $db->f("omschrijving");
      $fldomschrijving_uk = $db->f("omschrijving_uk");
    }
    $tpl->set_var("links1Insert", "");
    $tpl->parse("links1Edit", false);
//-------------------------------
// links1 ShowEdit Event begin
// links1 ShowEdit Event end
//-------------------------------
  }
  else
  {
    if($slinks1Err == "")
    {
      $fldlinks_id = tohtml(get_param("links_id"));
      $fldurl= "http://";
    }
    $tpl->set_var("links1Edit", "");
    $tpl->parse("links1Insert", false);
//-------------------------------
// links1 ShowInsert Event begin
// links1 ShowInsert Event end
//-------------------------------
  }
  $tpl->parse("links1Cancel", false);
//-------------------------------
// links1 Show Event begin
// links1 Show Event end
//-------------------------------

//-------------------------------
// Show form field
//-------------------------------
    $tpl->set_var("links_id", tohtml($fldlinks_id));
    $tpl->set_var("naam", tohtml($fldnaam));
    $tpl->set_var("naam_uk", tohtml($fldnaam_uk));
    $tpl->set_var("url", tohtml($fldurl));
    $tpl->set_var("omschrijving", tohtml($fldomschrijving));
    $tpl->set_var("omschrijving_uk", tohtml($fldomschrijving_uk));
  $tpl->parse("Formlinks1", false);

//-------------------------------
// links1 Close Event begin
// links1 Close Event end
//-------------------------------

//-------------------------------
// links1 Show end
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
  $sFormTitle = "Links beheer";

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