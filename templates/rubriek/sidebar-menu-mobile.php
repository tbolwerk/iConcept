<?php
$server = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
require_once $server . '/iConcept/templates/functions.php';
$statement = $dbh->query("SELECT * FROM Rubriek");
while($row = $statement->fetch()){
  $rows[] = (array('id' => $row['rubrieknummer'],'parent_id' => $row['rubrieknummerOuder'],'name' => $row['rubrieknaam']));
}




              // covert raw result set to tree
              $menu = convertAdjacencyListToTree('-1',$rows,'id','parent_id','links');
              // echo '<pre>',print_r($menu),'</pre>';

echo '              <div class="w3-sidebar w3-bar-block w3-animate-left " style="display:none;z-index:1031" id="mySidebar">
                <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>'.themeMenuMobile($menu,1).
                '              </div>
                              <div class="w3-overlay w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>';

function themeMenuMobile($menu,$runner) {

    $out = '';

    if(empty($menu)) {
        return $out;
    }



    foreach($menu as $link) {

      $out.= sprintf(
          '<li class="depth-%u">%s%s</li>'
          ,$runner
          ,'<button class="w3-button w3-block w3-left-align" onclick="myAccFunc()">
          '.$link['name'].' <i class="fa fa-caret-down"></i>
          </button>'
          ,'<a href="rubriek.php?rubrieknummer='.$link["id"].'" class="w3-bar-item w3-button">'.themeMenuMobile($link['links'],($runner+1)).'</a>'
      );
    }

    return $out;

}
?>
