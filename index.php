<?php

include_once "prepend.inc";
include_once OPENHR_LIB."/Database.php";
include_once OPENHR_LIB."/Category.php";
include_once "menu.inc";

$_PEAR_default_error_mode=PEAR_ERROR_TRIGGER;
PEAR::setErrorHandling(PEAR_ERROR_DIE);
$page=&Page::singleton("categories");
Page::fetchSlots("categories");
Page::setSlot('menuleft',    menuleft());
Page::setSlot('menutop',     menutop());
Page::setSlot('menufoot',    sprintf(_("Copyright (c) 2003 %s"),"<a href=\"?content=carsten\">Carsten Bleek</a>"));

$template_dir="categories/";


$smarty->assign("content",$template_dir."index.tpl");
$smarty->assign("page",Page::getSlots());
$smarty->display($template_dir.'generic.tpl');
?>
