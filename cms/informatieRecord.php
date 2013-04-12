<?php
/*********************************************************************************
 *       Filename: informatieRecord.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// informatieRecord CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// informatieRecord CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "informatieRecord.php";
$template_filename = "informatieRecord.html";
//===============================



//===============================
// informatieRecord PageSecurity begin
check_security(2);
// informatieRecord PageSecurity end
//===============================

//===============================
// informatieRecord Open Event begin
// informatieRecord Open Event end
//===============================

//===============================
// informatieRecord OpenAnyPage Event start
// informatieRecord OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// informatieRecord Show begin

//===============================
// Perform the form's action
//-------------------------------
// Initialize error variables
//-------------------------------
$sinformatie1Err = "";

//-------------------------------
// Select the FormAction
//-------------------------------
switch ($sForm) {
  case "informatie1":
    informatie1_action($sAction);
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
Header_show();Form_show();titel_show();Search_show();informatie_show();informatie1_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// informatieRecord Show end

//===============================
// informatieRecord Close Event begin
// informatieRecord Close Event end
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
  $sFormTitle = "Zoeken";
  $sActionFileName = "informatieRecord.php";
  $ss_categories_idDisplayValue = "";
  $ss_afgehandeldDisplayValue = "";

//-------------------------------
// Search Open Event begin
// Search Open Event end
//-------------------------------
  $tpl->set_var("FormTitle", $sFormTitle);
  $tpl->set_var("ActionPage", $sActionFileName);
//-------------------------------
// Set variables with search parameters
//-------------------------------
  $flds_bedrijf = strip(get_param("s_bedrijf"));
  $flds_woonplaats = strip(get_param("s_woonplaats"));
  $flds_categories_id = strip(get_param("s_categories_id"));
  $flds_afgehandeld = strip(get_param("s_afgehandeld"));

//-------------------------------
// Search Show begin
//-------------------------------


//-------------------------------
// Search Show Event begin
// Search Show Event end
//-------------------------------
    $tpl->set_var("s_bedrijf", tohtml($flds_bedrijf));
    $tpl->set_var("s_woonplaats", tohtml($flds_woonplaats));
    $tpl->set_var("SearchLBs_categories_id", "");
    $tpl->set_var("ID", "");
    $tpl->set_var("Value", $ss_categories_idDisplayValue);
    $tpl->set_var("Selected", "");
    $tpl->parse("SearchLBs_categories_id", true);
    $lookup_s_categories_id = db_fill_array("SELECT *  FROM `categories`  WHERE parent = 15");

    if(is_array($lookup_s_categories_id))
    {
      reset($lookup_s_categories_id);
      while(list($key, $value) = each($lookup_s_categories_id))
      {
        $tpl->set_var("ID", $key);
        $tpl->set_var("Value", $value);
        if($key == $flds_categories_id)
          $tpl->set_var("Selected", "SELECTED" );
        else 
          $tpl->set_var("Selected", "");
        $tpl->parse("SearchLBs_categories_id", true);
      }
    }
    
    $tpl->set_var("SearchLBs_afgehandeld", "");
    $tpl->set_var("ID", "");
    $tpl->set_var("Value", $ss_afgehandeldDisplayValue);
    $tpl->set_var("Selected", "");
    $tpl->parse("SearchLBs_afgehandeld", true);
    $LOV = split(";", "0;Nee;1;Ja");
  
    if(sizeof($LOV)%2 != 0) 
      $array_length = sizeof($LOV) - 1;
    else
      $array_length = sizeof($LOV);
    reset($LOV);
    for($i = 0; $i < $array_length; $i = $i + 2)
    {
      $tpl->set_var("ID", $LOV[$i]);
      $tpl->set_var("Value", $LOV[$i + 1]);
      if($LOV[$i] == $flds_afgehandeld) 
        $tpl->set_var("Selected", "SELECTED");
      else
        $tpl->set_var("Selected", "");
      $tpl->parse("SearchLBs_afgehandeld", true);
    }

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
function informatie_show()
{
//-------------------------------
// Initialize variables  
//-------------------------------
  
  global $tpl;
  global $db;
  global $sinformatieErr;
  $sWhere = "";
  $sOrder = "";
  $sSQL = "";
  $sFormTitle = "Informatie aanvraag overzicht";
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


  $tpl->set_var("TransitParams", "s_bedrijf=" . tourl(get_param("s_bedrijf")) . "&s_categories_id=" . tourl(get_param("s_categories_id")) . "&s_woonplaats=" . tourl(get_param("s_woonplaats")) . "&");
  $tpl->set_var("FormParams", "s_afgehandeld=" . tourl(get_param("s_afgehandeld")) . "&s_bedrijf=" . tourl(get_param("s_bedrijf")) . "&s_categories_id=" . tourl(get_param("s_categories_id")) . "&s_woonplaats=" . tourl(get_param("s_woonplaats")) . "&");
  
//-------------------------------
// Build WHERE statement
//-------------------------------
  $pcategories_id = get_session("categories_id");
  if(is_number($pcategories_id) && strlen($pcategories_id))
    $pcategories_id = tosql($pcategories_id, "Number");
  else 
    $pcategories_id = "";

  if(strlen($pcategories_id))
  {
    $HasParam = true;
    $sWhere = $sWhere . "i.categories_id=" . $pcategories_id;
  }
  $ps_afgehandeld = get_param("s_afgehandeld");
  if(is_number($ps_afgehandeld) && strlen($ps_afgehandeld))
    $ps_afgehandeld = tosql($ps_afgehandeld, "Number");
  else 
    $ps_afgehandeld = "";

  if(strlen($ps_afgehandeld))
  {
    if($sWhere != "") 
      $sWhere .= " and ";
    $HasParam = true;
    $sWhere = $sWhere . "i.gelezen=" . $ps_afgehandeld;
  }
  $ps_bedrijf = get_param("s_bedrijf");

  if(strlen($ps_bedrijf))
  {
    if($sWhere != "") 
      $sWhere .= " and ";
    $HasParam = true;
    $sWhere = $sWhere . "i.bedrijf like " . tosql("%".$ps_bedrijf ."%", "Text");
  }
  $ps_categories_id = get_param("s_categories_id");
  if(is_number($ps_categories_id) && strlen($ps_categories_id))
    $ps_categories_id = tosql($ps_categories_id, "Number");
  else 
    $ps_categories_id = "";

  if(strlen($ps_categories_id))
  {
    if($sWhere != "") 
      $sWhere .= " and ";
    $HasParam = true;
    $sWhere = $sWhere . "i.categories_id=" . $ps_categories_id;
  }
  $ps_woonplaats = get_param("s_woonplaats");

  if(strlen($ps_woonplaats))
  {
    if($sWhere != "") 
      $sWhere .= " and ";
    $HasParam = true;
    $sWhere = $sWhere . "i.woonplaats like " . tosql("%".$ps_woonplaats ."%", "Text");
  }


  if($HasParam)
    $sWhere = " AND (" . $sWhere . ")";

//-------------------------------
// Build ORDER BY statement
//-------------------------------
  $sOrder = " order by i.datum Desc";
  $iSort = get_param("Forminformatie_Sorting");
  $iSorted = get_param("Forminformatie_Sorted");
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
      $sSortParams = "Forminformatie_Sorting=" . $iSort . "&Forminformatie_Sorted=" . $iSort . "&";
    }
    else
    {
      $tpl->set_var("Form_Sorting", $iSort);
      $sDirection = " ASC";
      $sSortParams = "Forminformatie_Sorting=" . $iSort . "&Forminformatie_Sorted=" . "&";
    }
    if ($iSort == 1) $sOrder = " order by i.bedrijf" . $sDirection;
    if ($iSort == 2) $sOrder = " order by c.naam" . $sDirection;
    if ($iSort == 3) $sOrder = " order by i.gelezen" . $sDirection;
    if ($iSort == 4) $sOrder = " order by i.datum" . $sDirection;
  }

//-------------------------------
// Build base SQL statement
//-------------------------------
  $sSQL = "select i.bedrijf as i_bedrijf, " . 
    "i.categories_id as i_categories_id, " . 
    "i.datum as i_datum, " . 
    "i.gelezen as i_gelezen, " . 
    "i.informatie_id as i_informatie_id, " . 
    "i.woonplaats as i_woonplaats, " . 
    "c.categories_id as c_categories_id, " . 
    "c.naam as c_naam " . 
    " from informatie i, categories c" . 
    " where c.categories_id=i.categories_id  ";
//-------------------------------

//-------------------------------
// informatie Open Event begin
// informatie Open Event end
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
    $tpl->set_var("DListinformatie", "");
    $tpl->parse("informatieNoRecords", false);
    $tpl->set_var("informatieNavigator", "");
    $tpl->parse("Forminformatie", false);
    return;
  }
//-------------------------------

//-------------------------------
// Prepare the lists of values
//-------------------------------
  
  $agelezen = split(";", "0;Nee;1;Ja");
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
  $iPage = get_param("Forminformatie_Page");
  if(!strlen($iPage))
    $iPage = 1;
  else
  {
    if($iPage == "last")
    {
      $db_count = get_db_value($sCountSQL);
      $dResult = intval($db_count) / $iRecordsPerPage;
      $iPage = intval($dResult);
      if($iPage < $dResult) $iPage++;
    }
    else
      $iPage = intval($iPage);
    
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
    $fldedit_URLLink = "informatieRecord.php";
    $fldedit_informatie_id = $db->f("i_informatie_id");
    $fldbedrijf = $db->f("i_bedrijf");
    $fldcategories_id = $db->f("c_naam");
    $flddatum = $db->f("i_datum");
    $fldgelezen = $db->f("i_gelezen");
    $fldinformatie_id = $db->f("i_informatie_id");
    $next_record = $db->next_record();
    
//-------------------------------
// informatie Show begin
//-------------------------------

//-------------------------------
// informatie Show Event begin
$fldedit="<img border=0 src=files/ed.gif alt=Aanpassen>";
// informatie Show Event end
//-------------------------------

//-------------------------------
// Replace Template fields with database values
//-------------------------------
    
    $tpl->set_var("informatie_id", tohtml($fldinformatie_id));
      $tpl->set_var("bedrijf", tohtml($fldbedrijf));
      $tpl->set_var("categories_id", tohtml($fldcategories_id));
      $fldgelezen = get_lov_value($fldgelezen, $agelezen);
      $tpl->set_var("gelezen", tohtml($fldgelezen));
      $tpl->set_var("datum", tohtml($flddatum));
      $tpl->set_var("edit", $fldedit);
      $tpl->set_var("edit_URLLink", $fldedit_URLLink);
      $tpl->set_var("Prmedit_informatie_id", urlencode($fldedit_informatie_id));
    $tpl->parse("DListinformatie", true);
//-------------------------------
// informatie Show end
//-------------------------------

//-------------------------------
// Move to the next record and increase record counter
//-------------------------------
    
    $iCounter++;
  }

  // informatie Navigation begin
  $bEof = $next_record;
  // Parse Navigator
  if(!$bEof && $iPage == 1)
    $tpl->set_var("informatieNavigator", "");
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
      $tpl->parse( "informatieNavigatorPages", true);
      $iDisplayPages++;
    }
    $tpl->set_var( "NavigatorPageSwitch", "_");
    $tpl->set_var( "NavigatorPageNumber", $iPage);
    $tpl->set_var( "NavigatorPageNumberView", $iPage);
    $tpl->parse( "informatieNavigatorPages", true);
    $iDisplayPages++;
    $tpl->set_var( "NavigatorPageSwitch", "");
    $iPageCount = $iPage + 1;
    while ($iDisplayPages < $iNumberOfPages && $iStartPage + $iDisplayPages < $iHasPages)
    {
      $tpl->set_var( "NavigatorPageNumber", $iPageCount);
      $tpl->set_var( "NavigatorPageNumberView", $iPageCount);
      $tpl->parse( "informatieNavigatorPages", true);
      $iDisplayPages++;
      $iPageCount++;
    }
    if(!$bEof)
      $tpl->set_var("informatieNavigatorLastPage", "_");
    else
      $tpl->set_var("NextPage", ($iPage + 1));
    if($iPage == 1)
      $tpl->set_var("informatieNavigatorFirstPage", "_");
    else
      $tpl->set_var("PrevPage", ($iPage - 1));
    $tpl->set_var("informatieCurrentPage", $iPage);
    $tpl->parse( "informatieNavigator", false);
  }

//-------------------------------
// informatie Navigation end
//-------------------------------

//-------------------------------
// Finish form processing
//-------------------------------
  $tpl->set_var( "informatieNoRecords", "");
  $tpl->parse( "Forminformatie", false);
//-------------------------------
// informatie Close Event begin
// informatie Close Event end
//-------------------------------
}
//===============================


//===============================
// Action of the Record Form
//-------------------------------
function informatie1_action($sAction)
{
//-------------------------------
// Initialize variables  
//-------------------------------
  global $db;
  global $tpl;
  global $sForm;
  global $sinformatie1Err;
  $bExecSQL = true;
  $sActionFileName = "";
  $sWhere = "";
  $bErr = false;
  $pPKinformatie_id = "";
  $fldgelezen = "";
//-------------------------------

//-------------------------------
// informatie1 Action begin
//-------------------------------
  $sActionFileName = "informatieRecord.php";

//-------------------------------
// CANCEL action
//-------------------------------
  if($sAction == "cancel")
  {

//-------------------------------
// informatie1 BeforeCancel Event begin
// informatie1 BeforeCancel Event end
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
    $pPKinformatie_id = get_param("PK_informatie_id");
    if( !strlen($pPKinformatie_id)) return;
    $sWhere = "informatie_id=" . tosql($pPKinformatie_id, "Number");
  }
//-------------------------------


//-------------------------------
// Load all form fields into variables
//-------------------------------
  $fldinformatie_id = get_param("Rqd_informatie_id");
  $fldgelezen = get_checkbox_value(get_param("gelezen"), "1", "0", "Number");

//-------------------------------
// Validate fields
//-------------------------------
  if($sAction == "insert" || $sAction == "update") 
  {
//-------------------------------
// informatie1 Check Event begin
// informatie1 Check Event end
//-------------------------------
    if(strlen($sinformatie1Err)) return;
  }
//-------------------------------


//-------------------------------
// Create SQL statement
//-------------------------------
  switch(strtolower($sAction)) 
  {
    case "update":

//-------------------------------
// informatie1 Update Event begin
// informatie1 Update Event end
//-------------------------------
        $sSQL = "update informatie set " .
          "gelezen=" . $fldgelezen;
        $sSQL .= " where " . $sWhere;
    break;
    case "delete":
//-------------------------------
// informatie1 Delete Event begin
// informatie1 Delete Event end
//-------------------------------
        $sSQL = "delete from informatie where " . $sWhere;
    break;
  }
//-------------------------------
//-------------------------------
// informatie1 BeforeExecute Event begin
// informatie1 BeforeExecute Event end
//-------------------------------

//-------------------------------
// Execute SQL statement
//-------------------------------
  if(strlen($sinformatie1Err)) return;
  if($bExecSQL)
    $db->query($sSQL);
  header("Location: " . $sActionFileName);
  exit;
//-------------------------------
// informatie1 Action end
//-------------------------------
}

//===============================
// Display Record Form
//-------------------------------
function informatie1_show()
{
  global $db;
  global $tpl;
  global $sAction;
  global $sForm;
  global $sinformatie1Err;
  
  $fldinformatie_id = "";
  $fldbedrijf = "";
  $fldcontactpersoon = "";
  $fldadres = "";
  $fldpostcode = "";
  $fldwoonplaats = "";
  $fldland = "";
  $fldtelefoon = "";
  $fldfax = "";
  $fldemail = "";
  $fldurl = "";
  $flddatum = "";
  $fldcategories_id = "";
  $fldfolder_id = "";
  $fldmemo = "";
  $fldgelezen = "";
//-------------------------------
// informatie1 Show begin
//-------------------------------
  $sFormTitle = "Informatie aanvraag: {bedrijf}";
  $sWhere = "";
  $bPK = true;
//-------------------------------
// Load primary key and form parameters
//-------------------------------
  if($sinformatie1Err == "")
  {
    $fldinformatie_id = get_param("informatie_id");
    $tpl->set_var("Rqd_informatie_id", get_param("informatie_id"));
    $pinformatie_id = get_param("informatie_id");
    $tpl->set_var("informatie1Error", "");
  }
  else
  {
    $fldinformatie_id = strip(get_param("informatie_id"));
    $fldgelezen = get_checkbox_value(get_param("gelezen"), "1", "0", "Number");
    $pinformatie_id = get_param("PK_informatie_id");
    $tpl->set_var("sinformatie1Err", $sinformatie1Err);
    $tpl->set_var("FormTitle", $sFormTitle);
    $tpl->parse("informatie1Error", false);
  }
//-------------------------------

//-------------------------------
// Load all form fields

//-------------------------------

//-------------------------------
// Build WHERE statement
//-------------------------------
  
  if( !strlen($pinformatie_id)) $bPK = false;
  
  $sWhere .= "informatie_id=" . tosql($pinformatie_id, "Number");
  $tpl->set_var("PK_informatie_id", $pinformatie_id);
//-------------------------------
//-------------------------------
// informatie1 Open Event begin
// informatie1 Open Event end
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Build SQL statement and execute query
//-------------------------------
  $sSQL = "select * from informatie where " . $sWhere;
  // Execute SQL statement
  $db->query($sSQL);
  $bIsUpdateMode = ($bPK && !($sAction == "insert" && $sForm == "informatie1") && $db->next_record());
//-------------------------------

//-------------------------------
// Load all fields into variables from recordset or input parameters
//-------------------------------
  if($bIsUpdateMode)
  {
    $fldadres = $db->f("adres");
    $fldbedrijf = $db->f("bedrijf");
    $fldcategories_id = $db->f("categories_id");
    $fldcontactpersoon = $db->f("contactpersoon");
    $flddatum = $db->f("datum");
    $fldemail = $db->f("email");
    $fldfax = $db->f("fax");
    $fldfolder_id = $db->f("folder_id");
    $fldinformatie_id = $db->f("informatie_id");
    $fldland = $db->f("land");
    $fldmemo = $db->f("memo");
    $fldpostcode = $db->f("postcode");
    $fldtelefoon = $db->f("telefoon");
    $fldurl = $db->f("url");
    $fldwoonplaats = $db->f("woonplaats");
//-------------------------------
// Load data from recordset when form displayed first time
//-------------------------------
    if($sinformatie1Err == "") 
    {
      $fldgelezen = $db->f("gelezen");
    }
    $tpl->set_var("informatie1Insert", "");
    $tpl->parse("informatie1Edit", false);
//-------------------------------
// informatie1 ShowEdit Event begin
// informatie1 ShowEdit Event end
//-------------------------------
  }
  else
  {
    if($sinformatie1Err == "")
    {
      $fldinformatie_id = tohtml(get_param("informatie_id"));
    }
    $tpl->set_var("informatie1Edit", "");
    $tpl->set_var("informatie1Insert", "");
//-------------------------------
// informatie1 ShowInsert Event begin
// informatie1 ShowInsert Event end
//-------------------------------
  }
  $tpl->parse("informatie1Cancel", false);
//-------------------------------
// Set lookup fields
//-------------------------------
  $fldcategories_id = get_db_value("SELECT naam FROM categories WHERE categories_id=" . tosql($fldcategories_id, "Number"));
  $fldfolder_id = get_db_value("SELECT foldernaam FROM folders WHERE folder_id=" . tosql($fldfolder_id, "Text"));
//-------------------------------
// informatie1 Show Event begin
// informatie1 Show Event end
//-------------------------------

//-------------------------------
// Show form field
//-------------------------------
    $tpl->set_var("informatie_id", tohtml($fldinformatie_id));
      $tpl->set_var("bedrijf", tohtml($fldbedrijf));
      $tpl->set_var("contactpersoon", tohtml($fldcontactpersoon));
      $tpl->set_var("adres", tohtml($fldadres));
      $tpl->set_var("postcode", tohtml($fldpostcode));
      $tpl->set_var("woonplaats", tohtml($fldwoonplaats));
      $tpl->set_var("land", tohtml($fldland));
      $tpl->set_var("telefoon", tohtml($fldtelefoon));
      $tpl->set_var("fax", tohtml($fldfax));
      $tpl->set_var("email", tohtml($fldemail));
      $tpl->set_var("url", tohtml($fldurl));
      $tpl->set_var("datum", tohtml($flddatum));
      $tpl->set_var("categories_id", tohtml($fldcategories_id));
      $tpl->set_var("folder_id", tohtml($fldfolder_id));
      $tpl->set_var("memo", tohtml($fldmemo));
      if(strtolower($fldgelezen) == strtolower("1")) 
        $tpl->set_var("gelezen_CHECKED", "CHECKED");
      else
        $tpl->set_var("gelezen_CHECKED", "");

  $tpl->parse("Forminformatie1", false);

//-------------------------------
// informatie1 Close Event begin
// informatie1 Close Event end
//-------------------------------

//-------------------------------
// informatie1 Show end
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
  $sFormTitle = "Informatie aanvraag beheer";

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