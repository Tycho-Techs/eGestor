<?php require_once('session-lgin.php'); ?>

<?php
require_once 'pdoconfig.php';
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        //echo "Conectado a $dbname em $host com sucesso.";
        } catch (PDOException $pe) {
        die("Não foi possível se conectar ao banco de dados $dbname :" . $pe>getMessage());
        exit();
        }
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="pt-BR" dir="ltr">

<?php require_once('header.php'); ?>


<body>

  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <div class="container" data-layout="container">
      <script>
        var isFluid = JSON.parse(localStorage.getItem('isFluid'));
        if (isFluid) {
          var container = document.querySelector('[data-layout]');
          container.classList.remove('container');
          container.classList.add('container-fluid');
        }
      </script>

      <?php require_once('navbar-vertical.php'); ?>

      <div class="content">
        <?php require_once('navbar-top.php'); ?>

        <!-- ===============================================-->
        <!--    Page-->
        <!-- ===============================================-->
         <?php
            // Create connection
            $conn_egestor = mysqli_connect($host, $username, $password, $dbname);
            // Check connection
            if (!$conn_egestor) {die("Connection failed: " . mysqli_connect_error());}
            $sql = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_xmlNF WHERE cnpj_emit='".$_GET['cnpj_emit']."' and nNF='".$_GET['nNF']."'") or die( mysqli_error($conn_egestor));
            while($dados = mysqli_fetch_assoc($sql)) {
                
                $sql2 = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_Industria WHERE cnpj=".$dados['cnpj_emit']."") or die( mysqli_error($conn_egestor));
                while($industria = mysqli_fetch_assoc($sql2)) {
                    $nome_industria = $industria['nome'];
                    $multiplicador = $industria['multiplicador'];
                }
                 $dtEmi = explode(' ', $dados['data_emissao']);
                 $dtEmi = implode('/', array_reverse(explode('-', $dtEmi[0])));
                 $valorConsi = $dados['valor_produtos'] * $multiplicador;
                 $comissao_sweet = $valorConsi * 0.05;
                
                $sql4 = mysqli_query($conn_egestor, "SELECT DISTINCT xPed FROM eg_cad_xmlProds WHERE chNFe='".$dados['chNFe']."' GROUP BY xPed") or die(mysqli_error($conn_egestor));
                                            while ($sqlprods = mysqli_fetch_assoc($sql4)) {
                                                $xPed = $sqlprods['xPed'];
                                        }
                Echo'
                    <div class="card mb-3">
                        <div class="card-body">
                          <div class="row justify-content-between align-items-center">
                            <div class="col-md">
                              <h5 class="mb-2 mb-md-0">Nota Fiscal #'.$dados['nNF'].'</h5>
                            </div>
                            <div class="col-auto">
                              <button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button"><span class="fas fa-arrow-down me-1"> </span>Download (.pdf)</button>
                              <button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button"><span class="fas fa-print me-1"> </span>Imprimir</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card mb-3">
                        <div class="card-body">
                          <div class="row align-items-center text-center mb-3">
                            <div class="col-sm-6 text-sm-start"><img src="https://app.sweetadm.com.br/egestor/assets/img/logos/nfe.png" alt="invoice" width="150" /><br />Chave de Acesso: '.$dados['chNFe'].'</div>
                            <div class="col text-sm-end mt-3 mt-sm-0">
                              <h2 class="mb-3">Detalhes da NF</h2>
                              <h5>'.$nome_industria.'</h5>
                              <p class="fs--1 mb-0">Brasil<br /></p>
                            </div>
                            <div class="col-12">
                              <hr />
                            </div>
                          </div>
                          <div class="row align-items-center">
                            <div class="col">
                              <h6 class="text-500">Faturado para</h6>
                              <h5>'.$dados['xNome'].'  <a href="client-details.php?docfsc='.$dados['cnpj_dest'].'"><img src="https://app.sweetadm.com.br/egestor/assets/img/icons/acessa_cad.png" alt="Acessar cadastro do Cliente!" width="25" height="25"></a>  </h5>
                              <p class="fs--1">'.$dados['xLgr'].', '.$dados['nro'].'<br />'.$dados['xMun'].' - '.$dados['UF'].', '.$dados['CEP'].'<br />'.$dados['xPais'].'</p>
                              <p class="fs--1"><a href="mailto:'.$dados['email_dest'].'">'.$dados['email_dest'].'</a><br /><a href="tel:'.$dados['fone'].'">'.$dados['fone'].'</a></p>
                            </div>
                            <div class="col-sm-auto ms-auto">
                              <div class="table-responsive">
                                <table class="table table-sm table-borderless fs--1">
                                  <tbody>
                                    <tr>
                                      <th class="text-sm-end">NF:</th>
                                      <td>'.$dados['nNF'].'</td>
                                    </tr>
                                    <tr>
                                      <th class="text-sm-end">Pedido:</th>
                                      <td>'.$xPed.'</td>
                                    </tr>
                                    <tr>
                                      <th class="text-sm-end">Emissão:</th>
                                      <td>'.$dtEmi.'</td>
                                    </tr>
                                    <tr>
                                      <th class="text-sm-end">Valor da NF:</th>
                                      <td>R$ '.number_format($dados['valor_nf'], 2, ',', '.').'</td>
                                    </tr>
                                    <tr>
                                      <th class="text-sm-end">Valor dos Prods:</th>
                                      <td>R$ '.number_format($dados['valor_produtos'], 2, ',', '.').'</td>
                                    </tr>
                                    <tr class="alert alert-success fw-bold">
                                      <th class="text-sm-end">Valor Devido:</th>
                                      <td>R$ '.number_format($valorConsi, 2, ',', '.').'</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="table-responsive scrollbar mt-4 fs--1">
                            <table class="table table-striped border-bottom">
                              <thead data-bs-theme="light">
                                <tr class="bg-primary text-white dark__bg-1000">
                                  <th class="border-0">Produtos</th>
                                  <th class="border-0 text-center">Quantidade</th>
                                  <th class="border-0 text-end">Valor Unit</th>
                                  <th class="border-0 text-end">Total</th>
                                </tr>
                              </thead>
                              <tbody>';
                              $sql5 = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_xmlProds WHERE cnpj_emit='".$dados['cnpj_emit']."' and nNFe='".$dados['nNF']."'") or die( mysqli_error($conn_egestor));
                                while($xmlProds = mysqli_fetch_assoc($sql5)) {
                                
                                                Echo'<tr>
                                                  <td class="align-middle">
                                                    <h6 class="mb-0 text-nowrap">'.$xmlProds['cEAN'].' - '.$xmlProds['cProd'].'</h6>
                                                    <p class="mb-0">'.$xmlProds['xProd'].'</p>
                                                  </td>
                                                  <td class="align-middle text-center">'.$xmlProds['qCom'].' '.$xmlProds['uCom'].'</td>
                                                  <td class="align-middle text-end">
                                                    <h6 class="mb-0 text-nowrap">R$ '.number_format($xmlProds['vUnCom']*$multiplicador, 2, ',', '.').'</h6>
                                                    <p class="mb-0">'.number_format($xmlProds['vUnCom'], 2, ',', '.').'</p>
                                                  </td>
                                                  <td class="align-middle text-end">
                                                    <h6 class="mb-0 text-nowrap">R$ '.number_format($xmlProds['vProd']*$multiplicador, 2, ',', '.').'</h6>
                                                    <p class="mb-0">'.number_format($xmlProds['vProd'], 2, ',', '.').'</p>
                                                  </td>
                                                </tr>';
                                }
                              Echo'</tbody>
                            </table>
                          </div>
                          <div class="row justify-content-end">
                            <div class="col-auto">
                              <table class="table table-sm table-borderless fs--1 text-end">
                              
                                <tr>
                                  <th class="text-900">Valor considerado para calculo:</th>
                                  <td class="fw-semi-bold">R$ '.number_format($valorConsi, 2, ',', '.').'</td>
                                </tr>
                                  <tr class="border-top border-top-2 fw-bolder text-900">
                                  <th></th>
                                  <td></td>
                                </tr>
                                <tr>
                                  <th class="text-900">Comissão Sweet 5%:</th>
                                  <td class="fw-semi-bold">R$ '.number_format($comissao_sweet, 2, ',', '.').'</td>
                                </tr>
                                <tr class="border-top">
                                  <th class="text-900">Comissão Preposto:</th>
                                  <td class="fw-semi-bold"></td>
                                </tr>
                              
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class="card-footer bg-light">
                          <p class="fs--1 mb-0"><strong>Obs: </strong>Agradecemos muito o seu negócio e, se houver mais alguma coisa que possamos fazer, informe-nos!</p>
                        </div>
                      </div>';
            }
            mysqli_close($conn_egestor);
        ?>   

      
        <!-- ===============================================-->
        <!--    End of page-->
        <!-- ===============================================-->
        

        <?php require_once('footer.php'); ?>
      </div>
    </div>
  </main>
  <!-- ===============================================-->
  <!--    End of Main Content-->
  <!-- ===============================================-->
  
  <?php require_once('divs.php'); ?>

  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->
    <script src="vendors/popper/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/anchorjs/anchor.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="vendors/list.js/list.min.js"></script>
    <script src="assets/js/theme.js"></script>

</body>

</html>