<?php
/*********************************************************************************
 *       Filename: Productgroepen.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// Productgroepen CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// Productgroepen CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "Productgroepen.php";
$template_filename = "Productgroepen.html";
//===============================



//===============================
// Productgroepen PageSecurity begin
check_security(3);
// Productgroepen PageSecurity end
//===============================

//===============================
// Productgroepen Open Event begin
// Productgroepen Open Event end
//===============================

//===============================
// Productgroepen OpenAnyPage Event start
// Productgroepen OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// Productgroepen Show begin

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
Header_show();Form_show();titel_show();zoeken_show();Zoekresultaten_show();variabele_show();groepen_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// Productgroepen Show end

//===============================
// Productgroepen Close Event begin
// Productgroepen Close Event end
//===============================
//********************************************************************************


//===============================
// Display Search Form
//-------------------------------
function zoeken_show()
{
  global $db;
  global $tpl;
  global $sForm;
  $sFormTitle = "Zoek een klant";
  $sActionFileName = "Productgroepen.php";

//-------------------------------
// zoeken Open Event begin
// zoeken Open Event end
//-------------------------------
  $tpl->set_var("FormTitle", $sFormTitle);
  $tpl->set_var("ActionPage", $sActionFileName);
//-------------------------------
// Set variables with search parameters
//-------------------------------
  $flds_naam = strip(get_param("s_naam"));

//-------------------------------
// zoeken Show begin
//-------------------------------


//-------------------------------
// zoeken Show Event begin
// zoeken Show Event end
//-------------------------------
    $tpl->set_var("s_naam", tohtml($flds_naam));

//-------------------------------
// zoeken Show end
//-------------------------------

//-------------------------------
// zoeken Close Event begin
// zoeken Close Event end
//-------------------------------
  $tpl->parse("Formzoeken", false);
//===============================
}


//===============================
// Display Grid Form
//-------------------------------
function Zoekresultaten_show()
{
//-------------------------------
// Initialize variables  
//-------------------------------
  
  global $tpl;
  global $db;
  global $sZoekresultatenErr;
  $sWhere = "";
  $sOrder = "";
  $sSQL = "";
  $sFormTitle = "Klant overzicht";
  $HasParam = false;
  $iRecordsPerPage = 20;
  $iCounter = 0;
  $iPage = 0;
  $bEof = false;
  $iSort = "";
  $iSorted = "";
  $sDirection = "";
  $sSortParams = "";


  $tpl->set_var("TransitParams", "s_login_id=" . tourl(get_param("s_login_id")) . "&s_naam=" . tourl(get_param("s_naam")) . "&");
  $tpl->set_var("FormParams", "s_login_id=" . tourl(get_param("s_login_id")) . "&s_naam=" . tourl(get_param("s_naam")) . "&");
  
//-------------------------------
// Build WHERE statement
//-------------------------------
  $ps_login_id = get_param("s_login_id");
  if(is_number($ps_login_id) && strlen($ps_login_id))
    $ps_login_id = tosql($ps_login_id, "Number");
  else 
    $ps_login_id = "";

  if(strlen($ps_login_id))
  {
    $HasParam = true;
    $sWhere = $sWhere . "l.login_id=" . $ps_login_id;
  }
  $ps_naam = get_param("s_naam");

  if(strlen($ps_naam))
  {
    if($sWhere != "") 
      $sWhere .= " and ";
    $HasParam = true;
    $sWhere = $sWhere . "l.naam like " . tosql("%".$ps_naam ."%", "Text");
  }


  if($HasParam)
    $sWhere = " WHERE (niveau=1) AND (" . $sWhere . ")";
  else
    $sWhere = " WHERE niveau=1";

//-------------------------------
// Build ORDER BY statement
//-------------------------------
  $sOrder = " order by l.naam Asc";
  $iSort = get_param("FormZoekresultaten_Sorting");
  $iSorted = get_param("FormZoekresultaten_Sorted");
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
      $sSortParams = "FormZoekresultaten_Sorting=" . $iSort . "&FormZoekresultaten_Sorted=" . $iSort . "&";
    }
    else
    {
      $tpl->set_var("Form_Sorting", $iSort);
      $sDirection = " ASC";
      $sSortParams = "FormZoekresultaten_Sorting=" . $iSort . "&FormZoekresultaten_Sorted=" . "&";
    }
    if ($iSort == 1) $sOrder = " order by l.naam" . $sDirection;
  }

//-------------------------------
// Build base SQL statement
//-------------------------------
  $sSQL = "select l.login_id as l_login_id, " . 
    "l.naam as l_naam " . 
    " from login l ";
//-------------------------------

//-------------------------------
// Zoekresultaten Open Event begin
// Zoekresultaten Open Event end
//-------------------------------

//-------------------------------
// Assemble full SQL statement
//-------------------------------
  $sSQL .= $sWhere . $sOrder;
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
    $tpl->set_var("DListZoekresultaten", "");
    $tpl->parse("ZoekresultatenNoRecords", false);
    $tpl->set_var("ZoekresultatenNavigator", "");
    $tpl->parse("FormZoekresultaten", false);
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
  $iPage = get_param("FormZoekresultaten_Page");
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
    $fldlogin_id = $db->f("l_login_id");
    $fldnaam_URLLink = "Productgroepen.php";
    $fldnaam_login_id = $db->f("l_login_id");
    $fldnaam = $db->f("l_naam");
    $next_record = $db->next_record();
    
//-------------------------------
// Zoekresultaten Show begin
//-------------------------------

//-------------------------------
// Zoekresultaten Show Event begin
// Zoekresultaten Show Event end
//-------------------------------

//-------------------------------
// Replace Template fields with database values
//-------------------------------
    
    $tpl->set_var("login_id", tohtml($fldlogin_id));
      $tpl->set_var("naam", tohtml($fldnaam));
      $tpl->set_var("naam_URLLink", $fldnaam_URLLink);
      $tpl->set_var("Prmnaam_login_id", urlencode($fldnaam_login_id));
    $tpl->parse("DListZoekresultaten", true);
//-------------------------------
// Zoekresultaten Show end
//-------------------------------

//-------------------------------
// Move to the next record and increase record counter
//-------------------------------
    
    $iCounter++;
  }

  // Zoekresultaten Navigation begin
  $bEof = $next_record;
  // Parse Navigator
  if(!$bEof && $iPage == 1)
    $tpl->set_var("ZoekresultatenNavigator", "");
  else 
  {
    if(!$bEof)
      $tpl->set_var("ZoekresultatenNavigatorLastPage", "_");
    else
      $tpl->set_var("NextPage", ($iPage + 1));
    if($iPage == 1)
      $tpl->set_var("ZoekresultatenNavigatorFirstPage", "_");
    else
      $tpl->set_var("PrevPage", ($iPage - 1));
    $tpl->set_var("ZoekresultatenCurrentPage", $iPage);
    $tpl->parse( "ZoekresultatenNavigator", false);
  }

//-------------------------------
// Zoekresultaten Navigation end
//-------------------------------

//-------------------------------
// Finish form processing
//-------------------------------
  $tpl->set_var( "ZoekresultatenNoRecords", "");
  $tpl->parse( "FormZoekresultaten", false);
//-------------------------------
// Zoekresultaten Close Event begin
// Zoekresultaten Close Event end
//-------------------------------
}
//===============================


//===============================
// Display Grid Form
//-------------------------------
function groepen_show()
{
//-------------------------------
// Initialize variables  
//-------------------------------
  
  global $tpl;
  global $db;
  global $sgroepenErr;
  $sWhere = "";
  $sOrder = "";
  $sSQL = "";
  $sFormTitle = "Productgroepen {naam}";
  $HasParam = false;
  $bReq = true;
  $iRecordsPerPage = 20;
  $iCounter = 0;
  $iPage = 0;
  $bEof = false;
  $sActionFileName = "Productgroepen2.php";


  $tpl->set_var("TransitParams", "login_id=" . tourl(get_param("login_id")) . "&");
  $tpl->set_var("FormParams", "login_id=" . tourl(get_param("login_id")) . "&productgroep_id=" . tourl(get_param("productgroep_id")) . "&");
  
//-------------------------------
// Build WHERE statement
//-------------------------------
  $plogin_id = get_param("login_id");
  if(is_number($plogin_id) && strlen($plogin_id))
    $plogin_id = tosql($plogin_id, "Number");
  else 
    $plogin_id = "";

  if(strlen($plogin_id))
  {
    $HasParam = true;
    $sWhere = $sWhere . "k.login_id=" . $plogin_id;
  }
  else
  {
    $bReq = false;
  }
  $pproductgroep_id = get_param("productgroep_id");
  if(is_number($pproductgroep_id) && strlen($pproductgroep_id))
    $pproductgroep_id = tosql($pproductgroep_id, "Number");
  else 
    $pproductgroep_id = "";

  if(strlen($pproductgroep_id))
  {
    if($sWhere != "") 
      $sWhere .= " and ";
    $HasParam = true;
    $sWhere = $sWhere . "k.productgroep_id=" . $pproductgroep_id;
  }


  if($HasParam)
    $sWhere = " AND (" . $sWhere . ")";

//-------------------------------
// Build base SQL statement
//-------------------------------
  $sSQL = "select k.klant_combi_id as k_klant_combi_id, " . 
    "k.login_id as k_login_id, " . 
    "k.productgroep_id as k_productgroep_id, " . 
    "p.productgroep_id as p_productgroep_id, " . 
    "p.naam as p_naam " . 
    " from klant_combi k, productgroep p" . 
    " where p.productgroep_id=k.productgroep_id  ";
//-------------------------------

//-------------------------------
// groepen Open Event begin
// groepen Open Event end
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
// Process if form has all required parameter
//-------------------------------
  if(!$bReq)
  {
    $tpl->set_var("DListgroepen", "");
    $tpl->parse("groepenNoRecords", false);
    $tpl->set_var("groepenNavigator", "");
    $tpl->parse("Formgroepen", false);
    return;
  }
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
    $tpl->set_var("DListgroepen", "");
    $tpl->parse("groepenNoRecords", false);
    $tpl->set_var("groepenNavigator", "");
    $tpl->parse("Formgroepen", false);
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
  $iPage = get_param("Formgroepen_Page");
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
    $fldverwijderen_URLLink = "Productgroepen2.php";
    $fldverwijderen_klant_combi_id = $db->f("k_klant_combi_id");
    $fldklant_combi_id = $db->f("k_klant_combi_id");
    $fldlogin_id = $db->f("k_login_id");
    $fldproductgroep_id = $db->f("p_naam");
    $fldverwijderen= "Verwijderen";
    $next_record = $db->next_record();
    
//-------------------------------
// groepen Show begin
//-------------------------------

//-------------------------------
// groepen Show Event begin
// groepen Show Event end
//-------------------------------

//-------------------------------
// Replace Template fields with database values
//-------------------------------
    
    $tpl->set_var("klant_combi_id", tohtml($fldklant_combi_id));
    $tpl->set_var("login_id", tohtml($fldlogin_id));
      $tpl->set_var("productgroep_id", tohtml($fldproductgroep_id));
      $tpl->set_var("verwijderen", tohtml($fldverwijderen));
      $tpl->set_var("verwijderen_URLLink", $fldverwijderen_URLLink);
      $tpl->set_var("Prmverwijderen_klant_combi_id", urlencode($fldverwijderen_klant_combi_id));
    $tpl->parse("DListgroepen", true);
//-------------------------------
// groepen Show end
//-------------------------------

//-------------------------------
// Move to the next record and increase record counter
//-------------------------------
    
    $iCounter++;
  }

  // groepen Navigation begin
  $bEof = $next_record;
  // Parse Navigator
  if(!$bEof && $iPage == 1)
    $tpl->set_var("groepenNavigator", "");
  else 
  {
    if(!$bEof)
      $tpl->set_var("groepenNavigatorLastPage", "_");
    else
      $tpl->set_var("NextPage", ($iPage + 1));
    if($iPage == 1)
      $tpl->set_var("groepenNavigatorFirstPage", "_");
    else
      $tpl->set_var("PrevPage", ($iPage - 1));
    $tpl->set_var("groepenCurrentPage", $iPage);
    $tpl->parse( "groepenNavigator", false);
  }

//-------------------------------
// groepen Navigation end
//-------------------------------

//-------------------------------
// Finish form processing
//-------------------------------
  $tpl->set_var( "groepenNoRecords", "");
  $tpl->parse( "Formgroepen", false);
//-------------------------------
// groepen Close Event begin
// groepen Close Event end
//-------------------------------
}
//===============================


//===============================
// Display Grid Form
//-------------------------------
function variabele_show()
{
//-------------------------------
// Initialize variables  
//-------------------------------
  
  global $tpl;
  global $db;
  global $svariabeleErr;
  $sWhere = "";
  $sOrder = "";
  $sSQL = "";
  $sFormTitle = "";
  $HasParam = false;
  $iRecordsPerPage = 20;
  $iCounter = 0;


  $tpl->set_var("TransitParams", "");
  $tpl->set_var("FormParams", "login_id=" . tourl(get_param("login_id")) . "&");
  
//-------------------------------
// Build WHERE statement
//-------------------------------
  $plogin_id = get_param("login_id");
  if(is_number($plogin_id) && strlen($plogin_id))
    $plogin_id = tosql($plogin_id, "Number");
  else 
    $plogin_id = "";

  if(strlen($plogin_id))
  {
    $HasParam = true;
    $sWhere = $sWhere . "l.login_id=" . $plogin_id;
  }


  if($HasParam)
    $sWhere = " WHERE (" . $sWhere . ")";

//-------------------------------
// Build base SQL statement
//-------------------------------
  $sSQL = "select l.login_id as l_login_id, " . 
    "l.naam as l_naam " . 
    " from login l ";
//-------------------------------

//-------------------------------
// variabele Open Event begin
// variabele Open Event end
//-------------------------------

//-------------------------------
// Assemble full SQL statement
//-------------------------------
  $sSQL .= $sWhere . $sOrder;
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

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
    $tpl->set_var("DListvariabele", "");
    $tpl->parse("variabeleNoRecords", false);
    $tpl->parse("Formvariabele", false);
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
// Display grid based on recordset
//-------------------------------
  while($next_record  && $iCounter < $iRecordsPerPage)
  {
//-------------------------------
// Create field variables based on database fields
//-------------------------------
    $fldlogin_id = $db->f("l_login_id");
    $fldnaam = $db->f("l_naam");
    $next_record = $db->next_record();
    
//-------------------------------
// variabele Show begin
//-------------------------------

//-------------------------------
// variabele Show Event begin
// variabele Show Event end
//-------------------------------

//-------------------------------
// Replace Template fields with database values
//-------------------------------
    
    $tpl->set_var("login_id", tohtml($fldlogin_id));
    $tpl->set_var("naam", tohtml($fldnaam));
    $tpl->parse("DListvariabele", true);
//-------------------------------
// variabele Show end
//-------------------------------

//-------------------------------
// Move to the next record and increase record counter
//-------------------------------
    
    $iCounter++;
  }


//-------------------------------
// Finish form processing
//-------------------------------
  $tpl->set_var( "variabeleNoRecords", "");
  $tpl->parse( "Formvariabele", false);
//-------------------------------
// variabele Close Event begin
// variabele Close Event end
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
  $sFormTitle = "Voorraadsysteem beheer";

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