<!DOCTYPE html>
<html data-bs-theme="light" lang="pt-BR" dir="ltr">

<?php 

require_once('session-lgin.php');
require_once ('pdoconfig.php');

 require_once('header.php'); 
 require_once('functions.php');


 ?>


<body>
    


  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <div class="container" data-layout="container">

      <?php require_once('navbar-vertical.php'); ?>

      <div class="content">
        <?php require_once('navbar-top.php'); ?>

        <!-- ===============================================-->
        <!--    Page-->
        <!-- ===============================================-->

        <div class="d-flex mb-4 mt-3"><span class="fa-stack me-2 ms-n1"><i
              class="fas fa-circle fa-stack-2x text-300"></i><i
              class="fa-inverse fa-stack-1x text-primary fas fa-list"></i></span>
          <div class="col">
            <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">Lotes de Pagamento</span><span
                class="border position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span></h5>
            <p class="mb-0">Inserir Pagamento de NFe</p>
          </div>
        </div>

       <?php 

            try{
                $conn_egestor = new mysqli($host, $username, $password, $dbname);
            }catch (Exception $e) {
                die("Falha na conexão: ".$e->getMessage());
                $temerro++;
            }
            
             // Turn autocommit off
            $conn_egestor -> autocommit(FALSE);
                                    
            if($temerro != 0) $conn_egestor->rollback();
            else{
                $conn_egestor->commit();
            }
                        
            $conn_egestor->close();
            
          
       ?>
       
	       <div class="container">
	           
	           <div class="card z-1 mb-3" id="recentPurchaseTable" data-list='{"valueNames":["name","email","product","payment","amount"],"page":8,"pagination":true}'>
            <div class="card-header">
              <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                  <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Notas em aberto...</h5>
                </div>
              </div>
            </div>
            <div class="card-body px-0 py-0">
              <div class="table-responsive scrollbar">
                <table class="table table-sm fs--1 mb-0 overflow-hidden">
                  <thead class="bg-200 text-900">
                    <tr>
                      <th class="white-space-nowrap">
                        <div class="form-check mb-0 d-flex align-items-center">
                          <input class="form-check-input" id="checkbox-bulk-purchases-select" type="checkbox" data-bulk-select='{"body":"table-purchase-body","actions":"table-purchases-actions","replacedElement":"table-purchases-replace-element"}' />
                        </div>
                      </th>
                      <th class="sort pe-1 align-middle white-space-nowrap" data-sort="order">NF / Pedido</th>
                    <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="date">Data Emissão</th>
                    <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="date">Industria</th>
                    <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="date">Marcas</th>
                    <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="amount">Valor NF*</th>
                    <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">Status</th>
                    </tr>
                  </thead>
                  <tbody class="list" id="table-purchase-body">
                       <?php
                    // Create connection
                    $conn_egestor = mysqli_connect($host, $username, $password, $dbname);
                    // Check connection
                    if (!$conn_egestor) {die("Connection failed: " . mysqli_connect_error());}
                    $sql = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_xmlNF WHERE cnpj_dest='".$_GET['docfsc']."' ORDER BY data_emissao DESC LIMIT 0,10") or die( mysqli_error($conn_egestor));
                    while($dados = mysqli_fetch_assoc($sql)) {
                        $xPed='';
                        $sql2 = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_Industria WHERE cnpj='".$dados['cnpj_emit']."'") or die( mysqli_error($conn_egestor));
                        while($industria = mysqli_fetch_assoc($sql2)) {
                                $nIND = $industria['nome'];
                                $fIND = $industria['nFantasia'];
                                $multiplicador = $industria['multiplicador'];
                        }
                        
                        $sql4 = mysqli_query($conn_egestor, "SELECT DISTINCT xPed FROM eg_cad_xmlProds WHERE chNFe='".$dados['chNFe']."' GROUP BY xPed") or die(mysqli_error($conn_egestor));
                        while ($sqlprods = mysqli_fetch_assoc($sql4)) {
                            $xPed = $sqlprods['xPed'];
                        }
                        
                        $marcasNF = '';
                        $countmarca = 0;
                        $sql_marca = mysqli_query($conn_egestor, "SELECT DISTINCT marca.marca AS marcas FROM eg_cad_xmlProds AS xmlp INNER JOIN eg_cad_Produtos prods ON (prods.ean = xmlp.cEAN) INNER JOIN eg_cad_Marcas marca ON marca.id = prods.marca WHERE xmlp.chNFe='".$dados['chNFe']."' ORDER BY marca.id") or die(mysqli_error($conn_egestor));
                            while ($sqlmarca = mysqli_fetch_assoc($sql_marca)) {
                            $marcasNF .= $sqlmarca['marcas'];
                            $countmarca++;
                            if(mysqli_num_rows($sql_marca)>1 and $countmarca % 2 != 0){$marcasNF .= ' / ';}
                            }
                        
                        $dtEmiNF = explode(' ', $dados['data_emissao']);
                        $dtEmiNF = implode('/', array_reverse(explode('-', $dtEmiNF[0])));
                        $valor_consid = $dados['valor_produtos']*$multiplicador;
                             
                        //if($dados['id_LtPag'] == '0'){$sClass = 'badge badge rounded-pill d-block badge-subtle-secondary'; $nStatus = 'Cancelada'; $ssClass = 'ms-1 fas fa-ban';}
                        if($dados['id_LtPag'] == null){$sClass = 'badge badge rounded-pill d-block badge-subtle-warning'; $nStatus = 'Faturada'; $ssClass = 'ms-1 fas fa-stream';}
                        if($dados['id_LtPag'] != null){$sClass = 'badge badge rounded-pill d-block badge-subtle-primary'; $nStatus = 'Recebida'; $ssClass = 'ms-1 fas fa-redo';}
                        if($dados['id_LtPag'] != null and $dados['id_relCR'] != null){$sClass = 'badge badge rounded-pill d-block badge-subtle-success'; $nStatus = 'Paga'; $ssClass = 'ms-1 fas fa-check';}
                        Echo'
                          <tr class="btn-reveal-trigger">
                      <td class="align-middle" style="width: 28px;">
                        <div class="form-check mb-0">
                          <input class="form-check-input" type="checkbox" id="recent-purchase-0" data-bulk-select-row="data-bulk-select-row" />
                        </div>
                      </td>
                      <th class="align-middle white-space-nowrap"><a href="invoice.php?cnpj_emit='.$dados['cnpj_emit'].'&nNF='.$dados['nNF'].'"> <strong>#'.$dados['nNF'].'</strong></a><br />'.$xPed.'</th>
                      <td class="align-middle white-space-nowrap">'.$dtEmiNF.'<br />'.$dtEmiPED.'</td>
                      <td class="align-middle white-space-nowrap">'.$fIND.'</td>
                      <td class="align-middle text-center fs-0 white-space-nowrap">'.$marcasNF.' </td>
                      <td class="align-middle text-end"><p class="mb-0 text-600"><center><strong>R$ '.number_format($valor_consid, 2, ',', '.').'</strong><br /> R$ '.number_format($dados['valor_nf'], 2, ',', '.').'</center></p></td>
                      <td class="align-middle white-space-nowrap"><span class="'.$sClass.'">'.$nStatus.'<span class="'.$ssClass.'" data-fa-transform="shrink-2"></span> </td>
                    </tr>';
                    }
                    mysqli_close($conn_egestor);
                    ?> 
                    
                    
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <div class="row align-items-center">
                <div class="pagination d-none"></div>
                <div class="col">
                  <p class="mb-0 fs--1"><span class="d-none d-sm-inline-block me-2" data-list-info="data-list-info"></span><span class="d-none d-sm-inline-block me-2">&mdash;</span><a class="fw-semi-bold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">View less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                  </p>
                </div>
                <div class="col-auto d-flex">
                  <button class="btn btn-sm btn-primary" type="button" data-list-pagination="prev"><span>Previous</span></button>
                  <button class="btn btn-sm btn-primary px-4 ms-2" type="button" data-list-pagination="next"><span>Next</span></button>
                </div>
              </div>
            </div>
          </div>
       
    </div>

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
  <script src="vendors/dropzone/dropzone.min.js"></script>

</body>

</html>