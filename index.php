<?php

include_once "prepend.inc";
include_once OPENHR_LIB."/Database.php";
include_once OPENHR_LIB."/Category.php";
include_once "menu.inc";

$_PEAR_default_error_mode=PEAR_ERROR_TRIGGER;
PEAR::setErrorHandling(PEAR_ERROR_DIE);
$page=&Page::singleton("categories");
$page->fetchSlots("categories");
$page->setSlot('menuleft',    menuleft());
$page->setSlot('menutop',     menutop());
$page->setSlot('menufoot',    sprintf(_("Copyright (c) 2003 %s"),"<a href=\"?content=carsten\">Carsten Bleek</a>"));

$template_dir="categories/";

$page->setSlot("content",$smarty->fetch($template_dir.'index.tpl'));
$page->toHtml(array("template"=>$template_dir.'generic.tpl'));
?>
