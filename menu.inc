<?php

require_once( 'HTML/TreeMenu.php' );

function menuleft(){

    $nodeProperties = array("text"=>_("Home"),"link"=> "/", "icon"=>"icons/home.gif");
    $pgmenuTop      = new HTML_TreeNode($nodeProperties);
    $pgmenu         = new HTML_TreeMenu();
    $pgmenu->addItem($pgmenuTop);
    
    $nx = &$pgmenuTop->addItem(new HTML_TreeNode(array("text" =>_("Languages"), "link" =>'?content=language')));
    $nx = &$pgmenuTop->addItem(new HTML_TreeNode(array("text"=>_("Regions"), "link"=>'?content=region')));
    $nx = &$pgmenuTop->addItem(new HTML_TreeNode(array("text"=>_("Professions"), "link"=>'?content=professions')));
    $nx = &$pgmenuTop->addItem(new HTML_TreeNode(array("text"=>_("Industries"), "link"=>'?content=industries')));
    $nx = &$pgmenuTop->addItem(new HTML_TreeNode(array("text"=>_("Field of Study"), "link"=>'?content=fieldOfStudy')));

    $pgmenuTree = &new HTML_TreeMenu_DHTML($pgmenu,
                                      array('images'       => '/jobs/images/TreeMenu',
                                            'defaultClass' => 'smalltext'));
    return $pgmenuTree->toHtml();
}

function menutop(){
    $loma   = &Auth::singleton();
    if ($loma->isLoggedIn()){
        $string="<a href=\"?logout\">"._("Logout")."</a>";
        $string.=" | <a href=\"/edit.php\">"._("Edit")."</a>";
    }else{
        $string="<a href=\"/login.php\">"._("Login")."</a>";
        $string.=" | <a href=\"/register.php\">"._("Logout")."</a>";
    }
    return $string;
}

?>