<?php
  $page_title = 'Editar producto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$client = find_by_id('client',(int)$_GET['id']);
$all_photo = find_all('media');
if(!$client){
  $session->msg("d","Missing client id.");
  redirect('client.php');
}
?>
<?php
 if(isset($_POST['client'])){
    $req_fields = array('client-name','client-tel','client-email');
    validate_fields($req_fields);

   if(empty($errors)){
       $c_name  = remove_junk($db->escape($_POST['client-name']));
       $c_tel   = remove_junk($db->escape($_POST['client-tel']));
       $c_email  = remove_junk($db->escape($_POST['client-email']));
       if (is_null($_POST['client-photo']) || $_POST['client-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['client-photo']));
       }
       $query   = "UPDATE client SET";
       $query  .=" name ='{$c_name}', tel ='{$c_tel}',";
       $query  .=" email ='{$c_email}',media_id='{$media_id}'";
       $query  .=" WHERE id ='{$client['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Cliente ha sido actualizado. ");
                 redirect('client.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_client.php?id='.$client['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_client.php?id='.$client['id'], false);
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
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Editar cliente</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_client.php?id=<?php echo (int)$client['id'] ?>">
              <div class="form-group">
                  <label for="qty">Nombre del Cliente</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="client-name" value="<?php echo remove_junk($client['name']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="row">

                  <div class="col-md-6">
                    <label for="qty">Foto del Cliente</label>
                    <select class="form-control" name="client-photo">
                      <option value=""> Sin imagen</option>
                      <?php  foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id'];?>" <?php if($client['media_id'] === $photo['id']): echo "selected"; endif; ?> >
                          <?php echo $photo['file_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Teléfono</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-earphone"></i>
                      </span>
                      <input type="text" class="form-control" name="client-tel" value="<?php echo remove_junk($client['tel']); ?>">
                   </div>
                  </div>
                 </div>

                  <div class="col-md-8">
                   <div class="form-group">
                     <label for="qty">Correo Electrónico</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-envelope"></i>
                       </span>
                       <input type="text" class="form-control" name="client-email" value="<?php echo remove_junk($client['email']);?>">
                    </div>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="client" class="btn btn-danger">Actualizar</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
