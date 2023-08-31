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
            <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">XML</span><span
                class="border position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span></h5>
            <p class="mb-0">Importar e carregar dados do xml...</p>
          </div>
        </div>

       <?php 
       
       $arquivo = $_FILES['file'];
       var_dump($arquivo);
       
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