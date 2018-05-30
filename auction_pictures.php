<?php
$current_page='detailpage';
require_once('templates/header.php');

if (isset($_GET['id'])) {
  $statement = $dbh->prepare("select * from Bestand where voorwerpnummer = ? order by filenaam");
  $statement->execute(array($_GET['id']));
  $bestanden = $statement->fetchAll();
}
?>

<style>
.pictureFrame {
  position: relative;
  height: 0;
  width: 100%;
  padding-top: calc(56.25%);
  border-style: solid;
  border-width: 0px;
  border-color: #bebebe;
}

.pictureFrame img {
  position: absolute;
  margin: auto;
  padding: 5px;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  max-height: 100%;
  max-width: 100%;
}
</style>

<?php
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
        <div class='pictureFrame' onclick='updatePicture({$pictureId})'>
          <img src=\"{$picture['filenaam']}\"></img>
        </div>



    ";
    $pictureId++;
  }
}

?>

<div style="margin-top:100px;">
<div id="active-picture" style="width: 80%; float: left;">
  <div class='pictureFrame'>
    <img height="100%" src="<?=$pictures[0]['filenaam']?>"></img>
  </div>
</div>
<div style="width: 20%; float: right;">
  <?=generatePictureSelector($pictures)?>
</div>
</div>
<div style="clear: both;"></div>





<script>
var pictures = <?php echo json_encode($pictures); ?>;
function updatePicture(pictureId){
  console.log("hoi");
  document.getElementById("active-picture").innerHTML = "<div class='pictureFrame'><img height='100%' src='" + pictures[pictureId].filenaam + "'></img></div>"
}

window.onresize = updatePictureStyle;

function updatePictureStyle(){

}
</script>

<?php include('templates/footer.php'); ?>
