<?php
/*********************************************************************************
 *       Filename: gebruikers.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// gebruikers CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// gebruikers CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "gebruikers.php";
$template_filename = "gebruikers.html";
//===============================



//===============================
// gebruikers PageSecurity begin
check_security(3);
// gebruikers PageSecurity end
//===============================

//===============================
// gebruikers Open Event begin
// gebruikers Open Event end
//===============================

//===============================
// gebruikers OpenAnyPage Event start
// gebruikers OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// gebruikers Show begin

//===============================
// Perform the form's action
//-------------------------------
// Initialize error variables
//-------------------------------
$saanpassenErr = "";

//-------------------------------
// Select the FormAction
//-------------------------------
switch ($sForm) {
  case "aanpassen":
    aanpassen_action($sAction);
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
Header_show();Form_show();titel_show();overzicht_show();aanpassen_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// gebruikers Show end

//===============================
// gebruikers Close Event begin
// gebruikers Close Event end
//===============================
//********************************************************************************


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
  $sFormTitle = "Overzicht gebruikers";
  $HasParam = false;
  $iRecordsPerPage = 20;
  $iCounter = 0;
  $iPage = 0;
  $bEof = false;
  $iSort = "";
  $iSorted = "";
  $sDirection = "";
  $sSortParams = "";
  $sActionFileName = "gebruikers.php";


  $tpl->set_var("TransitParams", "");
  $tpl->set_var("FormParams", "");



//-------------------------------
// Build ORDER BY statement
//-------------------------------
  $sOrder = " order by l.niveau Desc";
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
    if ($iSort == 1) $sOrder = " order by l.naam" . $sDirection;
    if ($iSort == 2) $sOrder = " order by l.gebruikersnaam" . $sDirection;
    if ($iSort == 3) $sOrder = " order by l.wachtwoord" . $sDirection;
    if ($iSort == 4) $sOrder = " order by l.niveau" . $sDirection;
  }

//-------------------------------
// Build base SQL statement
//-------------------------------
  $sSQL = "select l.gebruikersnaam as l_gebruikersnaam, " . 
    "l.login_id as l_login_id, " . 
    "l.naam as l_naam, " . 
    "l.niveau as l_niveau, " . 
    "l.wachtwoord as l_wachtwoord " . 
    " from login l ";
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
// Prepare the lists of values
//-------------------------------
  
  $aniveau = split(";", "1;Klant;2;Administrator;3;Beheerder");
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
    $fldedit_URLLink = "gebruikers.php";
    $fldedit_login_id = $db->f("l_login_id");
    $fldgebruikersnaam = $db->f("l_gebruikersnaam");
    $fldlogin_id = $db->f("l_login_id");
    $fldnaam = $db->f("l_naam");
    $fldniveau = $db->f("l_niveau");
    $fldwachtwoord = $db->f("l_wachtwoord");
    $next_record = $db->next_record();
    
//-------------------------------
// overzicht Show begin
//-------------------------------

//-------------------------------
// overzicht Show Event begin
$fldedit="<img border=0 src=files/ed.gif alt=Bekijk>";
// overzicht Show Event end
//-------------------------------

//-------------------------------
// Replace Template fields with database values
//-------------------------------
    
    $tpl->set_var("login_id", tohtml($fldlogin_id));
      $tpl->set_var("naam", tohtml($fldnaam));
      $tpl->set_var("gebruikersnaam", tohtml($fldgebruikersnaam));
      $tpl->set_var("wachtwoord", tohtml($fldwachtwoord));
      $fldniveau = get_lov_value($fldniveau, $aniveau);
      $tpl->set_var("niveau", tohtml($fldniveau));
      $tpl->set_var("edit", $fldedit);
      $tpl->set_var("edit_URLLink", $fldedit_URLLink);
      $tpl->set_var("Prmedit_login_id", urlencode($fldedit_login_id));
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


//===============================
// Display Menu Form
//-------------------------------
function titel_show()
{
  global $tpl;
  global $db;
  $sFormTitle = "Gebruiker beheer";

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
function aanpassen_action($sAction)
{
//-------------------------------
// Initialize variables  
//-------------------------------
  global $db;
  global $tpl;
  global $sForm;
  global $saanpassenErr;
  $bExecSQL = true;
  $sActionFileName = "";
  $sWhere = "";
  $bErr = false;
  $pPKlogin_id = "";
  $fldnaam = "";
  $fldgebruikersnaam = "";
  $fldwachtwoord = "";
  $fldniveau = "";
  $fldcategories_id = "";
//-------------------------------

//-------------------------------
// aanpassen Action begin
//-------------------------------
  $sActionFileName = "gebruikers.php";

//-------------------------------
// CANCEL action
//-------------------------------
  if($sAction == "cancel")
  {

//-------------------------------
// aanpassen BeforeCancel Event begin
// aanpassen BeforeCancel Event end
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
    $pPKlogin_id = get_param("PK_login_id");
    if( !strlen($pPKlogin_id)) return;
    $sWhere = "login_id=" . tosql($pPKlogin_id, "Number");
  }
//-------------------------------


//-------------------------------
// Load all form fields into variables
//-------------------------------
  $fldnaam = get_param("naam");
  $fldgebruikersnaam = get_param("gebruikersnaam");
  $fldwachtwoord = get_param("wachtwoord");
  $fldniveau = get_param("niveau");
  $fldcategories_id = get_param("categories_id");

//-------------------------------
// Validate fields
//-------------------------------
  if($sAction == "insert" || $sAction == "update") 
  {
    if(!strlen($fldnaam))
      $saanpassenErr .= "The value in field Naam is required.<br>";
    
    if(!strlen($fldgebruikersnaam))
      $saanpassenErr .= "The value in field Gebruikersnaam is required.<br>";
    
    if(!strlen($fldwachtwoord))
      $saanpassenErr .= "The value in field Wachtwoord is required.<br>";
    
    if(!strlen($fldniveau))
      $saanpassenErr .= "The value in field Niveau is required.<br>";
    
    if(!is_number($fldniveau))
      $saanpassenErr .= "The value in field Niveau is incorrect.<br>";
    
    if(!is_number($fldcategories_id))
      $saanpassenErr .= "The value in field Businessunit is incorrect.<br>";
    
//-------------------------------
// aanpassen Check Event begin
// aanpassen Check Event end
//-------------------------------
    if(strlen($saanpassenErr)) return;
  }
//-------------------------------


//-------------------------------
// Create SQL statement
//-------------------------------
  switch(strtolower($sAction)) 
  {
    case "insert":
//-------------------------------
// aanpassen Insert Event begin
// aanpassen Insert Event end
//-------------------------------
        $sSQL = "insert into login (" . 
          "naam," . 
          "gebruikersnaam," . 
          "wachtwoord," . 
          "niveau," . 
          "categories_id)" . 
          " values (" . 
          tosql($fldnaam, "Text") . "," . 
          tosql($fldgebruikersnaam, "Text") . "," . 
          tosql($fldwachtwoord, "Text") . "," . 
          tosql($fldniveau, "Number") . "," . 
          tosql($fldcategories_id, "Number") . 
          ")";
    break;
    case "update":

//-------------------------------
// aanpassen Update Event begin
// aanpassen Update Event end
//-------------------------------
        $sSQL = "update login set " .
          "naam=" . tosql($fldnaam, "Text") .
          ",gebruikersnaam=" . tosql($fldgebruikersnaam, "Text") .
          ",wachtwoord=" . tosql($fldwachtwoord, "Text") .
          ",niveau=" . tosql($fldniveau, "Number") .
          ",categories_id=" . tosql($fldcategories_id, "Number");
        $sSQL .= " where " . $sWhere;
    break;
    case "delete":
//-------------------------------
// aanpassen Delete Event begin
// aanpassen Delete Event end
//-------------------------------
        $sSQL = "delete from login where " . $sWhere;
    break;
  }
//-------------------------------
//-------------------------------
// aanpassen BeforeExecute Event begin
// aanpassen BeforeExecute Event end
//-------------------------------

//-------------------------------
// Execute SQL statement
//-------------------------------
  if(strlen($saanpassenErr)) return;
  if($bExecSQL)
    $db->query($sSQL);
  header("Location: " . $sActionFileName);
  exit;
//-------------------------------
// aanpassen Action end
//-------------------------------
}

//===============================
// Display Record Form
//-------------------------------
function aanpassen_show()
{
  global $db;
  global $tpl;
  global $sAction;
  global $sForm;
  global $saanpassenErr;
  
  $fldlogin_id = "";
  $fldnaam = "";
  $fldgebruikersnaam = "";
  $fldwachtwoord = "";
  $fldniveau = "";
  $fldcategories_id = "";
//-------------------------------
// aanpassen Show begin
//-------------------------------
  $sFormTitle = "Gebruiker {naam} beheer";
  $sWhere = "";
  $bPK = true;
  $scategories_idDisplayValue = "";
//-------------------------------
// Load primary key and form parameters
//-------------------------------
  if($saanpassenErr == "")
  {
    $fldlogin_id = get_param("login_id");
    $plogin_id = get_param("login_id");
    $tpl->set_var("aanpassenError", "");
  }
  else
  {
    $fldlogin_id = strip(get_param("login_id"));
    $fldnaam = strip(get_param("naam"));
    $fldgebruikersnaam = strip(get_param("gebruikersnaam"));
    $fldwachtwoord = strip(get_param("wachtwoord"));
    $fldniveau = strip(get_param("niveau"));
    $fldcategories_id = strip(get_param("categories_id"));
    $plogin_id = get_param("PK_login_id");
    $tpl->set_var("saanpassenErr", $saanpassenErr);
    $tpl->set_var("FormTitle", $sFormTitle);
    $tpl->parse("aanpassenError", false);
  }
//-------------------------------

//-------------------------------
// Load all form fields

//-------------------------------

//-------------------------------
// Build WHERE statement
//-------------------------------
  
  if( !strlen($plogin_id)) $bPK = false;
  
  $sWhere .= "login_id=" . tosql($plogin_id, "Number");
  $tpl->set_var("PK_login_id", $plogin_id);
//-------------------------------
//-------------------------------
// aanpassen Open Event begin
// aanpassen Open Event end
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Build SQL statement and execute query
//-------------------------------
  $sSQL = "select * from login where " . $sWhere;
  // Execute SQL statement
  $db->query($sSQL);
  $bIsUpdateMode = ($bPK && !($sAction == "insert" && $sForm == "aanpassen") && $db->next_record());
//-------------------------------

//-------------------------------
// Load all fields into variables from recordset or input parameters
//-------------------------------
  if($bIsUpdateMode)
  {
    $fldlogin_id = $db->f("login_id");
//-------------------------------
// Load data from recordset when form displayed first time
//-------------------------------
    if($saanpassenErr == "") 
    {
      $fldnaam = $db->f("naam");
      $fldgebruikersnaam = $db->f("gebruikersnaam");
      $fldwachtwoord = $db->f("wachtwoord");
      $fldniveau = $db->f("niveau");
      $fldcategories_id = $db->f("categories_id");
    }
    $tpl->set_var("aanpassenInsert", "");
    $tpl->parse("aanpassenEdit", false);
//-------------------------------
// aanpassen ShowEdit Event begin
// aanpassen ShowEdit Event end
//-------------------------------
  }
  else
  {
    if($saanpassenErr == "")
    {
      $fldlogin_id = tohtml(get_param("login_id"));
    }
    $tpl->set_var("aanpassenEdit", "");
    $tpl->parse("aanpassenInsert", false);
//-------------------------------
// aanpassen ShowInsert Event begin
// aanpassen ShowInsert Event end
//-------------------------------
  }
  $tpl->parse("aanpassenCancel", false);
//-------------------------------
// aanpassen Show Event begin
// aanpassen Show Event end
//-------------------------------

//-------------------------------
// Show form field
//-------------------------------
    $tpl->set_var("login_id", tohtml($fldlogin_id));
    $tpl->set_var("naam", tohtml($fldnaam));
    $tpl->set_var("gebruikersnaam", tohtml($fldgebruikersnaam));
    $tpl->set_var("wachtwoord", tohtml($fldwachtwoord));
    $tpl->set_var("aanpassenLBniveau", "");
    $LOV = split(";", "1;Klant;2;Administrator;3;Beheerder");
  
    if(sizeof($LOV)%2 != 0) 
      $array_length = sizeof($LOV) - 1;
    else
      $array_length = sizeof($LOV);
    reset($LOV);
    for($i = 0; $i < $array_length; $i = $i + 2)
    {
      $tpl->set_var("ID", $LOV[$i]);
      $tpl->set_var("Value", $LOV[$i + 1]);
      if($LOV[$i] == $fldniveau) 
        $tpl->set_var("Selected", "SELECTED");
      else
        $tpl->set_var("Selected", "");
      $tpl->parse("aanpassenLBniveau", true);
    }
    $tpl->set_var("aanpassenLBcategories_id", "");
    $tpl->set_var("ID", "");
    $tpl->set_var("Value", $scategories_idDisplayValue);
    $tpl->set_var("Selected", "");
    $tpl->parse("aanpassenLBcategories_id", true);
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
        $tpl->parse("aanpassenLBcategories_id", true);
      }
    }
    
  $tpl->parse("Formaanpassen", false);

//-------------------------------
// aanpassen Close Event begin
// aanpassen Close Event end
//-------------------------------

//-------------------------------
// aanpassen Show end
//-------------------------------
}
//===============================
?>