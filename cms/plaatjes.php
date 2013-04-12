<?php
/*********************************************************************************
 *       Filename: plaatjes.php
 *       Generated with CodeCharge 2.0.3
 *       PHP 4.0 & Templates build 10/09/2001
 *********************************************************************************/

//-------------------------------
// plaatjes CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// plaatjes CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "plaatjes.php";
$template_filename = "plaatjes.html";
//===============================



//===============================
// plaatjes PageSecurity begin
// plaatjes PageSecurity end
//===============================

//===============================
// plaatjes Open Event begin
// plaatjes Open Event end
//===============================

//===============================
// plaatjes OpenAnyPage Event start
// plaatjes OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// plaatjes Show begin

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
Header_show();Form_show();titel_show();plaatjes_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// plaatjes Show end

//===============================
// plaatjes Close Event begin
// plaatjes Close Event end
//===============================
//********************************************************************************


//===============================
// Display Grid Form
//-------------------------------
function plaatjes_show()
{
//-------------------------------
// Initialize variables  
//-------------------------------
  
  global $tpl;
  global $db;
  global $splaatjesErr;
  $sWhere = "";
  $sOrder = "";
  $sSQL = "";
  $sFormTitle = "Plaatjes overzicht";
  $HasParam = false;
  $iRecordsPerPage = 20;
  $iCounter = 0;
  $iPage = 0;
  $bEof = false;
  $iSort = "";
  $iSorted = "";
  $sDirection = "";
  $sSortParams = "";
  $iTmpI = 0;
  $iTmpJ = 0;
  $sCountSQL = "";

  $tpl->set_var("TransitParams", "");
  $tpl->set_var("FormParams", "");


  $sWhere = " WHERE description=1";

//-------------------------------
// Build ORDER BY statement
//-------------------------------
  $sOrder = " order by i.name Asc";
  $iSort = get_param("Formplaatjes_Sorting");
  $iSorted = get_param("Formplaatjes_Sorted");
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
      $sSortParams = "Formplaatjes_Sorting=" . $iSort . "&Formplaatjes_Sorted=" . $iSort . "&";
    }
    else
    {
      $tpl->set_var("Form_Sorting", $iSort);
      $sDirection = " ASC";
      $sSortParams = "Formplaatjes_Sorting=" . $iSort . "&Formplaatjes_Sorted=" . "&";
    }
    if ($iSort == 1) $sOrder = " order by i.name" . $sDirection;
    if ($iSort == 2) $sOrder = " order by i.location" . $sDirection;
  }

//-------------------------------
// Build base SQL statement
//-------------------------------
  $sSQL = "select i.description as i_description, " . 
    "i.item_id as i_item_id, " . 
    "i.location as i_location, " . 
    "i.name as i_name " . 
    " from items i ";
//-------------------------------

//-------------------------------
// plaatjes Open Event begin
// plaatjes Open Event end
//-------------------------------

//-------------------------------
// Assemble full SQL statement
//-------------------------------
  $sSQL .= $sWhere . $sOrder;
  if($sCountSQL == "")
  {
    $iTmpI = strpos(strtolower($sSQL), "select");
    $iTmpJ = strpos(strtolower($sSQL), "from") - 1;
    $sCountSQL = str_replace(substr($sSQL, $iTmpI + 6, $iTmpJ - $iTmpI - 6), " count(*) ", $sSQL);
    $iTmpI = strpos(strtolower($sCountSQl), "order by");
    if($iTmpI > 1) 
      $sCountSQL = substr($sCountSQL, 0, $iTmpI - 1);
  }
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

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
    $tpl->set_var("DListplaatjes", "");
    $tpl->parse("plaatjesNoRecords", false);
    $tpl->set_var("plaatjesNavigator", "");
    $tpl->parse("Formplaatjes", false);
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
  $iPage = get_param("Formplaatjes_Page");
  if(!strlen($iPage)) $iPage = 1; else $iPage = intval($iPage);
  $db_count = get_db_value($sCountSQL);
  $dResult = intval($db_count) / $iRecordsPerPage;
  $iPageCount = intval($dResult);
  if($iPageCount < $dResult) $iPageCount = $iPageCount + 1;
  $tpl->set_var("plaatjesPageCount", $iPageCount);

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
    $flddescription = $db->f("i_description");
    $flditem_id = $db->f("i_item_id");
    $fldlocation = $db->f("i_location");
    $fldname = $db->f("i_name");
    $next_record = $db->next_record();
    
//-------------------------------
// plaatjes Show begin
//-------------------------------

//-------------------------------
// plaatjes Show Event begin
$fldplaatje="<img border=0 src=upload/$fldlocation alt=Aanpassen>";
// plaatjes Show Event end
//-------------------------------

//-------------------------------
// Replace Template fields with database values
//-------------------------------
    
    $tpl->set_var("item_id", tohtml($flditem_id));
    $tpl->set_var("description", tohtml($flddescription));
      $tpl->set_var("name", tohtml($fldname));
      $tpl->set_var("location", tohtml($fldlocation));
      $tpl->set_var("plaatje", $fldplaatje);
    $tpl->parse("DListplaatjes", true);
//-------------------------------
// plaatjes Show end
//-------------------------------

//-------------------------------
// Move to the next record and increase record counter
//-------------------------------
    
    $iCounter++;
  }

  // plaatjes Navigation begin
  $bEof = $next_record;
  // Parse Navigator
  if(!$bEof && $iPage == 1)
    $tpl->set_var("plaatjesNavigator", "");
  else 
  {
    if(!$bEof)
      $tpl->set_var("plaatjesNavigatorLastPage", "_");
    else
      $tpl->set_var("NextPage", ($iPage + 1));
    if($iPage == 1)
      $tpl->set_var("plaatjesNavigatorFirstPage", "_");
    else
      $tpl->set_var("PrevPage", ($iPage - 1));
    $tpl->set_var("plaatjesCurrentPage", $iPage);
    $tpl->parse( "plaatjesNavigator", false);
  }

//-------------------------------
// plaatjes Navigation end
//-------------------------------

//-------------------------------
// Finish form processing
//-------------------------------
  $tpl->set_var( "plaatjesNoRecords", "");
  $tpl->parse( "Formplaatjes", false);
//-------------------------------
// plaatjes Close Event begin
// plaatjes Close Event end
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
  $sFormTitle = "Pagina overzicht";

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