<?php

require_once( 'HTML/TreeMenu.php' );

function menuleft(){

    $nodeProperties = array("text"=>_("Home"),"link"=> "/", "icon"=>"icons/home.gif");
    $pgmenu       = new HTML_TreeMenu();
    $menuTop      = new HTML_TreeNode($nodeProperties);

    $pgmenu->addItem($menuTop);
    $nx = &$menuTop->addItem(new HTML_TreeNode(array("text" =>_("Categories"), "link" =>'/categories')));



    $nx->addItem(new HTML_TreeNode(array("text" =>_("Languages"), "link" =>'request.php?category=language')));
    $nx->addItem(new HTML_TreeNode(array("text"=>_("Regions"), "link"=>'request.php?category=continent')));
    $nx->addItem(new HTML_TreeNode(array("text"=>_("Professions"), "link"=>'')));
    $nx->addItem(new HTML_TreeNode(array("text"=>_("Industries"), "link"=>'')));
    $nx->addItem(new HTML_TreeNode(array("text"=>_("Field of Study"), "link"=>'')));

    $pgmenuTree = &new HTML_TreeMenu_DHTML($pgmenu,
                                      array('images'       => '/jobs/images/TreeMenu',
                                            'defaultClass' => 'smalltext',
                                            'target'       => "_main" ,
                                            'expanded'     => true));
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