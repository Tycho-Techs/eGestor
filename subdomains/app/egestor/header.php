<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>e-Gestor | BPO Online</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="assets/js/config.js"></script>
    <script src="vendors/simplebar/simplebar.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-bs5/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="vendors/glightbox/glightbox.min.css" rel="stylesheet">
    <link href="vendors/plyr/plyr.css" rel="stylesheet">
    <link href="vendors/dropzone/dropzone.min.css" rel="stylesheet">
    <link href="vendors/leaflet/leaflet.css" rel="stylesheet">
    <link href="vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet">
    <link href="vendors/leaflet.markercluster/MarkerCluster.Default.css" rel="stylesheet">
    <link href="vendors/fullcalendar/main.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link href="assets/css/theme-rtl.css" rel="stylesheet" id="style-rtl">
    <link href="assets/css/theme.css" rel="stylesheet" id="style-default">
    <link href="assets/css/user-rtl.css" rel="stylesheet" id="user-style-rtl">
    <link href="assets/css/user.css" rel="stylesheet" id="user-style-default">
    <link href="vendors/leaflet/leaflet.css" rel="stylesheet" />
    <link href="vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet" />
    <link href="vendors/leaflet.markercluster/MarkerCluster.Default.css" rel="stylesheet" />
    
    <script>
      var isRTL = JSON.parse(localStorage.getItem('isRTL'));
      if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
</head>