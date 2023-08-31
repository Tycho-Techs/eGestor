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

        <div class="d-flex mb-4 mt-3"><span class="fa-stack me-2 ms-n1"><i
              class="fas fa-circle fa-stack-2x text-300"></i><i
              class="fa-inverse fa-stack-1x text-primary fas fa-list"></i></span>
          <div class="col">
            <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">VENDEDORES</span><span
                class="border position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span></h5>
            <p class="mb-0">Lista de Prepostos</p>
          </div>
        </div>

        <div class="row gx-3">
          <div class="col-xxl-10 col-xl-9">
            <div class="card" id="allContactTable"
              data-list='{"valueNames":["cnpj","grupo","nome-fantasia","razao-social","cidade", "uf"],"page":10,"pagination":true,"fallback":"contact-table-fallback"}'>
              <div class="card-header border-bottom border-200 px-0">
                <div class="d-lg-flex justify-content-between">
                  <div class="row flex-between-center gy-2 px-x1">
                    <div class="col-auto pe-0">
                      <h6 class="mb-0"><!--Clientes--></h6>
                    </div>
                    <div class="col-auto">
                      <form>
                        <div class="input-group input-search-width">
                          <input class="form-control form-control-sm shadow-none search" type="search"
                            placeholder="Pesquisar cliente" aria-label="search" />
                          <button class="btn btn-sm btn-outline-secondary border-300 hover-border-secondary"><span
                              class="fa fa-search fs--1"></span></button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="border-bottom border-200 my-3"></div>
                  <div class="d-flex align-items-center justify-content-between justify-content-lg-end px-x1">
                    <button class="btn btn-sm btn-falcon-default d-xl-none" type="button" data-bs-toggle="offcanvas"
                      data-bs-target="#allContactOffcanvas" aria-controls="allContactOffcanvas"><span
                        class="fas fa-filter" data-fa-transform="shrink-4"></span><span
                        class="ms-1 d-none d-sm-inline-block">Filtros</span></button>
                    <div class="bg-300 mx-3 d-none d-lg-block d-xl-none" style="width:1px; height:29px"></div>
                    <div class="d-flex align-items-center" id="table-contact-replace-element">
                      <button class="btn btn-falcon-success btn-sm" type="button"><span class="fas fa-plus"
                          data-fa-transform="shrink-3"></span><span
                          class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1">Novo</span></button>
                      <!-- <span class="fas fa-ellipsis-h fs--2"></span> -->

                      <!-- <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
                            <span class="fas fa-file-excel" data--transform="shrink-3"></span><span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1">Importar</span>
                            </button> -->

                      <!-- <a class="nav-link" href="../../#excel-upload-modal" data-bs-toggle="modal">
                        <button class="btn btn-falcon-default btn-sm" type="button">
                          <span class="fas fa-file-excel" data--transform="shrink-3"></span><span
                            class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1">Importar</span>
                        </button>
                      </a> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive scrollbar">
                  <table class="table table-sm fs--1 mb-0">
                    <thead class="text-800 bg-light">
                      <tr>
                        <th class="sort align-middle nome-fantasia" data-sort="nome-fantasia">Nome</th>
                        <th class="sort align-middle razao-social" data-sort="razao-social">Telefone</th>
                        <th class="sort align-middle razao-social" data-sort="razao-social">Celular</th>
                        <th class="sort align-middle cidade" data-sort="cidade">E-mail</th>
                        <th class="sort align-middle uf" data-sort="status">Status</th>
                      </tr>
                    </thead>

                    <tbody class="list" id="table-contact-body">
                      
                      <?php
                        // Create connection
                        $conn_egestor = mysqli_connect($host, $username, $password, $dbname);
                        // Check connection
                        if (!$conn_egestor) {die("Connection failed: " . mysqli_connect_error());}
                        $sql = mysqli_query($conn_egestor, "SELECT * FROM eg_cad_Vendedores") or die( mysqli_error($conn_egestor));
                        while($dados = mysqli_fetch_assoc($sql)) {
                            Echo'
                                <tr>
                                <td class="align-middle nome-fantaisa white-space-nowrap pe-5 ps-2">
                                  <div class="d-flex align-items-center gap-2 position-relative">
                                    <div class="avatar avatar-xl">
                                      <div class="avatar-name rounded-circle"><span>--</span></div>
                                    </div>
                                    <h6 class="mb-0"><a class="stretched-link text-900"
                                        href="../../egestor/seller-details.php?id='.$dados['id'].'">'.$dados['nome'].'</a></h6>
                                  </div>
                                </td>
                                <td class="align-middle razao-social">'.$dados['telefone'].'</td>
                                <td class="align-middle cidade">'.$dados['celular'].'</td>
                                <td class="align-middle uf">'.$dados['email'].'</td>
                                <td class="align-middle text-end fs-0 white-space-nowrap payment"><span
                                    class="badge badge rounded-pill badge-subtle-success"><span class="ms-1 fas fa-check"
                                      data-fa-transform="shrink-2"></span></span></td>
                                </tr>
                            ';
                        }
                        mysqli_close($conn_egestor);
                        ?>
                        
                    </tbody>
                  </table>
                  <div class="text-center d-none" id="contact-table-fallback">
                    <p class="fw-bold fs-1 mt-3">Nenhum cliente encontrado</p>
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-center">
                <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous"
                  data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="pagination mb-0"></ul>
                <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next"
                  data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
              </div>
            </div>
          </div>
          <div class="col-xxl-2 col-xl-3">
            <div class="sticky-sidebar">
              <div
                class="offcanvas offcanvas-end offcanvas-filter-sidebar border-0 dark__bg-card-dark h-auto rounded-xl-3"
                tabindex="-1" id="allContactOffcanvas" aria-labelledby="allContactOffcanvasLabel">
                <div class="offcanvas-header d-flex flex-between-center d-xl-none bg-light">
                  <h6 class="fs-0 mb-0 fw-semi-bold">Filtros</h6>
                  <button class="btn-close text-reset d-xl-none shadow-none" id="allContactOffcanvasLabel" type="button"
                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="card scrollbar shadow-none shadow-show-xl">
                  <div class="card-header bg-light d-none d-xl-block">
                    <h6 class="mb-0">Filtros</h6>
                  </div>
                  <div class="card-body">
                    <form>
                      <div class="mb-2 mt-n2">
                        <label class="mb-1">Algum filtro...</label>
                        <select class="form-select form-select-sm">
                          <option>-- Nenhum --</option>
                          <option>Um</option>
                          <option selected="selected">Dois</option>
                          <option>Tres</option>
                        </select>
                      </div>
                    </form>
                  </div>
                  <div class="card-footer border-top border-200 py-x1">
                    <button class="btn btn-primary w-100">Atualizar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="excel-upload-modal" tabindex="-1" role="dialog"
          aria-labelledby="authentication-modal-label" aria-hidden="true">
          <div class="modal-dialog mt-6" role="document">
            <div class="modal-content border-0">
              <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1" data-bs-theme="light">
                  <h5 class="mb-0 text-white" id="authentication-modal-label"><img class="rounded-3"
                      src="assets/img/gallery/excel-upload.png" alt="" width="112"> Carregar dados da planilha...</h5>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2"
                  data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body py-4 px-5">
                <form method="POST" enctype="multipart/form-data" action="excel-upload.php?#!">
                  <div class="fallback">
                    <input name="file" type="file" id='file' />
                  </div>
                  <!--
                  <div class="dz-message" data-dz-message="data-dz-message"> <img class="me-2"
                      src="assets/img/icons/cloud-upload.svg" width="25" alt="" />Arraste e solte seus arquivos aqui...
                  </div>
                  <div class="dz-preview dz-preview-multiple m-0 d-flex flex-column">
                    <div class="d-flex media mb-3 pb-3 border-bottom btn-reveal-trigger"><img class="dz-image"
                        src="assets/img/generic/image-file-2.png" alt="..." data-dz-thumbnail="data-dz-thumbnail" />
                      <div class="flex-1 d-flex flex-between-center">
                        <div>
                          <h6 data-dz-name="data-dz-name"></h6>
                          <div class="d-flex align-items-center">
                            <p class="mb-0 fs--1 text-400 lh-1" data-dz-size="data-dz-size"></p>
                            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                          </div><span class="fs--2 text-danger" data-dz-errormessage="data-dz-errormessage"></span>
                        </div>
                        <div class="dropdown font-sans-serif">
                          <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                              class="fas fa-ellipsis-h"></span></button>
                          <div class="dropdown-menu dropdown-menu-end border py-2"><a class="dropdown-item" href="#!"
                              data-dz-remove="data-dz-remove">Remover Arquivo</a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  -->
                  <hr />
                  <button class="btn btn-primary w-100"><span class="fas fa-cloud-upload-alt"
                      data--transform="shrink-3"></span> Processar arquivo...</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="offcanvas offcanvas-bottom" id="offcanvasBottom" tabindex="-1"
          aria-labelledby="offcanvasBottomLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel"><img class="rounded-3"
                src="assets/img/gallery/excel-to-egestor.png" alt="" width="112"> Carregar dados da planilha...</h5>
            <div class="card-footer border-top border-200 py-x1">
            </div>
            <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body small">
            <form class="dropzone dropzone-multiple p-0" id="my-awesome-dropzone" data-dropzone="data-dropzone"
              action="#!">
              <div class="fallback">
                <input name="file" type="file" multiple="multiple" />
              </div>
              <div class="dz-message" data-dz-message="data-dz-message"> <img class="me-2"
                  src="assets/img/icons/cloud-upload.svg" width="25" alt="" />Arraste e solte seus arquivos aqui...
              </div>
              <div class="dz-preview dz-preview-multiple m-0 d-flex flex-column">
                <div class="d-flex media mb-3 pb-3 border-bottom btn-reveal-trigger"><img class="dz-image"
                    src="assets/img/generic/image-file-2.png" alt="..." data-dz-thumbnail="data-dz-thumbnail" />
                  <div class="flex-1 d-flex flex-between-center">
                    <div>
                      <h6 data-dz-name="data-dz-name"></h6>
                      <div class="d-flex align-items-center">
                        <p class="mb-0 fs--1 text-400 lh-1" data-dz-size="data-dz-size"></p>
                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                      </div><span class="fs--2 text-danger" data-dz-errormessage="data-dz-errormessage"></span>
                    </div>
                    <div class="dropdown font-sans-serif">
                      <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none"
                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                          class="fas fa-ellipsis-h"></span></button>
                      <div class="dropdown-menu dropdown-menu-end border py-2"><a class="dropdown-item" href="#!"
                          data-dz-remove="data-dz-remove">Remover Arquivo</a></div>
                    </div>
                  </div>
                </div>
              </div>
              <button class="btn btn-primary w-100"><span class="fas fa-cloud-upload-alt"
                  data--transform="shrink-3"></span> Processar arquivo...</button>
            </form>
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