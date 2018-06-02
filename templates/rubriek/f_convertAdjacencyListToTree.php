<?php
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
?>
