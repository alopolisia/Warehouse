<?php
  $page_title = 'Agregar cliente';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_photo = find_all('media');
?>
<?php
 if(isset($_POST['add_client'])){
   $req_fields = array('client-name','client-tel','client-email');
   validate_fields($req_fields);
   if(empty($errors)){
     $c_name  = remove_junk($db->escape($_POST['client-name']));
     $c_tel   = remove_junk($db->escape($_POST['client-tel']));
     $c_email   = remove_junk($db->escape($_POST['client-email']));
     if (is_null($_POST['client-photo']) || $_POST['client-photo'] === "") {
       $media_id = '0';
     } else {
       $media_id = remove_junk($db->escape($_POST['client-photo']));
     }
     $date    = make_date();
     $query  = "INSERT INTO client (";
     $query .=" name,tel,email,media_id,date";
     $query .=") VALUES (";
     $query .=" '{$c_name}', '{$c_tel}', '{$c_email}', '{$media_id}', '{$date}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name='{$c_name}'";
     if($db->query($query)){
       $session->msg('s',"Cliente agregado exitosamente. ");
       redirect('add_client.php', false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('client.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_client.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Agregar cliente</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_client.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="client-name" placeholder="Nombre del Cliente">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="buscador" name="client-photo">
                      <option value="">Selecciona una imagen</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-earphone"></i>
                     </span>
                     <input type="text" class="form-control" name="client-tel" placeholder="Telefono">
                  </div>
                 </div>

                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-envelope"></i>
                     </span>
                     <input type="text" class="form-control" name="client-email" placeholder="Correo Electronico">
                  </div>
                 </div>

               </div>
              </div>
              <button type="submit" name="add_client" class="btn btn-danger">Agregar cliente</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
<link rel="stylesheet" type="text/css" href="css/select2.css">
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/select2.js"></script>
<script>
$(document).ready(function() {
    $('.buscador').select2();
});
</script>
<style media="screen">
    select{
        width: 300px;
    }
</style>
