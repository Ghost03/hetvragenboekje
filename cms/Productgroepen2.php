<?php
/*********************************************************************************
 *       Filename: Productgroepen2.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// Productgroepen2 CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// Productgroepen2 CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "Productgroepen2.php";
$template_filename = "Productgroepen2.html";
//===============================



//===============================
// Productgroepen2 PageSecurity begin
check_security(3);
// Productgroepen2 PageSecurity end
//===============================

//===============================
// Productgroepen2 Open Event begin
// Productgroepen2 Open Event end
//===============================

//===============================
// Productgroepen2 OpenAnyPage Event start
// Productgroepen2 OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// Productgroepen2 Show begin

//===============================
// Perform the form's action
//-------------------------------
// Initialize error variables
//-------------------------------
$sKlantErr = "";

//-------------------------------
// Select the FormAction
//-------------------------------
switch ($sForm) {
  case "Klant":
    Klant_action($sAction);
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
Header_show();Form_show();titel_show();Klant_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// Productgroepen2 Show end

//===============================
// Productgroepen2 Close Event begin
// Productgroepen2 Close Event end
//===============================
//********************************************************************************


//===============================
// Action of the Record Form
//-------------------------------
function Klant_action($sAction)
{
//-------------------------------
// Initialize variables  
//-------------------------------
  global $db;
  global $tpl;
  global $sForm;
  global $sKlantErr;
  $bExecSQL = true;
  $sActionFileName = "";
  $sParams = "?";
  $sWhere = "";
  $bErr = false;
  $pPKklant_combi_id = "";
  $fldproductgroep_id = "";
//-------------------------------

//-------------------------------
// Klant Action begin
//-------------------------------
  $sActionFileName = "Productgroepen.php";
  $sParams .= "login_id=" . urlencode(get_param("Trn_login_id"));

//-------------------------------
// CANCEL action
//-------------------------------
  if($sAction == "cancel")
  {

//-------------------------------
// Klant BeforeCancel Event begin
// Klant BeforeCancel Event end
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
    $pPKklant_combi_id = get_param("PK_klant_combi_id");
    if( !strlen($pPKklant_combi_id)) return;
    $sWhere = "klant_combi_id=" . tosql($pPKklant_combi_id, "Number");
  }
//-------------------------------


//-------------------------------
// Load all form fields into variables
//-------------------------------
  $fldlogin_id = get_param("Rqd_login_id");
  $fldproductgroep_id = get_param("productgroep_id");

//-------------------------------
// Create SQL statement
//-------------------------------
  switch(strtolower($sAction)) 
  {
    case "insert":
//-------------------------------
// Klant Insert Event begin
// Klant Insert Event end
//-------------------------------
        $sSQL = "insert into klant_combi (" . 
          "login_id," . 
          "productgroep_id)" . 
          " values (" . 
          tosql($fldlogin_id, "Number") . "," . 
          tosql($fldproductgroep_id, "Number") . 
          ")";
    break;
    case "delete":
//-------------------------------
// Klant Delete Event begin
// Klant Delete Event end
//-------------------------------
        $sSQL = "delete from klant_combi where " . $sWhere;
    break;
  }
//-------------------------------
//-------------------------------
// Klant BeforeExecute Event begin
// Klant BeforeExecute Event end
//-------------------------------

//-------------------------------
// Execute SQL statement
//-------------------------------
  if(strlen($sKlantErr)) return;
  if($bExecSQL)
    $db->query($sSQL);
  header("Location: " . $sActionFileName . $sParams);
  exit;
//-------------------------------
// Klant Action end
//-------------------------------
}

//===============================
// Display Record Form
//-------------------------------
function Klant_show()
{
  global $db;
  global $tpl;
  global $sAction;
  global $sForm;
  global $sKlantErr;
  
  $fldklant_combi_id = "";
  $fldlogin_id = "";
  $fldproductgroep_id = "";
//-------------------------------
// Klant Show begin
//-------------------------------
  $sFormTitle = "Productgroepen {login_id}";
  $sWhere = "";
  $bPK = true;
//-------------------------------
// Load primary key and form parameters
//-------------------------------
  if($sKlantErr == "")
  {
    $fldlogin_id = get_param("login_id");
    $tpl->set_var("Trn_login_id", get_param("login_id"));
    $tpl->set_var("Rqd_login_id", get_param("login_id"));
    $pklant_combi_id = get_param("klant_combi_id");
    $tpl->set_var("KlantError", "");
  }
  else
  {
    $fldklant_combi_id = strip(get_param("klant_combi_id"));
    $fldproductgroep_id = strip(get_param("productgroep_id"));
    $tpl->set_var("Rqd_login_id", get_param("Rqd_login_id"));
    $fldlogin_id = get_param("Trn_login_id");
    $tpl->set_var("Trn_login_id", get_param("Trn_login_id"));
    $pklant_combi_id = get_param("PK_klant_combi_id");
    $tpl->set_var("sKlantErr", $sKlantErr);
    $tpl->set_var("FormTitle", $sFormTitle);
    $tpl->parse("KlantError", false);
  }
//-------------------------------

//-------------------------------
// Load all form fields

//-------------------------------

//-------------------------------
// Build WHERE statement
//-------------------------------
  
  if( !strlen($pklant_combi_id)) $bPK = false;
  
  $sWhere .= "klant_combi_id=" . tosql($pklant_combi_id, "Number");
  $tpl->set_var("PK_klant_combi_id", $pklant_combi_id);
//-------------------------------
//-------------------------------
// Klant Open Event begin
// Klant Open Event end
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Build SQL statement and execute query
//-------------------------------
  $sSQL = "select * from klant_combi where " . $sWhere;
  // Execute SQL statement
  $db->query($sSQL);
  $bIsUpdateMode = ($bPK && !($sAction == "insert" && $sForm == "Klant") && $db->next_record());
//-------------------------------

//-------------------------------
// Load all fields into variables from recordset or input parameters
//-------------------------------
  if($bIsUpdateMode)
  {
    $fldklant_combi_id = $db->f("klant_combi_id");
    $fldlogin_id = $db->f("login_id");
//-------------------------------
// Load data from recordset when form displayed first time
//-------------------------------
    if($sKlantErr == "") 
    {
      $fldproductgroep_id = $db->f("productgroep_id");
    }
    $tpl->set_var("KlantUpdate", "");
    $tpl->set_var("KlantInsert", "");
    $tpl->parse("KlantEdit", false);
//-------------------------------
// Klant ShowEdit Event begin
// Klant ShowEdit Event end
//-------------------------------
  }
  else
  {
    if($sKlantErr == "")
    {
      $fldlogin_id = tohtml(get_param("login_id"));
    }
    $tpl->set_var("KlantEdit", "");
    $tpl->parse("KlantInsert", false);
//-------------------------------
// Klant ShowInsert Event begin
// Klant ShowInsert Event end
//-------------------------------
  }
  $tpl->parse("KlantCancel", false);
//-------------------------------
// Set lookup fields
//-------------------------------
  $fldlogin_id = get_db_value("SELECT naam FROM login WHERE login_id=" . tosql($fldlogin_id, "Number"));
//-------------------------------
// Klant Show Event begin
// Klant Show Event end
//-------------------------------

//-------------------------------
// Show form field
//-------------------------------
    $tpl->set_var("klant_combi_id", tohtml($fldklant_combi_id));
      $tpl->set_var("login_id", tohtml($fldlogin_id));
    $tpl->set_var("KlantLBproductgroep_id", "");
    $lookup_productgroep_id = db_fill_array("select productgroep_id, naam from productgroep order by 2");

    if(is_array($lookup_productgroep_id))
    {
      reset($lookup_productgroep_id);
      while(list($key, $value) = each($lookup_productgroep_id))
      {
        $tpl->set_var("ID", $key);
        $tpl->set_var("Value", $value);
        if($key == $fldproductgroep_id)
          $tpl->set_var("Selected", "SELECTED" );
        else 
          $tpl->set_var("Selected", "");
        $tpl->parse("KlantLBproductgroep_id", true);
      }
    }
    
  $tpl->parse("FormKlant", false);

//-------------------------------
// Klant Close Event begin
// Klant Close Event end
//-------------------------------

//-------------------------------
// Klant Show end
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