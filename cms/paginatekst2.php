<?php
/*********************************************************************************
 *       Filename: paginatekst2.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// paginatekst2 CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// paginatekst2 CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "paginatekst2.php";
$template_filename = "paginatekst2.html";
//===============================



//===============================
// paginatekst2 PageSecurity begin
check_security(3);
// paginatekst2 PageSecurity end
//===============================

//===============================
// paginatekst2 Open Event begin
// paginatekst2 Open Event end
//===============================

//===============================
// paginatekst2 OpenAnyPage Event start
// paginatekst2 OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// paginatekst2 Show begin

//===============================
// Perform the form's action
//-------------------------------
// Initialize error variables
//-------------------------------
$stekstenErr = "";
$scombinatieErr = "";

//-------------------------------
// Select the FormAction
//-------------------------------
switch ($sForm) {
  case "teksten":
    teksten_action($sAction);
  break;
  case "combinatie":
    combinatie_action($sAction);
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
Header_show();Form_show();titel_show();teksten_show();combinatie_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// paginatekst2 Show end

//===============================
// paginatekst2 Close Event begin
// paginatekst2 Close Event end
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
  $fldtype = "";
//-------------------------------

//-------------------------------
// teksten Action begin
//-------------------------------
  $sActionFileName = "paginatekst2.php";
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
// Load all form fields into variables
//-------------------------------
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
      $stekstenErr .= "The value in field  is incorrect.<br>";
    
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
    case "insert":
//-------------------------------
// teksten Insert Event begin
// teksten Insert Event end
//-------------------------------
        $sSQL = "insert into teksten (" . 
          "naam," . 
          "naam_uk," . 
          "tekst," . 
          "tekst_uk," . 
          "type)" . 
          " values (" . 
          tosql($fldnaam, "Text") . "," . 
          tosql($fldnaam_uk, "Text") . "," . 
          tosql($fldtekst, "Text") . "," . 
          tosql($fldtekst_uk, "Memo") . "," . 
          tosql($fldtype, "Number") . 
          ")";
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
  $fldtype = "";
//-------------------------------
// teksten Show begin
//-------------------------------
  $sFormTitle = "1. Nieuwe tekst aanmaken";
  $sWhere = "";
  $bPK = true;
//-------------------------------
// Load primary key and form parameters
//-------------------------------
  if($stekstenErr == "")
  {
    $tpl->set_var("Trn_categories_id", get_param("categories_id"));
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
    $fldtype = strip(get_param("type"));
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
    $fldtype = $db->f("type");
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
    $tpl->set_var("tekstenDelete", "");
    $tpl->set_var("tekstenUpdate", "");
    $tpl->set_var("tekstenInsert", "");
//-------------------------------
// teksten ShowEdit Event begin
// teksten ShowEdit Event end
//-------------------------------
  }
  else
  {
    if($stekstenErr == "")
    {
      $fldtype= "0";
    }
    $tpl->set_var("tekstenEdit", "");
    $tpl->parse("tekstenInsert", false);
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
    $tpl->set_var("type", tohtml($fldtype));
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

//===============================
// Action of the Record Form
//-------------------------------
function combinatie_action($sAction)
{
//-------------------------------
// Initialize variables  
//-------------------------------
  global $db;
  global $tpl;
  global $sForm;
  global $scombinatieErr;
  $bExecSQL = true;
  $sActionFileName = "";
  $sParams = "?";
  $sWhere = "";
  $bErr = false;
  $pPKtekst_combi_id = "";
  $fldtekst_id = "";
  $fldcategories_id = "";
//-------------------------------

//-------------------------------
// combinatie Action begin
//-------------------------------
  $sActionFileName = "pagina.php";
  $sParams .= "categories_id=" . urlencode(get_param("Trn_categories_id"));

//-------------------------------
// CANCEL action
//-------------------------------
  if($sAction == "cancel")
  {

//-------------------------------
// combinatie BeforeCancel Event begin
// combinatie BeforeCancel Event end
//-------------------------------
    header("Location: " . $sActionFileName . $sParams);
    exit;
  }
//-------------------------------

//-------------------------------
// Load all form fields into variables
//-------------------------------
  $fldtekst_id = get_param("tekst_id");
  $fldcategories_id = get_param("categories_id");

//-------------------------------
// Validate fields
//-------------------------------
  if($sAction == "insert" || $sAction == "update") 
  {
    if(!strlen($fldtekst_id))
      $scombinatieErr .= "The value in field Tekst is required.<br>";
    
    if(!strlen($fldcategories_id))
      $scombinatieErr .= "The value in field Pagina is required.<br>";
    
    if(!is_number($fldtekst_id))
      $scombinatieErr .= "The value in field Tekst is incorrect.<br>";
    
    if(!is_number($fldcategories_id))
      $scombinatieErr .= "The value in field Pagina is incorrect.<br>";
    
//-------------------------------
// combinatie Check Event begin
// combinatie Check Event end
//-------------------------------
    if(strlen($scombinatieErr)) return;
  }
//-------------------------------


//-------------------------------
// Create SQL statement
//-------------------------------
  switch(strtolower($sAction)) 
  {
    case "insert":
//-------------------------------
// combinatie Insert Event begin
// combinatie Insert Event end
//-------------------------------
        $sSQL = "insert into tekst_combi (" . 
          "tekst_id," . 
          "categories_id)" . 
          " values (" . 
          tosql($fldtekst_id, "Number") . "," . 
          tosql($fldcategories_id, "Number") . 
          ")";
    break;
  }
//-------------------------------
//-------------------------------
// combinatie BeforeExecute Event begin
// combinatie BeforeExecute Event end
//-------------------------------

//-------------------------------
// Execute SQL statement
//-------------------------------
  if(strlen($scombinatieErr)) return;
  if($bExecSQL)
    $db->query($sSQL);
  header("Location: " . $sActionFileName . $sParams);
  exit;
//-------------------------------
// combinatie Action end
//-------------------------------
}

//===============================
// Display Record Form
//-------------------------------
function combinatie_show()
{
  global $db;
  global $tpl;
  global $sAction;
  global $sForm;
  global $scombinatieErr;
  
  $fldtekst_combi_id = "";
  $fldtekst_id = "";
  $fldcategories_id = "";
//-------------------------------
// combinatie Show begin
//-------------------------------
  $sFormTitle = "2. Tekst aan pagina koppelen";
  $sWhere = "";
  $bPK = true;
//-------------------------------
// Load primary key and form parameters
//-------------------------------
  if($scombinatieErr == "")
  {
    $fldcategories_id = get_param("categories_id");
    $fldtekst_id2 = get_param("tekst_id2");
    $tpl->set_var("Trn_categories_id", get_param("categories_id"));
    $ptekst_combi_id = get_param("tekst_combi_id");
    $tpl->set_var("combinatieError", "");
  }
  else
  {
    $fldtekst_combi_id = strip(get_param("tekst_combi_id"));
    $fldtekst_id = strip(get_param("tekst_id"));
    $fldcategories_id = strip(get_param("categories_id"));
    $tpl->set_var("Trn_categories_id", get_param("Trn_categories_id"));
    $ptekst_combi_id = get_param("PK_tekst_combi_id");
    $tpl->set_var("scombinatieErr", $scombinatieErr);
    $tpl->set_var("FormTitle", $sFormTitle);
    $tpl->parse("combinatieError", false);
  }
//-------------------------------

//-------------------------------
// Load all form fields

//-------------------------------

//-------------------------------
// Build WHERE statement
//-------------------------------
  
  if( !strlen($ptekst_combi_id)) $bPK = false;
  
  $sWhere .= "tekst_combi_id=" . tosql($ptekst_combi_id, "Number");
  $tpl->set_var("PK_tekst_combi_id", $ptekst_combi_id);
//-------------------------------
//-------------------------------
// combinatie Open Event begin
// combinatie Open Event end
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Build SQL statement and execute query
//-------------------------------
  $sSQL = "select * from tekst_combi where " . $sWhere;
  // Execute SQL statement
  $db->query($sSQL);
  $bIsUpdateMode = ($bPK && !($sAction == "insert" && $sForm == "combinatie") && $db->next_record());
//-------------------------------

//-------------------------------
// Load all fields into variables from recordset or input parameters
//-------------------------------
  if($bIsUpdateMode)
  {
    $fldtekst_combi_id = $db->f("tekst_combi_id");
//-------------------------------
// Load data from recordset when form displayed first time
//-------------------------------
    if($scombinatieErr == "") 
    {
      $fldtekst_id = $db->f("tekst_id");
      $fldcategories_id = $db->f("categories_id");
    }
    $tpl->set_var("combinatieDelete", "");
    $tpl->set_var("combinatieUpdate", "");
    $tpl->set_var("combinatieInsert", "");
//-------------------------------
// combinatie ShowEdit Event begin
// combinatie ShowEdit Event end
//-------------------------------
  }
  else
  {
    if($scombinatieErr == "")
    {
      $fldtekst_id = tohtml(get_param("tekst_id2"));
      $fldcategories_id = tohtml(get_param("categories_id"));
    }
    $tpl->set_var("combinatieEdit", "");
    $tpl->parse("combinatieInsert", false);
//-------------------------------
// combinatie ShowInsert Event begin
// combinatie ShowInsert Event end
//-------------------------------
  }
  $tpl->parse("combinatieCancel", false);
//-------------------------------
// combinatie Show Event begin
// combinatie Show Event end
//-------------------------------

//-------------------------------
// Show form field
//-------------------------------
    $tpl->set_var("tekst_combi_id", tohtml($fldtekst_combi_id));
    $tpl->set_var("combinatieLBtekst_id", "");
    $lookup_tekst_id = db_fill_array("SELECT *  FROM `teksten`  WHERE type = 0 ORDER BY tekst_id DESC;");

    if(is_array($lookup_tekst_id))
    {
      reset($lookup_tekst_id);
      while(list($key, $value) = each($lookup_tekst_id))
      {
        $tpl->set_var("ID", $key);
        $tpl->set_var("Value", $value);
        if($key == $fldtekst_id)
          $tpl->set_var("Selected", "SELECTED" );
        else 
          $tpl->set_var("Selected", "");
        $tpl->parse("combinatieLBtekst_id", true);
      }
    }
    
    $tpl->set_var("combinatieLBcategories_id", "");
    $lookup_categories_id = db_fill_array("select categories_id, naam from categories order by 2");

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
        $tpl->parse("combinatieLBcategories_id", true);
      }
    }
    
  $tpl->parse("Formcombinatie", false);

//-------------------------------
// combinatie Close Event begin
// combinatie Close Event end
//-------------------------------

//-------------------------------
// combinatie Show end
//-------------------------------
}
//===============================
?>