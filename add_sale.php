<?php
  $page_title = 'Agregar venta';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
   $all_clients = find_all('client');
   if(isset($_SESSION['productos'])) {
        unset($_SESSION['productos']);
   }

   if(isset($_SESSION['num'])) {
        unset($_SESSION['num']);
   }
?>
<?php

  if(isset($_POST['add_sale'])){
    $req_fields = array('s_id','quantity','price','total', 'date' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$_POST['s_id']);
          $s_qty     = $db->escape((int)$_POST['quantity']);
          $s_total   = $db->escape($_POST['total']);
          $date      = $db->escape($_POST['date']);
          $s_date    = make_date();

          $sql  = "INSERT INTO sales (";
          $sql .= " product_id,qty,price,date";
          $sql .= ") VALUES (";
          $sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";
          $sql .= ")";

                if($db->query($sql)){
                  update_product_qty($s_qty,$p_id);
                  $session->msg('s',"Venta agregada ");
                  redirect('add_sale.php', false);
                } else {
                  $session->msg('d','Lo siento, registro falló.');
                  redirect('add_sale.php', false);
                }
        } else {
           $session->msg("d", $errors);
           redirect('add_sale.php',false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                  <label for="qty">Nombre del Cliente</label>
                  <select class="buscador" name="client-name">
                    <option value="">Seleccione un cliente</option>
                  <?php  foreach ($all_clients as $client): ?>
                    <option value="<?php echo (int)$client['name'] ?>">
                      <?php echo $client['name'] ?></option>
                  <?php endforeach; ?>
                  </select>
                </div>
            </div>

            <br>

            <label for="qty">Nombre del Producto</label>
            <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Búsqueda</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Buscar por el nombre del producto">
            </div>
            <div id="result" class="list-group"></div>

        </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Editar venta</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php">
         <table class="table table-bordered">
           <thead>
            <th> Producto </th>
            <th> Precio </th>
            <th> Cantidad </th>
            <th> IVA </th>
            <th> Subtotal </th>
            <th> Agregado</th>

           </thead>
             <tbody  id="product_info"> </tbody>
         </table>
         <div class="">

         </div>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
<link rel="stylesheet" type="text/css" href="css/select2.css">
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
