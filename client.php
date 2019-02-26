<?php
  $page_title = 'Lista de clientes';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $clients = show_client_table();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_client.php" class="btn btn-primary">Agragar cliente</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">ID</th>
                <th> Imagen</th>
                <th> Nombre </th>
                <th class="text-center" style="width: 10%;"> Telefono </th>
                <th class="text-center" style="width: 10%;"> Correo </th>
                <th class="text-center" style="width: 10%;"> Agregado </th>
                <th class="text-center" style="width: 100px;"> Acciones </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($clients as $client):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($client['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $client['image']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($client['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($client['tel']); ?></td>
                <td class="text-center"> <?php echo remove_junk($client['email']); ?></td>
                <td class="text-center"> <?php echo read_date($client['date']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_client.php?id=<?php echo (int)$client['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                     <a href="delete_client.php?id=<?php echo (int)$client['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
