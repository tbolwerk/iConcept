<form action="" method="post" enctype="multipart/form-data">
  <label>Titel</label>
  <input type="text" name="title" value="<?php if(isset($_POST['title'])){echo $_POST['title'];}?>"><br>
  <?php if(isset($errors['title'])){echo $errors['title'];}?><br>
  <label>Beschrijving</label>
  <textarea name="description" value=""><?php if(isset($_POST['description'])){echo $_POST['description'];}?></textarea><br>
  <?php if(isset($errors['description'])){echo $errors['description'];}?><br>
  <label>Startprijs</label>
  <input type="text" name="startprice" value="<?php if(isset($_POST['startprice'])){echo $_POST['startprice'];}?>"><br>
  <label>Looptijd</label>
  <select name="duration">
    <option value="1">1 dagen</option>
    <option value="3">3 dagen</option>
    <option value="5">5 dagen</option>
    <option value="7" selected>7 dagen</option>
    <option value="10">10 dagen</option>
  </select><br>
  <label>Betalingswijze</label>
  <input type="radio" name="pay_method" value="contant" checked> Contant
  <input type="radio" name="pay_method" value="bank/giro"> Bank/Giro
  <input type="radio" name="pay_method" value="anders"> Anders<br>
  <label>Betalingsinstructies</label>
  <input type="text" name="pay_instructions"><br>
  <label>Plaats</label>
  <input type="text" name="place"><br>
  <label>Land</label>
  <input type="text" name="country"><br>
  <label>Verzendkosten</label>
  <input type="text" name="shipping_costs"><br>
  <label>Verzendinstructies</label>
  <input type="text" name="shipping_instructions"><br>
  <label>Afbeeldingen</label><br>
  <input name="picture[]" type="file"><br>
	<input name="picture[]" type="file"><br>
	<input name="picture[]" type="file"><br>
	<input name="picture[]" type="file"><br>
  <button type="submit" name="submit">Plaats veiling</button>
</form>
