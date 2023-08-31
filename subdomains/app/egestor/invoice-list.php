<?php require_once('session-lgin.php'); ?>

<?php
require_once 'pdoconfig.php';

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

                <div class="card z-1 mb-3" id="recentPurchaseTable" data-list='{"valueNames":["order", "dtEmissao", "industria", "marca", "destinatario", "valor", "status"],"page":10,"pagination":true}'>
                    <div class="card-header">
                        <div class="row flex-between-center">
                            <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Notas Fiscais</h5>
                            </div>
                            <div class="col-auto col-sm-6 col-lg-5">
                              <div>
                                <form>
                                  <div class="input-group">
                                    <input class="form-control form-control-sm shadow-none search" type="search" placeholder="Pesquisar..." aria-label="search" />
                                    <button class="btn btn-sm btn-outline-secondary border-300 hover-border-secondary"><span class="fa fa-search fs--1"></span></button>
                                  </div>
                                </form>
                              </div>
                            </div>
                            <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                                <div class="d-none" id="table-purchases-actions">
                                    <div class="d-flex">
                                        <button class="btn btn-falcon-default btn-sm ms-2" type="button">Gerar Relatorio de Pagamento</button>
                                    </div>
                                </div>
                                <div id="table-purchases-replace-element">
                                    <button class="btn btn-falcon-success btn-sm mb-2 mb-sm-0" type="button" data-bs-toggle="modal" data-bs-target="#xml-upload-modal" aria-controls="xml-upload-modal">
                                        <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Inserir XML</span>
                                    </button>
                                    <button class="btn btn-falcon-default btn-sm mx-2" type="button"><span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ms-1">Filtros</span></button>
                                </div>
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
                                        <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="dtEmissao">Data Emissão</th>
                                        <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="industria">Industria</th>
                                        <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="marca">Marcas</th>
                                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="destinatario" style="min-width: 12.5rem;">Destinatario</th>
                                        <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="valor" name="vNF[]">Valor NF</th>
                                        <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="table-purchase-body">
                                    <?php
                                    $lastxm = new DateTime();
                                    $lastxm = new DateTime('-1 month');
                                    $lastxm = $lastxm->format('Y-m-d');
                                    
                                    // Create connection
                                    $conn_egestor = mysqli_connect($host, $username, $password, $dbname);
                                    // Check connection
                                    if (!$conn_egestor) {
                                        die("Connection failed: " . mysqli_connect_error());
                                    }
                                    $sql = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_xmlNF WHERE data_emissao >= '$lastxm' ORDER BY data_emissao DESC") or die(mysqli_error($conn_egestor));
                                    while ($dados = mysqli_fetch_assoc($sql)) {
                                        
                                        $xPed = '';

                                        $sql2 = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_Industria WHERE cnpj=".$dados['cnpj_emit']."") or die(mysqli_error($conn_egestor));
                                        while ($industria = mysqli_fetch_assoc($sql2)) {
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
                                        $sql_marca = mysqli_query($conn_egestor, "SELECT DISTINCT marca.marca AS marcas FROM eg_cad_xmlProds AS xmlp INNER JOIN eg_cad_Produtos prods ON (prods.ean = xmlp.cEAN or prods.descricao = xmlp.xProd) INNER JOIN eg_cad_Marcas marca ON marca.id = prods.marca WHERE xmlp.chNFe='".$dados['chNFe']."' ORDER BY marca.id") or die(mysqli_error($conn_egestor));
                                            while ($sqlmarca = mysqli_fetch_assoc($sql_marca)) {
                                                $marcasNF .= $sqlmarca['marcas'];
                                                $countmarca++;
                                                if(mysqli_num_rows($sql_marca)>1 and $countmarca % 2 != 0){$marcasNF .= ' / ';}
                                        }

                                        $dtEmiNF = explode(' ', $dados['data_emissao']);
                                        $dtEmiNF = implode('/', array_reverse(explode('-', $dtEmiNF[0])));
                                        $valor_consid = $dados['valor_produtos'] * $multiplicador;

                                        //if($dados['id_LtPag'] == '0'){$sClass = 'badge badge rounded-pill d-block badge-subtle-secondary'; $nStatus = 'Cancelada'; $ssClass = 'ms-1 fas fa-ban';}
                                        if($dados['id_LtPag'] == null){$sClass = 'badge badge rounded-pill d-block badge-subtle-warning'; $nStatus = 'Faturada'; $ssClass = 'ms-1 fas fa-file-invoice-dollar';}
                                        if($dados['id_LtPag'] == null and $dados['data_emissao']<$lastxm){$sClass = 'badge badge rounded-pill d-block badge-subtle-warning'; $nStatus = 'Vencida'; $ssClass = 'ms-1 fas fa-file-invoice-dollar';}
                                        if($dados['id_LtPag'] != null and $dados['id_relCR'] == null){$sClass = 'badge badge rounded-pill d-block badge-subtle-primary'; $nStatus = 'Recebida'; $ssClass = 'ms-1 fas fa-money-check-alt';}
                                        if($dados['id_LtPag'] != null and $dados['id_relCR'] != null){$sClass = 'badge badge rounded-pill d-block badge-subtle-success'; $nStatus = 'Paga'; $ssClass = 'ms-1 fas fa-check';}
                                        
                                        

                                        Echo'
                                            <tr class="btn-reveal-trigger">
                                              <td class="align-middle" style="width: 28px;">
                                                <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                                  <input class="form-check-input" type="checkbox" id="checkbox-0" data-bulk-select-row="data-bulk-select-row" />
                                                </div>
                                              </td>
                                              <td class="order py-2 align-middle white-space-nowrap"><a href="invoice.php?nNF='.$dados['nNF'].'&cnpj_emit='.$dados['cnpj_emit'].'"> <strong>#'.$dados['nNF'].'</strong></a><br />'.$xPed.'</td>
                                              <td class="dtEmissao py-2 align-middle"><strong>'.$dtEmiNF.'</strong><br />'.$dados[''].'</td>
                                              <td class="industria py-2 align-middle white-space-nowrap">'.$fIND.'</td>
                                              <td class="marca py-2 align-middle white-space-nowrap">'.$marcasNF.'</td>
                                              <td class="destinatario py-2 align-middle white-space-nowrap">'.$dados['xNome'].'</td>
                                              <td class="valor py-2 align-middle white-space-nowrap"><strong>R$ '.number_format($valor_consid, 2, ',', '.').'</strong>
                                                <p class="mb-0 text-600">R$ '.number_format($dados['valor_nf'], 2, ',', '.').'</p>
                                              </td>
                                              <td class="status py-2 align-middle text-center fs-0 white-space-nowrap"><span class="'.$sClass.'">'.$nStatus.'<span class="'.$ssClass.'" data-fa-transform="shrink-2"></span></span>
                                              </td>
                                            </tr>';
                                    }
                                    $nCLI = '';
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
                                <p class="mb-0 fs--1"><span class="d-none d-sm-inline-block me-2" data-list-info="data-list-info"></span><span class="d-none d-sm-inline-block me-2">&mdash;</span><a class="fw-semi-bold" href="#!" data-list-view="*">Ver todas<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">Ver menos<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                                </p>
                            </div>
                            <div class="col-auto d-flex">
                                <button class="btn btn-sm btn-primary" type="button" data-list-pagination="prev"><span>Anterior</span></button>
                                <button class="btn btn-sm btn-primary px-4 ms-2" type="button" data-list-pagination="next"><span>Proxima</span></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===============================================-->
                <!--    End of page-->
                <!-- ===============================================-->
                
                <!-- ===============================================-->
                <!--    Modals-->
                <!-- ===============================================-->
            
                <div class="modal fade" id="xml-upload-modal" tabindex="-1" role="dialog" aria-labelledby="authentication-modal-label" aria-hidden="true">
                    <div class="modal-dialog mt-6" role="document">
                        <div class="modal-content border-0">
                            <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                                <div class="position-relative z-1" data-bs-theme="light">
                                    <h5 class="mb-0 text-white" id="authentication-modal-label"><img class="rounded-3" src="assets/img/gallery/xml.png" alt="" width="112">  Assistante de importação...</h5>
                                </div>
                                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body py-4 px-5">
                                <form method="POST" enctype="multipart/form-data" action="xml-upload.php?op=1">
                                    <div class="fallback">
                                        <input name="file" type="file" id='file' />
                                    </div>
                                    <hr />
                                    <button class="btn btn-primary w-100"><span class="fas fa-cloud-upload-alt" data--transform="shrink-3"></span> Processar arquivo...</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="offcanvas offcanvas-bottom" id="offcanvasBottom" tabindex="-1" aria-labelledby="offcanvasBottomLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasBottomLabel"><img class="rounded-3" src="assets/img/gallery/excel-to-egestor.png" alt="" width="112"> Carregar dados da planilha...</h5>
                        <div class="card-footer border-top border-200 py-x1">
                        </div>
                        <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body small">
                        <form class="dropzone dropzone-multiple p-0" id="my-awesome-dropzone" data-dropzone="data-dropzone" action="#!">
                            <div class="fallback">
                                <input name="file" type="file" multiple="multiple" />
                            </div>
                            <div class="dz-message" data-dz-message="data-dz-message"> <img class="me-2" src="assets/img/icons/cloud-upload.svg" width="25" alt="" />Arraste e solte seus arquivos aqui...
                            </div>
                            <div class="dz-preview dz-preview-multiple m-0 d-flex flex-column">
                                <div class="d-flex media mb-3 pb-3 border-bottom btn-reveal-trigger"><img class="dz-image" src="assets/img/generic/image-file-2.png" alt="..." data-dz-thumbnail="data-dz-thumbnail" />
                                    <div class="flex-1 d-flex flex-between-center">
                                        <div>
                                            <h6 data-dz-name="data-dz-name"></h6>
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0 fs--1 text-400 lh-1" data-dz-size="data-dz-size"></p>
                                                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                                            </div><span class="fs--2 text-danger" data-dz-errormessage="data-dz-errormessage"></span>
                                        </div>
                                        <div class="dropdown font-sans-serif">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-2"><a class="dropdown-item" href="#!" data-dz-remove="data-dz-remove">Remover Arquivo</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary w-100"><span class="fas fa-cloud-upload-alt" data--transform="shrink-3"></span> Processar arquivo...</button>
                        </form>
                    </div>
                </div>
            
                <!-- ===============================================-->
                <!--    End of Modals-->
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
    <script src="vendors/glightbox/glightbox.min.js"> </script>
    <script src="assets/js/flatpickr.js"></script>
    <script src="vendors/echarts/echarts.min.js"></script>
    <script src="assets/data/world.js"></script>
    <script src="vendors/plyr/plyr.polyfilled.min.js"> </script>
    <script src="vendors/countup/countUp.umd.js"></script>
    <script src="vendors/chart/chart.min.js"></script>
    <script src="vendors/dropzone/dropzone.min.js"></script>
    <script src="vendors/leaflet/leaflet.js"></script>
    <script src="vendors/leaflet.markercluster/leaflet.markercluster.js"></script>
    <script src="vendors/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js"></script>
    <script src="vendors/list.js/list.min.js"></script>
    <script src="vendors/tinymce/tinymce.min.js"></script>
    <script src="vendors/dayjs/dayjs.min.js"></script>
    <script src="vendors/fullcalendar/main.min.js"></script>
    <script src="vendors/d3/d3.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="vendors/list.js/list.min.js"></script>
    <script src="assets/js/theme.js"></script>

</body>

</html>