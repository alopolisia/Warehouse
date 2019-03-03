<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}

?>

<?php
 // Auto suggetion
    $html = '';
   if(isset($_POST['product_name']) && strlen($_POST['product_name']))
   {
     $products = find_product_by_title($_POST['product_name']);
     if($products){
        foreach ($products as $product):
           $html .= "<li class=\"list-group-item\">";
           $html .= $product['name'];
           $html .= "</li>";
         endforeach;
      } else {

        $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
        $html .= 'No encontrado';
        $html .= "</li>";

      }

      echo json_encode($html);
   }

   $_SESSION['cliente'] = "Pancho Lopez Villa";
   if (isset($_POST['client-name']) && strlen($_POST['p_name'])) {
       // code...
       $_SESSION['cliente'] .= $_POST['client-name'];
   }
?>

 <?php
 $iva = 0.16;
 $bo = 0;
 $mensaje = '';
 $s0 = "s_id";
 $s1 = "price";
 $s2 = "quantity";
 $s3 = "iva";
 $s4 = "total";
 $_SESSION['saber_cual'] = 0;
 // find all product
  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $product_title = remove_junk($db->escape($_POST['p_name']));

    if($results = find_all_product_info_by_title($product_title)){
        if (empty($_SESSION['num'])) {
            $_SESSION['num'] = 1;
        }

        foreach ($results as $result) {

          $html .= "<tr>";

          $html .= "<td id=\"s_name\">".$result['name']."</td>";
          $html .= "<input type=\"hidden\" name=\"{$s0}{$_SESSION['num']}\" value=\"{$result['id']}\">";
          $html .= "<input type=\"hidden\" name=\"comodin\" value=\"{$_SESSION['num']}\">";
          $html  .= "<td>";
          //$html  .= "<input type=\"text\" class=\"form-control\" name=\"{$s1}{$_SESSION['num']}\"value=\"{$result['sale_price']}\">";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"{$s1}{$_SESSION['num']}\"value=\"{$result['sale_price']}\">";
          $html  .= "</td>";

          $html .= "<td id=\"s_qty\">";
          $html .= "<input type=\"text\" class=\"form-control\" name=\"{$s2}{$_SESSION['num']}\" value=\"1\">";
          $html  .= "</td>";

          $html .= "<td id=\"s_iva\">";
          $html .= "<input type=\"text\" class=\"form-control\" name=\"{$s3}{$_SESSION['num']}\" value=\"{$iva}\" readonly>";
          $html  .= "</td>";

          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"{$s4}{$_SESSION['num']}\" value=\"{$result['sale_price']}\">";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\">";
          $html  .= "</td>";
          $html  .= "</tr>";

        }

        if (empty($_SESSION['productos'])) {
            $_SESSION['productos'] = array();
            $_SESSION['cont'] = 0;
            $_SESSION['productos'][$_SESSION['cont']] = array('nombre' => $product_title, 'contenido' => $html);
            $_SESSION['cont'] += 1;
            $_SESSION['num'] += 1;

            $mensaje .= $_SESSION['productos'][0]['contenido'];
        } else {
            //$_SESSION['bo'] = 0;
            for ($i=0; $i <count($_SESSION['productos']) ; $i++) {
                if (in_array($product_title, $_SESSION['productos'][$i])) {
                    $bo = 1;
                    $_SESSION['saber_cual'] = $i;
                    //$_SESSION['bo'] = 1;
                    break;
                }
            }

            if ($bo == 0) {
                $_SESSION['productos'][$_SESSION['cont']] = array('nombre' => $product_title, 'contenido' => $html);
                $_SESSION['cont'] += 1;
                $_SESSION['num'] += 1;
            } else {
                $m1 = $_SESSION['productos'][$_SESSION['saber_cual']]['contenido'];
                $pos = strpos($m1, "$s2", 1);
                $m2 = substr($m1, $pos,10)."<br>";
            }

            for ($i=0; $i <count($_SESSION['productos']) ; $i++) {
                $mensaje .= $_SESSION['productos'][$i]['contenido'];
            }

        }


    } else {
        $html ='<tr><td>El producto no se encuentra registrado en la base de datos</td></tr>';
    }

    if ($_SESSION['cont'] > 0) {
        $mensaje  .= "<td = colspan = 3>";
        $mensaje .= "Total: <input type = text name = total value = 0 readonly></input>";
        $mensaje  .= "</td>";

        $mensaje  .= "<td = colspan = 3>";
        $mensaje .= "<button type=submit name=add_sale class=btn-btn-primary>Agregar</button>";
        $mensaje  .= "</td>";
    }

    echo json_encode($mensaje);

  }
 ?>
