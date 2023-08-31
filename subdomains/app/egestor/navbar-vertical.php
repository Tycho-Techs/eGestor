<nav class="navbar navbar-vertical navbar-expand-xl navbar-light">

  <script>
    var navbarStyle = localStorage.getItem("navbarStyle");
    if (navbarStyle && navbarStyle !== 'transparent') {
      document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
    }
  </script>
  
  <script>
    const navbarVerticalToggle = document.querySelector(.navbar-vertical-toggle);
    navbarVerticalToggle.addEventListener('navbar.vertical.toggle', function () {
        // do something...
    })
  </script>

  <div class="d-flex align-items-center">
    <div class="toggle-icon-wrapper">
      <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Alternar navegação">
        <span class="navbar-toggle-icon">
          <span class="toggle-line"></span>
        </span>
      </button>
    </div>
    <a class="navbar-brand" href="index.php">
      <div class="d-flex align-items-center py-3"><img class="me-2" src="assets/img/icons/spot-illustrations/e-Gestor.png" alt="" width="28" />
        <span class="font-sans-serif">e-Gestor</span>
      </div>
    </a>
  </div>

  <div class="collapse navbar-collapse" id="navbarVerticalCollapse">

    <div class="navbar-vertical-content scrollbar">
      <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">

        <!-- DASHBOARD -->
        <li class="nav-item">
          <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="dashboard">
            <div class="d-flex align-items-center">
                <span class="nav-link-icon">
                    <span class="fas fa-chart-pie"></span>
                </span>
                <span class="nav-link-text">Dashboard</span>
                <!-- <span class="badge rounded-pill badge-subtle-success ms-2">Novo</span> -->
            </div>
          </a>
          <ul class="nav collapse" id="dashboard">
            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <div class="d-flex align-items-center">
                  <span class="nav-link-text ps-1">- Index</span></span>
                </div>
              </a>
            </li>
          </ul>
        </li>
        <!-- END DASHBOARD -->

        <!-- APP -->
        <li class="nav-item">
          <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
            <div class="col-auto navbar-vertical-label">App</div>
            <div class="col ps-0">
              <hr class="mb-0 navbar-vertical-divider" />
            </div>
          </div>
          <a class="nav-link" href="app/calendar.php" role="button">
            <div class="d-flex align-items-center">
              <span class="nav-link-icon">
                <span class="fas fa-calendar-alt"></span>
              </span>
              <span class="nav-link-text ps-1">Calendario</span>
            </div>
          </a>
          <a class="nav-link dropdown-indicator" href="#email" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="email">
            <div class="d-flex align-items-center">
              <span class="nav-link-icon">
                <span class="fas fa-envelope-open"></span>
              </span>
              <span class="nav-link-text ps-1">E-mail</span>
            </div>
          </a>
          <ul class="nav collapse" id="email">
            <li class="nav-item">
              <a class="nav-link" href="app/email/inbox.html">
                <div class="d-flex align-items-center">
                  <span class="nav-link-text ps-1">Inbox</span>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="app/email/email-detail.html">
                <div class="d-flex align-items-center">
                  <span class="nav-link-text ps-1">Email detail</span>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="app/email/compose.html">
                <div class="d-flex align-items-center">
                  <span class="nav-link-text ps-1">Compose</span>
                </div>
              </a>
            </li>
          </ul>
        </li>
        <!-- END APP -->

        <!-- PAGINAS -->
        <li class="nav-item">
          <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
            <div class="col-auto navbar-vertical-label">Paginas</div>
            <div class="col ps-0">
              <hr class="mb-0 navbar-vertical-divider" />
            </div>
          </div>
          
          <a class="nav-link" href="invoice-list.php" role="button">
            <div class="d-flex align-items-center">
              <span class="nav-link-icon">
                <span class="fas fa-file-invoice"></span>
              </span>
              <span class="nav-link-text ps-1">Notas Fiscais</span>
            </div>
          </a>
          
          <a class="nav-link" href="seller-list.php" role="button">
            <div class="d-flex align-items-center">
              <span class="nav-link-icon">
                <span class="fas fa-university"></span>
              </span>
              <span class="nav-link-text ps-1">Contas Bancárias</span>
            </div>
          </a>
          
          <a class="nav-link" href="client-list.php" role="button">
            <div class="d-flex align-items-center">
              <span class="nav-link-icon">
                <span class="fas fa-users"></span>
              </span>
              <span class="nav-link-text ps-1">Clientes</span>
            </div>
          </a>
          
          <a class="nav-link" href="seller-list.php" role="button">
            <div class="d-flex align-items-center">
              <span class="nav-link-icon">
                <span class="fas fa-user-tie"></span>
              </span>
              <span class="nav-link-text ps-1">Vendedores</span>
            </div>
          </a>

        </li>
        <!-- END PAGINAS -->

      </ul>
    </div>

  </div>
</nav>