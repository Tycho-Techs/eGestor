<!DOCTYPE html>
<html data-bs-theme="light" lang="pt-BR" dir="ltr">

<?php 

require_once('session-lgin.php');
require_once('header.php'); 
require_once ('pdoconfig.php');
$caminho_pag = getcwd();
?>

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
            
               <div class="fw-black lh-1 text-300 fs-error"><span>Pagina em Branco</span></div>
               <?php echo $caminho_pag; ?>
            
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