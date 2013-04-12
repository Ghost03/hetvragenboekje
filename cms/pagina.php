<?php
/*********************************************************************************
 *       Filename: pagina.php
 *       Generated with CodeCharge 2.0.5
 *       PHP 4.0 & Templates build 11/30/2001
 *********************************************************************************/

//-------------------------------
// pagina CustomIncludes begin

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

// pagina CustomIncludes end
//-------------------------------

session_start();

//===============================
// Save Page and File Name available into variables
//-------------------------------
$filename = "pagina.php";
$template_filename = "pagina.html";
//===============================



//===============================
// pagina PageSecurity begin
check_security(3);
// pagina PageSecurity end
//===============================

//===============================
// pagina Open Event begin
// pagina Open Event end
//===============================

//===============================
// pagina OpenAnyPage Event start
// pagina OpenAnyPage Event end
//===============================

//===============================
//Save the name of the form and type of action into the variables
//-------------------------------
$sAction = get_param("FormAction");
$sForm = get_param("FormName");
//===============================

// pagina Show begin

//===============================
// Perform the form's action
//-------------------------------
// Initialize error variables
//-------------------------------
$streeErr = "";
$spaginaErr = "";

//-------------------------------
// Select the FormAction
//-------------------------------
switch ($sForm) {
  case "tree":
    tree_action($sAction);
  break;
  case "pagina":
    pagina_action($sAction);
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
Header_show();Form_show();titel_show();tree_show();pagina_show();teksten_show();

//-------------------------------
// Process page templates
//-------------------------------
$tpl->parse("Header", false);
$tpl->parse("Footer", false);
//-------------------------------
// Output the page to the browser
//-------------------------------
$tpl->pparse("main", false);
// pagina Show end

//===============================
// pagina Close Event begin
// pagina Close Event end
//===============================
//********************************************************************************


//===============================
// Tree Form Action
//-------------------------------
function tree_action($sAction)
{
//-------------------------------
// tree Action begin
//-------------------------------
  $sCatID = get_param("categories_id");
  if($sCatID) 
  {
    if(get_db_value("SELECT count(*) FROM categories WHERE parent=" . $sCatID) == 0)
    {
      header("Location: pagina.php?categories_id=" . $sCatID);
      exit;
    }
  }
//-------------------------------
// tree Action end
//-------------------------------
}
//===============================

//===============================
// Display Tree Form
//-------------------------------
function tree_show()
{
  global $tpl;
  global $db;
  $sFormTitle = "";
//-------------------------------
// tree Open Event begin
// tree Open Event end
//-------------------------------
//-------------------------------
// tree Show begin
//-------------------------------
  $tpl->set_var("FormTitle", $sFormTitle);
  $tpl->set_var("categories_id", "");
  $tpl->set_var("naam", "");
  $tpl->set_var("parent", "");
  $tpl->set_var("ActionPage", "pagina.php");

  $sSQL = "select categories_id, naam, parent from categories";
  $sCatID = get_param("categories_id");

//-------------------------------
// tree BeforeShow Event begin
// tree BeforeShow Event end
//-------------------------------
  if(!strlen($sCatID) || !is_number($sCatID))
  {
//-------------------------------
// Root category
//-------------------------------
    $sWhere = " WHERE parent IS NULL OR parent=0";
    $tpl->set_var("CurrentCategory", "");
    $tpl->set_var("CatPath", "");
  }
  else
  {
//-------------------------------
// Subcategory
//-------------------------------
    $sWhere = " where categories_id=" . $sCatID;
    $db->query($sSQL . $sWhere);
    $db->next_record();
    $tpl->set_var("CurrentCategory", " > " . tohtml($db->f("naam")));
    $sParCatID = tohtml($db->f("parent"));
//-------------------------------
// Build Path
//-------------------------------
    if($sParCatID == "") $tpl->set_var("CatPath", "");
    $sPath = "";
    while($sParCatID != "")
    {
      $db->query($sSQL . " where categories_id=" . $sParCatID);
      if($db->next_record())
      {
        $sParCatID = tohtml($db->f("parent"));
        $sPath = str_replace("{Category}", tohtml($db->f("naam")) . $sPath,str_replace("{CategoryID}", tohtml($db->f("categories_id")),$tpl->GetVar("CatPath")));
      }
      else
        break;
    }
    $tpl->DBlocks["CatPath"] = $sPath;
    $tpl->parse("CatPath", false);
    $sWhere = " where parent=" . $sCatID;
  }
//-------------------------------

//-------------------------------
// Categories list
//-------------------------------
  $db->query($sSQL . $sWhere);
  if($db->next_record())
  {
//-------------------------------
// Print subcategories
//-------------------------------
    do
    {
      $tpl->set_var("CategoryID", tohtml($db->f("categories_id")));
      $tpl->set_var("Category", tohtml($db->f("naam")));
//-------------------------------
// tree ShowCategory Event begin
// tree ShowCategory Event end
//-------------------------------
      $tpl->parse("CategoryList", true);
    } while ($db->next_record());
  }
  else
  {
//-------------------------------
// No subcategories
//-------------------------------
    $tpl->set_var("CategoryList", "");
    $tpl->parse("Formtree", false);
    return;
  }
//-------------------------------

  $tpl->parse("Formtree", false);
//-------------------------------
// tree Show end
//-------------------------------

//-------------------------------
// tree Close Event begin
// tree Close Event end
//-------------------------------
}


//===============================
// Display Menu Form
//-------------------------------
function titel_show()
{
  global $tpl;
  global $db;
  $sFormTitle = "Pagina beheer";

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
function pagina_action($sAction)
{
//-------------------------------
// Initialize variables  
//-------------------------------
  global $db;
  global $tpl;
  global $sForm;
  global $spaginaErr;
  $bExecSQL = true;
  $sActionFileName = "";
  $sWhere = "";
  $bErr = false;
  $pPKcategories_id = "";
  $fldnaam = "";
  $fldnaam_uk = "";
  $fldparent = "";
  $fldbloktekst = "";
  $fldbrochure = "";
  $fldveiligheidsblad = "";
//-------------------------------

//-------------------------------
// pagina Action begin
//-------------------------------
  $sActionFileName = "pagina.php";

//-------------------------------
// CANCEL action
//-------------------------------
  if($sAction == "cancel")
  {

//-------------------------------
// pagina BeforeCancel Event begin
// pagina BeforeCancel Event end
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
    $pPKcategories_id = get_param("PK_categories_id");
    if( !strlen($pPKcategories_id)) return;
    $sWhere = "categories_id=" . tosql($pPKcategories_id, "Number");
  }
//-------------------------------


//-------------------------------
// Load all form fields into variables
//-------------------------------
  $fldcategories_id = get_param("Rqd_categories_id");
  $fldnaam = get_param("naam");
  $fldnaam_uk = get_param("naam_uk");
  $fldparent = get_param("parent");
  $fldbloktekst = get_param("bloktekst");
  $fldbrochure = get_param("brochure");
  $fldveiligheidsblad = get_param("veiligheidsblad");

//-------------------------------
// Validate fields
//-------------------------------
  if($sAction == "insert" || $sAction == "update") 
  {
    if(!strlen($fldnaam))
      $spaginaErr .= "The value in field Menu naam<br><b><font color=blue>Nederlands</font></b> is required.<br>";
    
    if(!is_number($fldparent))
      $spaginaErr .= "The value in field Hoofdpagina is incorrect.<br>";
    
    if(!is_number($fldbloktekst))
      $spaginaErr .= "The value in field Tekstblok is incorrect.<br>";
    
//-------------------------------
// pagina Check Event begin
// pagina Check Event end
//-------------------------------
    if(strlen($spaginaErr)) return;
  }
//-------------------------------


//-------------------------------
// Create SQL statement
//-------------------------------
  switch(strtolower($sAction)) 
  {
    case "insert":
//-------------------------------
// pagina Insert Event begin
// pagina Insert Event end
//-------------------------------
        $sSQL = "insert into categories (" . 
          "categories_id," . 
          "naam," . 
          "naam_uk," . 
          "parent," . 
          "bloktekst," . 
          "brochure," . 
          "veiligheidsblad)" . 
          " values (" . 
          tosql($fldcategories_id, "Number") . "," . 
          tosql($fldnaam, "Text") . "," . 
          tosql($fldnaam_uk, "Text") . "," . 
          tosql($fldparent, "Number") . "," . 
          tosql($fldbloktekst, "Number") . "," . 
          tosql($fldbrochure, "Text") . "," . 
          tosql($fldveiligheidsblad, "Text") . 
          ")";
    break;
    case "update":

//-------------------------------
// pagina Update Event begin
// pagina Update Event end
//-------------------------------
        $sSQL = "update categories set " .
          "naam=" . tosql($fldnaam, "Text") .
          ",naam_uk=" . tosql($fldnaam_uk, "Text") .
          ",parent=" . tosql($fldparent, "Number") .
          ",bloktekst=" . tosql($fldbloktekst, "Number") .
          ",brochure=" . tosql($fldbrochure, "Text") .
          ",veiligheidsblad=" . tosql($fldveiligheidsblad, "Text");
        $sSQL .= " where " . $sWhere;
    break;
    case "delete":
//-------------------------------
// pagina Delete Event begin
// pagina Delete Event end
//-------------------------------
        $sSQL = "delete from categories where " . $sWhere;
    break;
  }
//-------------------------------
//-------------------------------
// pagina BeforeExecute Event begin
// pagina BeforeExecute Event end
//-------------------------------

//-------------------------------
// Execute SQL statement
//-------------------------------
  if(strlen($spaginaErr)) return;
  if($bExecSQL)
    $db->query($sSQL);
  header("Location: " . $sActionFileName);
  exit;
//-------------------------------
// pagina Action end
//-------------------------------
}

//===============================
// Display Record Form
//-------------------------------
function pagina_show()
{
  global $db;
  global $tpl;
  global $sAction;
  global $sForm;
  global $spaginaErr;
  
  $fldcategories_id = "";
  $fldnaam = "";
  $fldnaam_uk = "";
  $fldparent = "";
  $fldbloktekst = "";
  $fldbrochure = "";
  $fldveiligheidsblad = "";
//-------------------------------
// pagina Show begin
//-------------------------------
  $sFormTitle = "1. Pagina {naam} beheer";
  $sWhere = "";
  $bPK = true;
  $sparentDisplayValue = "";
  $sbloktekstDisplayValue = "";
  $sbrochureDisplayValue = "";
  $sveiligheidsbladDisplayValue = "";
//-------------------------------
// Load primary key and form parameters
//-------------------------------
  if($spaginaErr == "")
  {
    $fldcategories_id = get_param("categories_id");
    $tpl->set_var("Rqd_categories_id", get_param("categories_id"));
    $pcategories_id = get_param("categories_id");
    $tpl->set_var("paginaError", "");
  }
  else
  {
    $fldcategories_id = strip(get_param("categories_id"));
    $fldnaam = strip(get_param("naam"));
    $fldnaam_uk = strip(get_param("naam_uk"));
    $fldparent = strip(get_param("parent"));
    $fldbloktekst = strip(get_param("bloktekst"));
    $fldbrochure = strip(get_param("brochure"));
    $fldveiligheidsblad = strip(get_param("veiligheidsblad"));
    $pcategories_id = get_param("PK_categories_id");
    $tpl->set_var("spaginaErr", $spaginaErr);
    $tpl->set_var("FormTitle", $sFormTitle);
    $tpl->parse("paginaError", false);
  }
//-------------------------------

//-------------------------------
// Load all form fields

//-------------------------------

//-------------------------------
// Build WHERE statement
//-------------------------------
  
  if( !strlen($pcategories_id)) $bPK = false;
  
  $sWhere .= "categories_id=" . tosql($pcategories_id, "Number");
  $tpl->set_var("PK_categories_id", $pcategories_id);
//-------------------------------
//-------------------------------
// pagina Open Event begin
// pagina Open Event end
//-------------------------------

  $tpl->set_var("FormTitle", $sFormTitle);

//-------------------------------
// Build SQL statement and execute query
//-------------------------------
  $sSQL = "select * from categories where " . $sWhere;
  // Execute SQL statement
  $db->query($sSQL);
  $bIsUpdateMode = ($bPK && !($sAction == "insert" && $sForm == "pagina") && $db->next_record());
//-------------------------------

//-------------------------------
// Load all fields into variables from recordset or input parameters
//-------------------------------
  if($bIsUpdateMode)
  {
    $fldcategories_id = $db->f("categories_id");
//-------------------------------
// Load data from recordset when form displayed first time
//-------------------------------
    if($spaginaErr == "") 
    {
      $fldnaam = $db->f("naam");
      $fldnaam_uk = $db->f("naam_uk");
      $fldparent = $db->f("parent");
      $fldbloktekst = $db->f("bloktekst");
      $fldbrochure = $db->f("brochure");
      $fldveiligheidsblad = $db->f("veiligheidsblad");
    }
    $tpl->set_var("paginaInsert", "");
    $tpl->parse("paginaEdit", false);
//-------------------------------
// pagina ShowEdit Event begin
// pagina ShowEdit Event end
//-------------------------------
  }
  else
  {
    if($spaginaErr == "")
    {
      $fldcategories_id = tohtml(get_param("categories_id"));
    }
    $tpl->set_var("paginaEdit", "");
    $tpl->parse("paginaInsert", false);
//-------------------------------
// pagina ShowInsert Event begin
// pagina ShowInsert Event end
//-------------------------------
  }
  $tpl->parse("paginaCancel", false);
//-------------------------------
// pagina Show Event begin
// pagina Show Event end
//-------------------------------

//-------------------------------
// Show form field
//-------------------------------
    $tpl->set_var("categories_id", tohtml($fldcategories_id));
    $tpl->set_var("naam", tohtml($fldnaam));
    $tpl->set_var("naam_uk", tohtml($fldnaam_uk));
    $tpl->set_var("paginaLBparent", "");
    $tpl->set_var("ID", "0");
    $tpl->set_var("Value", $sparentDisplayValue);
    $tpl->set_var("Selected", "");
    $tpl->parse("paginaLBparent", true);
    $lookup_parent = db_fill_array("select categories_id, naam from categories order by 2");

    if(is_array($lookup_parent))
    {
      reset($lookup_parent);
      while(list($key, $value) = each($lookup_parent))
      {
        $tpl->set_var("ID", $key);
        $tpl->set_var("Value", $value);
        if($key == $fldparent)
          $tpl->set_var("Selected", "SELECTED" );
        else 
          $tpl->set_var("Selected", "");
        $tpl->parse("paginaLBparent", true);
      }
    }
    
    $tpl->set_var("paginaLBbloktekst", "");
    $tpl->set_var("ID", "0");
    $tpl->set_var("Value", $sbloktekstDisplayValue);
    $tpl->set_var("Selected", "");
    $tpl->parse("paginaLBbloktekst", true);
    $lookup_bloktekst = db_fill_array("SELECT *  FROM `teksten`  WHERE type = 1");

    if(is_array($lookup_bloktekst))
    {
      reset($lookup_bloktekst);
      while(list($key, $value) = each($lookup_bloktekst))
      {
        $tpl->set_var("ID", $key);
        $tpl->set_var("Value", $value);
        if($key == $fldbloktekst)
          $tpl->set_var("Selected", "SELECTED" );
        else 
          $tpl->set_var("Selected", "");
        $tpl->parse("paginaLBbloktekst", true);
      }
    }
    
    $tpl->set_var("paginaLBbrochure", "");
    $tpl->set_var("ID", "0");
    $tpl->set_var("Value", $sbrochureDisplayValue);
    $tpl->set_var("Selected", "");
    $tpl->parse("paginaLBbrochure", true);
    $lookup_brochure = db_fill_array("SELECT *  FROM `items`  WHERE description = 2");

    if(is_array($lookup_brochure))
    {
      reset($lookup_brochure);
      while(list($key, $value) = each($lookup_brochure))
      {
        $tpl->set_var("ID", $key);
        $tpl->set_var("Value", $value);
        if($key == $fldbrochure)
          $tpl->set_var("Selected", "SELECTED" );
        else 
          $tpl->set_var("Selected", "");
        $tpl->parse("paginaLBbrochure", true);
      }
    }
    
    $tpl->set_var("paginaLBveiligheidsblad", "");
    $tpl->set_var("ID", "0");
    $tpl->set_var("Value", $sveiligheidsbladDisplayValue);
    $tpl->set_var("Selected", "");
    $tpl->parse("paginaLBveiligheidsblad", true);
    $lookup_veiligheidsblad = db_fill_array("SELECT *  FROM `items`  WHERE description = 3");

    if(is_array($lookup_veiligheidsblad))
    {
      reset($lookup_veiligheidsblad);
      while(list($key, $value) = each($lookup_veiligheidsblad))
      {
        $tpl->set_var("ID", $key);
        $tpl->set_var("Value", $value);
        if($key == $fldveiligheidsblad)
          $tpl->set_var("Selected", "SELECTED" );
        else 
          $tpl->set_var("Selected", "");
        $tpl->parse("paginaLBveiligheidsblad", true);
      }
    }
    
  $tpl->parse("Formpagina", false);

//-------------------------------
// pagina Close Event begin
// pagina Close Event end
//-------------------------------

//-------------------------------
// pagina Show end
//-------------------------------
}
//===============================

//===============================
// Display Grid Form
//-------------------------------
function teksten_show()
{
//-------------------------------
// Initialize variables  
//-------------------------------
  
  global $tpl;
  global $db;
  global $stekstenErr;
  $sWhere = "";
  $sOrder = "";
  $sSQL = "";
  $sFormTitle = "2. Tekst op pagina {naam}";
  $HasParam = false;
  $bReq = true;
  $iRecordsPerPage = 19;
  $iCounter = 0;
  $iPage = 0;
  $bEof = false;
  $iSort = "";
  $iSorted = "";
  $sDirection = "";
  $sSortParams = "";
  $sActionFileName = "paginatekst2.php";


  $tpl->set_var("TransitParams", "categories_id=" . tourl(get_param("categories_id")) . "&");
  $tpl->set_var("FormParams", "categories_id=" . tourl(get_param("categories_id")) . "&");
  
//-------------------------------
// Build WHERE statement
//-------------------------------
  $pcategories_id = get_param("categories_id");
  if(is_number($pcategories_id) && strlen($pcategories_id))
    $pcategories_id = tosql($pcategories_id, "Number");
  else 
    $pcategories_id = "";

  if(strlen($pcategories_id))
  {
    $HasParam = true;
    $sWhere = $sWhere . "t.categories_id=" . $pcategories_id;
  }
  else
  {
    $bReq = false;
  }


  if($HasParam)
    $sWhere = " AND (" . $sWhere . ")";

//-------------------------------
// Build ORDER BY statement
//-------------------------------
  $iSort = get_param("Formteksten_Sorting");
  $iSorted = get_param("Formteksten_Sorted");
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
      $sSortParams = "Formteksten_Sorting=" . $iSort . "&Formteksten_Sorted=" . $iSort . "&";
    }
    else
    {
      $tpl->set_var("Form_Sorting", $iSort);
      $sDirection = " ASC";
      $sSortParams = "Formteksten_Sorting=" . $iSort . "&Formteksten_Sorted=" . "&";
    }
    if ($iSort == 1) $sOrder = " order by t1.naam" . $sDirection;
  }

//-------------------------------
// Build base SQL statement
//-------------------------------
  $sSQL = "select t.categories_id as t_categories_id, " . 
    "t.tekst_combi_id as t_tekst_combi_id, " . 
    "t.tekst_id as t_tekst_id, " . 
    "t1.tekst_id as t1_tekst_id, " . 
    "t1.naam as t1_naam " . 
    " from tekst_combi t, teksten t1" . 
    " where t1.tekst_id=t.tekst_id  ";
//-------------------------------

//-------------------------------
// teksten Open Event begin
// teksten Open Event end
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
// Process if form has all required parameter
//-------------------------------
  if(!$bReq)
  {
    $tpl->set_var("DListteksten", "");
    $tpl->parse("tekstenNoRecords", false);
    $tpl->set_var("tekstenNavigator", "");
    $tpl->parse("Formteksten", false);
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
    $tpl->set_var("DListteksten", "");
    $tpl->parse("tekstenNoRecords", false);
    $tpl->set_var("tekstenNavigator", "");
    $tpl->parse("Formteksten", false);
    return;
  }
//-------------------------------

//-------------------------------
// Initialize page counter and records per page
//-------------------------------
  $iRecordsPerPage = 19;
  $iCounter = 0;
//-------------------------------

//-------------------------------
// Process page scroller
//-------------------------------
  $iPage = get_param("Formteksten_Page");
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
    $fldedit_URLLink = "paginatekst.php";
    $fldedit_tekst_id = $db->f("t_tekst_id");
    $fldedit_categories_id = $db->f("t_categories_id");
    $fldcategories_id = $db->f("t_categories_id");
    $fldtekst_combi_id = $db->f("t_tekst_combi_id");
    $fldtekst_id = $db->f("t1_naam");
    $next_record = $db->next_record();
    
//-------------------------------
// teksten Show begin
//-------------------------------

//-------------------------------
// teksten Show Event begin
$fldedit="<img border=0 src=files/ed.gif alt=Aanpassen>";
// teksten Show Event end
//-------------------------------

//-------------------------------
// Replace Template fields with database values
//-------------------------------
    
    $tpl->set_var("tekst_combi_id", tohtml($fldtekst_combi_id));
    $tpl->set_var("categories_id", tohtml($fldcategories_id));
      $tpl->set_var("tekst_id", tohtml($fldtekst_id));
      $tpl->set_var("edit", $fldedit);
      $tpl->set_var("edit_URLLink", $fldedit_URLLink);
      $tpl->set_var("Prmedit_tekst_id", urlencode($fldedit_tekst_id));
      $tpl->set_var("Prmedit_categories_id", urlencode($fldedit_categories_id));
    $tpl->parse("DListteksten", true);
//-------------------------------
// teksten Show end
//-------------------------------

//-------------------------------
// Move to the next record and increase record counter
//-------------------------------
    
    $iCounter++;
  }

  // teksten Navigation begin
  $bEof = $next_record;
  // Parse Navigator
  if(!$bEof && $iPage == 1)
    $tpl->set_var("tekstenNavigator", "");
  else 
  {
    if(!$bEof)
      $tpl->set_var("tekstenNavigatorLastPage", "_");
    else
      $tpl->set_var("NextPage", ($iPage + 1));
    if($iPage == 1)
      $tpl->set_var("tekstenNavigatorFirstPage", "_");
    else
      $tpl->set_var("PrevPage", ($iPage - 1));
    $tpl->set_var("tekstenCurrentPage", $iPage);
    $tpl->parse( "tekstenNavigator", false);
  }

//-------------------------------
// teksten Navigation end
//-------------------------------

//-------------------------------
// Finish form processing
//-------------------------------
  $tpl->set_var( "tekstenNoRecords", "");
  $tpl->parse( "Formteksten", false);
//-------------------------------
// teksten Close Event begin
// teksten Close Event end
//-------------------------------
}
//===============================

?>