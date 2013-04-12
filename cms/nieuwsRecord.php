<?php
/*********************************************************************************
 *       Filename: nieuwsRecord.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// nieuwsRecord CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// nieuwsRecord CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "nieuwsRecord.php";
$template_filename = "nieuwsRecord.html";
//===============================



//===============================
// nieuwsRecord PageSecurity begin
check_security(3);
// nieuwsRecord PageSecurity end
//===============================

//===============================
// nieuwsRecord Open Event begin
// nieuwsRecord Open Event end
//===============================

//===============================
// nieuwsRecord OpenAnyPage Event start
// nieuwsRecord OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// nieuwsRecord Show begin

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
Header_show();Form_show();titel_show();Search_show();nieuws_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// nieuwsRecord Show end

//===============================
// nieuwsRecord Close Event begin
// nieuwsRecord Close Event end
//===============================
//********************************************************************************


//===============================
// Display Search Form
//-------------------------------
function Search_show()
{
  global $db;
  global $tpl;
  global $sForm;
  $sFormTitle = "Zoek nieuwsbericht";
  $sActionFileName = "nieuwsRecord.php";

//-------------------------------
// Search Open Event begin
// Search Open Event end
//-------------------------------
  $tpl->set_var("FormTitle", $sFormTitle);
  $tpl->set_var("ActionPage", $sActionFileName);
//-------------------------------
// Set variables with search parameters
//-------------------------------
  $flds_titel = strip(get_param("s_titel"));
  $flds_datum = strip(get_param("s_datum"));

//-------------------------------
// Search Show begin
//-------------------------------


//-------------------------------
// Search Show Event begin
// Search Show Event end
//-------------------------------
    $tpl->set_var("s_titel", tohtml($flds_titel));
    $tpl->set_var("s_datum", tohtml($flds_datum));

//-------------------------------
// Search Show end
//-------------------------------

//-------------------------------
// Search Close Event begin
// Search Close Event end
//-------------------------------
  $tpl->parse("FormSearch", false);
//===============================
}


//===============================
// Display Grid Form
//-------------------------------
function nieuws_show()
{
//-------------------------------
// Initialize variables  
//-------------------------------
  
  global $tpl;
  global $db;
  global $snieuwsErr;
  $sWhere = "";
  $sOrder = "";
  $sSQL = "";
  $sFormTitle = "Nieuwsoverzicht";
  $HasParam = false;
  $iRecordsPerPage = 10;
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
  $sActionFileName = "nieuwsRecord2.php";


  $tpl->set_var("TransitParams", "s_categories_id=" . tourl(get_param("s_categories_id")) . "&s_datum=" . tourl(get_param("s_datum")) . "&s_titel=" . tourl(get_param("s_titel")) . "&");
  $tpl->set_var("FormParams", "s_categories_id=" . tourl(get_param("s_categories_id")) . "&s_datum=" . tourl(get_param("s_datum")) . "&s_titel=" . tourl(get_param("s_titel")) . "&");
  
//-------------------------------
// Build WHERE statement
//-------------------------------
  $ps_categories_id = get_param("s_categories_id");
  if(is_number($ps_categories_id) && strlen($ps_categories_id))
    $ps_categories_id = tosql($ps_categories_id, "Number");
  else 
    $ps_categories_id = "";

  if(strlen($ps_categories_id))
  {
    $HasParam = true;
    $sWhere = $sWhere . "n.categories_id=" . $ps_categories_id;
  }
  $ps_datum = get_param("s_datum");

  if(strlen($ps_datum))
  {
    if($sWhere != "") 
      $sWhere .= " and ";
    $HasParam = true;
    $sWhere = $sWhere . "n.datum like " . tosql("%".$ps_datum ."%", "Text");
  }
  $ps_titel = get_param("s_titel");

  if(strlen($ps_titel))
  {
    if($sWhere != "") 
      $sWhere .= " and ";
    $HasParam = true;
    $sWhere = $sWhere . "n.titel like " . tosql("%".$ps_titel ."%", "Text");
  }


  if($HasParam)
    $sWhere = " AND (" . $sWhere . ")";

//-------------------------------
// Build ORDER BY statement
//-------------------------------
  $sOrder = " order by n.datum Desc";
  $iSort = get_param("Formnieuws_Sorting");
  $iSorted = get_param("Formnieuws_Sorted");
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
      $sSortParams = "Formnieuws_Sorting=" . $iSort . "&Formnieuws_Sorted=" . $iSort . "&";
    }
    else
    {
      $tpl->set_var("Form_Sorting", $iSort);
      $sDirection = " ASC";
      $sSortParams = "Formnieuws_Sorting=" . $iSort . "&Formnieuws_Sorted=" . "&";
    }
    if ($iSort == 1) $sOrder = " order by n.titel" . $sDirection;
    if ($iSort == 2) $sOrder = " order by n.titel_uk" . $sDirection;
    if ($iSort == 3) $sOrder = " order by n.datum" . $sDirection;
    if ($iSort == 4) $sOrder = " order by c.naam" . $sDirection;
  }

//-------------------------------
// Build base SQL statement
//-------------------------------
  $sSQL = "select n.categories_id as n_categories_id, " . 
    "n.datum as n_datum, " . 
    "n.nieuws_id as n_nieuws_id, " . 
    "n.titel as n_titel, " . 
    "n.titel_uk as n_titel_uk, " . 
    "c.categories_id as c_categories_id, " . 
    "c.naam as c_naam " . 
    " from nieuws n, categories c" . 
    " where c.categories_id=n.categories_id  ";
//-------------------------------

//-------------------------------
// nieuws Open Event begin
// nieuws Open Event end
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
    $iTmpI = strpos(strtolower($sCountSQL), "order by");
    if($iTmpI > 1) 
      $sCountSQL = substr($sCountSQL, 0, $iTmpI - 1);
  }
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
    $tpl->set_var("DListnieuws", "");
    $tpl->parse("nieuwsNoRecords", false);
    $tpl->set_var("nieuwsNavigator", "");
    $tpl->parse("Formnieuws", false);
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
  $iPage = get_param("Formnieuws_Page");
  $db_count = get_db_value($sCountSQL);
  $dResult = intval($db_count) / $iRecordsPerPage;
  $iPageCount = intval($dResult);
  if($iPageCount < $dResult) $iPageCount = $iPageCount + 1;
  $tpl->set_var("nieuwsPageCount", $iPageCount);
  if(!strlen($iPage))
    $iPage = 1;
  else
  {
    if($iPage == "last") $iPage = $iPageCount;
  }

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
    $fldedit_URLLink = "nieuwsRecord2.php";
    $fldedit_nieuws_id = $db->f("n_nieuws_id");
    $fldcategories_id = $db->f("c_naam");
    $flddatum = $db->f("n_datum");
    $fldnieuws_id = $db->f("n_nieuws_id");
    $fldtitel = $db->f("n_titel");
    $fldtitel_uk = $db->f("n_titel_uk");
    $next_record = $db->next_record();
    
//-------------------------------
// nieuws Show begin
//-------------------------------

//-------------------------------
// nieuws Show Event begin
$fldedit="<img border=0 src=files/ed.gif alt=Bekijk>";
// nieuws Show Event end
//-------------------------------

//-------------------------------
// Replace Template fields with database values
//-------------------------------
    
    $tpl->set_var("nieuws_id", tohtml($fldnieuws_id));
      $tpl->set_var("titel", tohtml($fldtitel));
      $tpl->set_var("titel_uk", tohtml($fldtitel_uk));
      $tpl->set_var("datum", tohtml($flddatum));
      $tpl->set_var("categories_id", tohtml($fldcategories_id));
      $tpl->set_var("edit", $fldedit);
      $tpl->set_var("edit_URLLink", $fldedit_URLLink);
      $tpl->set_var("Prmedit_nieuws_id", urlencode($fldedit_nieuws_id));
    $tpl->parse("DListnieuws", true);
//-------------------------------
// nieuws Show end
//-------------------------------

//-------------------------------
// Move to the next record and increase record counter
//-------------------------------
    
    $iCounter++;
  }

  // nieuws Navigation begin
  $bEof = $next_record;
  // Parse Navigator
  if(!$bEof && $iPage == 1)
    $tpl->set_var("nieuwsNavigator", "");
  else 
  {
    $iCounter = 1;
    $iHasPages = $iPage;
    $iDisplayPages = 0;
    $iNumberOfPages = 10;
    $iHasPages = $iPageCount;
    if (($iHasPages - $iPage) < intval($iNumberOfPages / 2))
      $iStartPage = $iHasPages - $iNumberOfPages;
    else
      $iStartPage = $iPage - $iNumberOfPages + intval($iNumberOfPages / 2);
    
    if($iStartPage < 0) $iStartPage = 0;
    for($iPageCount = $iStartPage + 1;  $iPageCount <= $iPage - 1; $iPageCount++)
    {
      $tpl->set_var( "NavigatorPageNumber", $iPageCount);
      $tpl->set_var( "NavigatorPageNumberView", $iPageCount);
      $tpl->parse( "nieuwsNavigatorPages", true);
      $iDisplayPages++;
    }
    $tpl->set_var( "NavigatorPageSwitch", "_");
    $tpl->set_var( "NavigatorPageNumber", $iPage);
    $tpl->set_var( "NavigatorPageNumberView", $iPage);
    $tpl->parse( "nieuwsNavigatorPages", true);
    $iDisplayPages++;
    $tpl->set_var( "NavigatorPageSwitch", "");
    $iPageCount = $iPage + 1;
    while ($iDisplayPages < $iNumberOfPages && $iStartPage + $iDisplayPages < $iHasPages)
    {
      $tpl->set_var( "NavigatorPageNumber", $iPageCount);
      $tpl->set_var( "NavigatorPageNumberView", $iPageCount);
      $tpl->parse( "nieuwsNavigatorPages", true);
      $iDisplayPages++;
      $iPageCount++;
    }
    if(!$bEof)
      $tpl->set_var("nieuwsNavigatorLastPage", "_");
    else
      $tpl->set_var("NextPage", ($iPage + 1));
    if($iPage == 1)
      $tpl->set_var("nieuwsNavigatorFirstPage", "_");
    else
      $tpl->set_var("PrevPage", ($iPage - 1));
    $tpl->set_var("nieuwsCurrentPage", $iPage);
    $tpl->parse( "nieuwsNavigator", false);
  }

//-------------------------------
// nieuws Navigation end
//-------------------------------

//-------------------------------
// Finish form processing
//-------------------------------
  $tpl->set_var( "nieuwsNoRecords", "");
  $tpl->parse( "Formnieuws", false);
//-------------------------------
// nieuws Close Event begin
// nieuws Close Event end
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
  $sFormTitle = "Nieuws beheer";

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