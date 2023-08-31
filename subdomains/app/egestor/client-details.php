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
<?php require_once('functions.php'); ?>


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

        <div class="d-flex mb-4 mt-3"><span class="fa-stack me-2 ms-n1"><i
              class="fas fa-circle fa-stack-2x text-300"></i><i
              class="fa-inverse fa-stack-1x text-primary fas fa-list"></i></span>
          <div class="col">
            <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">Clientes</span><span
                class="border position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span></h5>
            <p class="mb-0">Detalhes do Cliente</p>
          </div>
        </div>
        
        <?php
            // Create connection
            $conn_egestor = mysqli_connect($host, $username, $password, $dbname);
            // Check connection
            if (!$conn_egestor) {die("Connection failed: " . mysqli_connect_error());}
            $sql = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_Clientes WHERE docfsc='".$_GET['docfsc']."'") or die( mysqli_error($conn_egestor));
            while($dados = mysqli_fetch_assoc($sql)) {
                
                $sql2 = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_Tabelas WHERE id=".$dados['tabela_id']."") or die( mysqli_error($conn_egestor));
                while($tabela = mysqli_fetch_assoc($sql2)) {
                    $nome_tabela = $tabela['nome'];
                }
                $sql3 = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_Vendedores WHERE id=".$dados['vendedor_id']."") or die( mysqli_error($conn_egestor));
                while($vendedor = mysqli_fetch_assoc($sql3)) {
                    $nome_vendedor = $vendedor['nome'];
                    $telefone_vendedor = $vendedor['telefone'];
                    $celular_vendedor = $vendedor['celular'];
                }
                
                $cnpj_cli = $dados['docfsc'];
                
                if(strlen($dados["docfsc"]) == 14){ $docfsc_dest = mask($dados["docfsc"], '##.###.###/####-##'); }
                elseif(strlen($dados["docfsc"]) == 13){ $docfsc_dest = mask($dados["docfsc"], '0#.###.###/####-##'); }
                else{ $docfsc_dest = mask($dados["docfsc"], '###.###.###-##'); }
                Echo'
                    <div class="card mb-3">
            <div class="card-header">
              <div class="row">
                <div class="col">
                  <h5 class="mb-2">'.$dados['razao_social'].' ('.$dados['nome_fantasia'].')</h5>
                  <a class="btn btn-falcon-default btn-sm" href="#!"><span class="fas fa-plus fs--2 me-1"></span>Add observacao</a>
                  <button class="btn btn-falcon-default btn-sm dropdown-toggle ms-2 dropdown-caret-none" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h"></span></button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Arquivar</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#">Deletar cliente</a>
                    </div>
                </div>
                <div class="col-auto d-none d-sm-block">
                  <h6 class="text-uppercase text-600">Distribuidor<span class="fas fa-user ms-2"></span></h6>
                </div>
              </div>
            </div>
            <div class="card-body border-top">
              <div class="d-flex"><span class="fas fa-user text-success me-2" data-fa-transform="down-5"></span>
                <div class="flex-1">
                  <p class="mb-0">Cliente foi criado</p>
                  <p class="fs--1 mb-0 text-600">Jan 12, 11:13 PM</p>
                </div>
              </div>
              
            </div>
            
          </div>
          <div class="card mb-3">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="mb-0">Detalhes</h5>
                </div>
                    <div class="col-auto">
                    <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#edit-infos" aria-controls="edit-infos">
                        <span class="fas fa-pencil-alt fs--2 me-1"></span>Atualizar informacoes
                    </button>
                    </div>
              </div>
            </div>
            <div class="card-body bg-light border-top">
              <div class="row">
                <div class="col-lg col-xxl-5">
                  <h6 class="fw-semi-bold ls mb-3 text-uppercase">Informacoes da conta</h6>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="fw-semi-bold mb-1">ID</p>
                    </div>
                    <div class="col"><p class="fst-italic text-400 mb-0">'.$dados['id'].'</p></div>
                  </div>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="fw-semi-bold mb-0">Codigo Futura</p>
                    </div>
                    <div class="col">
                      <p class="fst-italic text-400 mb-0">'.$dados['cod_rr'].'</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="fw-semi-bold mb-0">CNPJ</p>
                    </div>
                    <div class="col">
                      <p class="fst-italic text-400 mb-0">'.$docfsc_dest.'</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="fw-semi-bold mb-0">Inscrição Estadual</p>
                    </div>
                    <div class="col">
                      <p class="fst-italic text-400 mb-0">'.$dados['inscricao'].'</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="fw-semi-bold mb-1">Contato</p>
                    </div>
                    <div class="col">'.$dados['contato_nome'].'</div>
                  </div>
                  </br>
              <div class="row">
                <div class="col-5 col-sm-4">
                  <p class="fw-semi-bold mb-1">VENDEDOR</p>
                </div>
                <div class="col">'.$nome_vendedor.' (<a href="tel:'.$celular_vendedor.'"> '.$celular_vendedor.')</a></div>
              </div>
              <div class="row">
                <div class="col-5 col-sm-4">
                  <p class="fw-semi-bold mb-1">TABELA</p>
                </div>
                <div class="col">'.$nome_tabela.'</div>
              </div>
                  
                </div>
                
                <div class="col-lg col-xxl-5 mt-4 mt-lg-0 offset-xxl-1">
                  <h6 class="fw-semi-bold ls mb-3 text-uppercase">  </h6>
                  
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="fw-semi-bold mb-1">Endereço</p>
                    </div>
                    <div class="col">
                      <p class="mb-1">'.$dados['endereco'].', '.$dados['numero'].' - '.$dados['complemento'].'<br />'.$dados['bairro'].' - '.$dados['cidade'].', '.$dados['uf'].' '.$dados['cep'].'</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="fw-semi-bold mb-1">Número de telefone</p>
                    </div>
                    <div class="col"><a href="tel:'.$dados['fone_principal'].'">'.$dados['fone_principal'].'</a> / <a href="tel:'.$dados['fone_2'].'">'.$dados['fone_2'].'</a></div>
                  </div>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="fw-semi-bold mb-1">Número de celular</p>
                    </div>
                    <div class="col"><a href="cel:'.$dados['celular'].'">'.$dados['celular'].'</a></div>
                  </div>
                  <div class="row">
                    <div class="col-5 col-sm-4">
                      <p class="fw-semi-bold mb-1">Enviando e-mail para</p>
                    </div>
                    <div class="col"><a href="mailto:'.$dados['email'].'">'.$dados['email'].'</a></div>
                  </div>
                </div>
              </div>
            </div>
                ';
            }
            mysqli_close($conn_egestor);
        ?>                

          </div>
          <div class="card mb-3">
            <div class="card-header">
              <h5 class="mb-0">Faturamento</h5>
            </div>
            
            <div class="table-responsive scrollbar">
              <table class="table table-hover table-striped overflow-hidden">
                <thead>
                  <tr>
                    <th class="sort pe-1 align-middle white-space-nowrap" data-sort="order">NF / Pedido</th>
                    <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="date">Data Emissão</th>
                    <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="date">Industria</th>
                    <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="date">Marcas</th>
                    <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="amount">Valor NF*</th>
                    <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">Status</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    // Create connection
                    $conn_egestor = mysqli_connect($host, $username, $password, $dbname);
                    // Check connection
                    if (!$conn_egestor) {die("Connection failed: " . mysqli_connect_error());}
                    $sql = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_xmlNF WHERE cnpj_dest='$cnpj_cli' ORDER BY data_emissao DESC LIMIT 0,10") or die( mysqli_error($conn_egestor));
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
                          <tr class="align-middle">
                            <td class="order py-2 align-middle white-space-nowrap"><a href="invoice.php?cnpj_emit='.$dados['cnpj_emit'].'&nNF='.$dados['nNF'].'"> <strong>#'.$dados['nNF'].'</strong></a><br />'.$xPed.'</td>
                            <td class="date py-2 align-middle">'.$dtEmiNF.'<br />'.$dtEmiPED.'</td>
                            <td class="industria py-2 align-middle white-space-nowrap">'.$fIND.'</td>
                            <td class="marca py-2 align-middle white-space-nowrap">'.$marcasNF.'</td>
                            <td class="amount py-2 align-middle white-space-nowrap"><p class="mb-0 text-600"><center><strong>R$ '.number_format($valor_consid, 2, ',', '.').'</strong><br /> R$ '.number_format($dados['valor_nf'], 2, ',', '.').'</center></p></td>
                            <td class="status py-2 align-middle text-center fs-0 white-space-nowrap"><span class="'.$sClass.'">'.$nStatus.'<span class="'.$ssClass.'" data-fa-transform="shrink-2"></span></span>
                            </td>
                          </tr>
                          </a>';
                    }
                    mysqli_close($conn_egestor);
                    ?> 
                  
                </tbody>
              </table>
            </div>
            <div class="card-footer bg-light p-0"><a class="btn btn-link d-block w-100" href="#!">Ver mais notas<span class="fas fa-chevron-right fs--2 ms-1"></span></a></div>
          </div>
          
          <div class="card mb-3">
            <div class="card-body">
              <div class="row justify-content-between align-items-center">
                <div class="col-md">
                  <h5 class="mb-2 mb-md-0">Pagamentos</h5>
                </div>
              <div class="col-auto">
                  <form action="payment-batch.php" method="post" id="formulario">
                    <input type="hidden" name="docfsc" value="<?php echo $_GET['docfsc']; ?>" />
                </form>
                <a class="nav-link" href="../../egestor/payment-batch.php?docfsc=<?php echo $_GET['docfsc']; ?>" onclick="document.getElementByID('formulario').submit(); return false">
                    <button class="btn btn-falcon-success btn-sm mb-2 mb-sm-0" type="submit"><span class="fas fa-dollar-sign me-1"></span>Receber Pagamento</button>
                    </a>
              </div>
             </div>
            </div>
             
            
            <div class="table-responsive scrollbar">
              <table class="table table-hover table-striped overflow-hidden">
                <thead>
                  <tr>
                    <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="lote">Lote ID</th>
                    <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="total">Valor</th>
                    <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="entrega">Dt. Entrega</th>
                    <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="status">Status</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    // Create connection
                    $conn_egestor = mysqli_connect($host, $username, $password, $dbname);
                    // Check connection
                    if (!$conn_egestor) {die("Connection failed: " . mysqli_connect_error());}
                    $sql = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_LotesPag WHERE docfsc='$docfsc_desti' ORDER BY id DESC LIMIT 0,5;") or die( mysqli_error($conn_egestor));
                    while($dados = mysqli_fetch_assoc($sql)) {
                        Echo'
                          <tr class="align-middle">
                            <td class="order py-2 align-middle white-space-nowrap"><a href="invoice.php?nf='.$dados['nNF'].'">'.$dados['nPED'].'</a></td>
                            <td class="date py-2 align-middle"></td>
                            <td class="industria py-2 align-middle white-space-nowrap"></td>
                            </td>
                          </tr>';
                    }
                    mysqli_close($conn_egestor);
                    ?> 
                  
                </tbody>
              </table>
              <div class="text-center d-none" id="contact-table-fallback">
                    <p class="fw-bold fs-1 mt-3">Nenhum cliente encontrado</p>
                  </div>
            </div>
            <div class="card-footer bg-light p-0"><a class="btn btn-link d-block w-100" href="#!">Ver mais pagamentos<span class="fas fa-chevron-right fs--2 ms-1"></span></a></div>
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
  <script src="vendors/dropzone/dropzone.min.js"></script>

</body>

</html>