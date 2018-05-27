<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/iConcept/templates/functions.php';

$statement = $dbh->query("SELECT * FROM Rubriek");
while($row = $statement->fetch()){
  $rows[] = (array('id' => $row['rubrieknummer'],'parent_id' => $row['rubrieknummerOuder'],'name' => $row['rubrieknaam']));
}




              // covert raw result set to tree
              $menu = convertAdjacencyListToTree(null,$rows,'id','parent_id','links');
              // echo '<pre>',print_r($menu),'</pre>';

              // display menu
              echo '          <div class="offcanvas flypanels-left">
                              <div class="panelcontent" data-panel="treemenu">
                                <nav class="flypanels-treemenu" role="navigation">'.themeMenu($menu,1).
                                '    </nav>
                                  </div>
                                </div>';

              /*
              * ------------------------------------------------------------------------------------
              * Utility functions
              * ------------------------------------------------------------------------------------
              */

              /*
              * Convert adjacency list to hierarchical tree
              *
              * @param value of root level parent most likely null or 0
              * @param array result
              * @param str name of primary key column
              * @param str name of parent_id column - most likely parent_id
              * @param str name of index that children will reside ie. children, etc
              * @return array tree
              */



              function convertAdjacencyListToTree($intParentId,&$arrRows,$strIdField,$strParentsIdField,$strNameResolution) {

                  $arrChildren = array();

                  for($i=0;$i<count($arrRows);$i++) {
                      if($intParentId === $arrRows[$i][$strParentsIdField]) {
                          $arrChildren = array_merge($arrChildren,array_splice($arrRows,$i--,1));
                      }
                  }

                  $intChildren = count($arrChildren);
                  if($intChildren != 0) {
                      for($i=0;$i<$intChildren;$i++) {
                          $arrChildren[$i][$strNameResolution] = convertAdjacencyListToTree($arrChildren[$i][$strIdField],$arrRows,$strIdField,$strParentsIdField,$strNameResolution);
                      }
                  }

                  return $arrChildren;

              }

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
                          ,'<li class="haschildren"><div class="link"><a href="?rubrieknummer='.$link["id"].'" class="link" style="text-align: center;">'.$link["name"].'</a><a class="expand">'.count($menu).'<i class="fa icon"></i></a></div>'
                          ,themeMenu($link['links'],($runner+1))
                      );
                  }

                  $out.='</ul>';
                  return $out;

              }

              // echo 'this is working';
              // print_r($rows);


?>
