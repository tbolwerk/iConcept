<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/iConcept/templates/functions.php';






function getRows(){
  global $dbh;





try{
$statement = $dbh->query("SELECT *,
       OrderCount = (SELECT COUNT(r2.rubrieknummerOuder) FROM Rubriek r2 WHERE r2.rubrieknummerOuder = r1.rubrieknummer group by rubrieknummerOuder)
  FROM Rubriek r1 ");
}catch(PDOException $e){

}
while($row = $statement->fetch()){

$rows[] = (array('id' => $row['rubrieknummer'],'parent_id' => $row['rubrieknummerOuder'],'name' => $row['rubrieknaam'],'countChild' => $row['OrderCount']));

}

return $rows;
}
$rows = getRows();






              // covert raw result set to tree
              $menu = convertAdjacencyListToTree('-1',$rows,'id','parent_id','links');
              // echo '<pre>',print_r($menu),'</pre>';

              // display menu

              echo '          <div class="offcanvas flypanels-left">
                              <div class="panelcontent" data-panel="treemenu">
                              <a href="rubriek.php"><h1 class="text-center black-text">Rubrieken</h1></a>
                                <nav class="flypanels-treemenu" role="navigation">'.themeMenu($menu,1).
                                '    </nav>
                                  </div>
                                </div>';



              /*
              * Theme menu
              *
              * @param array menu
              * @param runner (depth)
              * @return str themed menu
              */



              function themeMenu($menu,$runner) {

                  $out = '';

                  if(empty($menu)) {
                      return $out;
                  }


                  $out.='<ul>';
                  foreach($menu as $link) {

                      $out.= sprintf(
                          '<li class="depth-%u">%s%s</li>'
                          ,$runner
                          ,'<li class="haschildren"><div class="link"><a href="?rubrieknummer='.$link["id"].'" class="link" style="text-align: center;">'.$link["name"].'</a><a class="expand">'.$link["countChild"].'<i class="fa icon"></i></a></div>'
                          ,themeMenu($link['links'],($runner+1))
                      );
                  }

                  $out.='</ul>';
                  return $out;

              }







              // echo 'this is working';
              // print_r($rows);


?>
