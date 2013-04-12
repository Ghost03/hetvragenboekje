<?php
/*********************************************************************************
 *       Filename: Login.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// Login CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// Login CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "Login.php";
$template_filename = "Login.html";
//===============================



//===============================
// Login PageSecurity begin
// Login PageSecurity end
//===============================

//===============================
// Login Open Event begin
// Login Open Event end
//===============================

//===============================
// Login OpenAnyPage Event start
// Login OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// Login Show begin

//===============================
// Perform the form's action
//-------------------------------
// Initialize error variables
//-------------------------------
$sloginErr = "";

//-------------------------------
// Select the FormAction
//-------------------------------
switch ($sForm) {
  case "login":
    login_action($sAction);
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
Header_show();Form_show();titel_show();login_show();jpg_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// Login Show end

//===============================
// Login Close Event begin
// Login Close Event end
//===============================
//********************************************************************************


//===============================
// Login Form Action
//-------------------------------
function login_action($sAction)
{
  global $db;
  global $tpl;
  global $sloginErr;
  global $filename;

  switch(strtolower($sAction))
  {
    case "login":
//-------------------------------
// login CustomLogin Event begin
//-------------------------------
      $sLogin = get_param("Login");
      $sPassword = get_param("Password");
      $db->query("SELECT login_id,niveau, categories_id FROM login WHERE gebruikersnaam =" . tosql($sLogin, "Text") . " AND wachtwoord=" . tosql($sPassword, "Text"));
      $is_passed = $db->next_record();

      if($is_passed)
      {
//-------------------------------
// Login and password passed
//-------------------------------
        set_session("UserID", $db->f("login_id"));
        set_session("UserRights", $db->f("niveau"));
        set_session("categories_id", $db->f("categories_id"));
        $sPage = get_param("ret_page");
        if (strlen($sPage))
        {
          header("Location: " . $sPage);
          exit;
        }
        else
        {
          header("Location: index.php");
          exit;
        }
      }
      else
      {
        $sloginErr = "Login or Password is incorrect.";
      }
//-------------------------------
// login CustomLogin Event end
//-------------------------------
    break;
    case "logout":
//-------------------------------
// Logout action
//-------------------------------
//-------------------------------
// login Logout begin
//-------------------------------

//-------------------------------
// login OnLogout Event begin
// login OnLogout Event end
//-------------------------------
      session_unregister("UserID");
      session_unregister("UserRights");
      if(strlen(get_param("ret_page")))
      {
        header("Location:" . $filename . "?ret_page=" . urlencode(get_param("ret_page")));
        exit;
      }
      else
      {
        header("Location:" . $filename);
        exit;
      }
//-------------------------------
// login Logout end
//-------------------------------
    break;
  }
}
//===============================


//===============================
// Display Login Form
//-------------------------------
function login_show()
{
  global $tpl;
  global $sloginErr;
  global $db;
  $sFormTitle = "Aanmelden";

//-------------------------------
// login Show begin
//-------------------------------

//-------------------------------
// login Open Event begin
// login Open Event end
//-------------------------------
  $tpl->set_var("FormTitle", $sFormTitle);
  $tpl->set_var("sloginErr", $sloginErr);
  $tpl->set_var("querystring", get_param("querystring"));
  $tpl->set_var("ret_page", get_param("ret_page"));
//-------------------------------
// login BeforeShow Event begin
// login BeforeShow Event end
//-------------------------------
  if(get_session("UserID") == "") 
  {
//-------------------------------
// User is not logged in
//-------------------------------
    $tpl->set_var("LogoutAct", "");
    $tpl->set_var("UserInd", "");
    $tpl->set_var("Login", strip(tohtml(get_param("Login"))));
    if($sloginErr == "")
      $tpl->set_var("loginError", "");
    else
    {
      $tpl->set_var("sloginErr", $sloginErr);
      $tpl->parse("loginError", false);
    }
    $tpl->parse("LoginAct", false);
  }
  else
  {
//-------------------------------
// User logged in
//-------------------------------
    $db->query("SELECT gebruikersnaam FROM login WHERE login_id=". get_session("UserID"));
    $db->next_record();
    $tpl->set_var("loginError", "");
    $tpl->set_var("LoginAct", "");
    $tpl->set_var("UserID", $db->f("gebruikersnaam"));
    $tpl->parse("UserInd", false);
  }
  $tpl->parse("Formlogin", false);

//-------------------------------
// login Close Event begin
// login Close Event end
//-------------------------------

//-------------------------------
// login Show end
//-------------------------------
}
//===============================



//===============================
// Display Menu Form
//-------------------------------
function jpg_show()
{
  global $tpl;
  global $db;
  $sFormTitle = "";

//-------------------------------
// jpg Open Event begin
// jpg Open Event end
//-------------------------------

//-------------------------------
// Set URLs
//-------------------------------
  $fldjpg = "";
//-------------------------------
// jpg Show begin
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// jpg BeforeShow Event begin
$fldjpg="<img border=0 src=files/login.jpg>";
// jpg BeforeShow Event end
//-------------------------------

//-------------------------------
// Show fields
//-------------------------------
  $tpl->set_var("jpg", $fldjpg);
  $tpl->parse("Formjpg", false);

//-------------------------------
// jpg Show end
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
  $sFormTitle = "Aanmelden / Afmelden";

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