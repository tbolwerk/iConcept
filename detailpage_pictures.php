<?php
if (isset($_GET['id'])) {
  $statement = $dbh->prepare("select * from Bestand where voorwerpnummer = ? order by filenaam");
  $statement->execute(array($_GET['id']));
  $bestanden = $statement->fetchAll();
}

$pictures = array();
$picturesIndex = 0;
foreach ($bestanden as $bestand) {
  $pictures[$picturesIndex] = $bestand;
  $picturesIndex++;
}

function generatePictureSelector($pictures){
  $pictureId = 0;
  foreach ($pictures as $picture) {
    echo "


        <div class='pictureFrame' onclick='updatePicture({$pictureId})'>
          <img src=\"{$picture['filenaam']}\"></img>
        </div>




    ";
    $pictureId++;
  }
}

?>




<script>
var pictures = <?php echo json_encode($pictures); ?>;
function updatePicture(pictureId){
  
  document.getElementById("active-picture").innerHTML = "<div class='pictureFrame'><img height='100%' src='" + pictures[pictureId].filenaam + "'></img></div>"
}

window.onresize = updatePictureStyle;

function updatePictureStyle(){

}
</script>
