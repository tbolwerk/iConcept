<br><br><br><br><br>

<?php
$current_page='new_auction';
require_once('templates/header.php');

$errors;
$errors = array();

function generateCategoryOptions($results){
  $options;
  for ($i = 0; $i < count($results); $i++) {
    if($results[$i]['rubrieknummerOuder'] == -1){
      $options .= "<option value='" . $results[$i]['rubrieknummer'] . "'>" . $results[$i]['rubrieknaam'] . "</option>";
    }
  }
  return $options;
}

try {
  $data = $dbh->prepare("select * from Rubriek order by volgnummer");
  $data->execute();
  $i = 0;
  while ($row = $data->fetch()) {
    $results[$i]['rubrieknaam'] = $row['rubrieknaam'];
    $results[$i]['rubrieknummer'] = $row['rubrieknummer'];
    $results[$i]['rubrieknummerOuder'] = $row['rubrieknummerOuder'];
    $results[$i]['volgnummer'] = $row['volgnummer'];
    $i++;
  }
} catch (PDOException $e) {
  echo $e;
}
?>

<form action="" method="post" enctype="multipart/form-data">
  <select name='mainCategory' id='mainCategories' onchange="createSubCategorySelect(this.value, results)">
    <?=generateCategoryOptions($results)?>
  </select>
  <div id="subCategoriesDiv"></div>
</form>

<script>


function createSubCategorySelect(categorynumberParent, results){

  var selector = "<select name='subCategories' id='subCategories'>";

  var j = new Array();
  var emptySpace;

  for (j[0] = 0; j[0] < results.length; j[0]++) {
    if(results[j[0]].rubrieknummerOuder == categorynumberParent){
      selector += "<option value='" + results[j[0]].rubrieknummer + "'>" + results[j[0]].rubrieknaam + "</option>";

      for (var k = 1; k < results.length; k++){
        emptySpace += "<pre>&emsp;</pre>";

        for (j[k] = 0; j[k] < results.length; j[k]++){
          if(results[j[k]].rubrieknummerOuder == results[j[k-1]].rubrieknummer){
            selector += "<option value='" + results[j[k]].rubrieknummer + "'>" + emptySpace + results[j[k]].rubrieknaam + "</option>";
          }
        }

      }


        // for (j[0] = 0; j[0] < results.length; j[0]++){
        //   if(results[j[0]].rubrieknummerOuder == results[i].rubrieknummer){
        //     selector += "<option value='" + results[j[0]].rubrieknummer + "'><pre>&emsp;</pre>" + results[j[0]].rubrieknaam + "</option>";
        //
        //     // for (j[1] = 0; j[1] < results.length; j[1]++){
        //     //   if(results[j[1]].rubrieknummerOuder == results[j[0]].rubrieknummer){
        //     //     selector += "<option value='" + results[j[1]].rubrieknummer + "'><pre>&emsp;&emsp;</pre>" + results[j[1]].rubrieknaam + "</option>";
        //     //   }
        //     // }
        //   }
        // }

    }
  }
  selector += "</select>";
  document.getElementById('subCategoriesDiv').innerHTML = selector;
}

// function onChangee(results){
//   var kees = document.getElementById("-1").value;
//   document.getElementById('hai').innerHTML = createCategorySelect(0, results);
// }

var results = <?php echo json_encode($results); ?>;

// var selector = "<select name='category'>";

// for (var i = 0; i < results.length; i++) {
//   if(results[i].rubrieknummerOuder == -1){
//     selector += "<option value='" + results[i].rubrieknummer + "'>" + results[i].rubrieknaam + "</option>";
//   }
// }
// selector += "</select>";


// document.getElementById('mainCategories').onchange = createSubCategorySelect(-1, results);
</script>
