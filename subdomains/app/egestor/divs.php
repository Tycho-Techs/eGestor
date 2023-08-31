<div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1" aria-labelledby="settings-offcanvas">
  <div class="offcanvas-header settings-panel-header bg-shape">
    <div class="z-1 py-1" data-bs-theme="light">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <h5 class="text-white mb-0 me-2"><span class="fas fa-palette me-2 fs-0"></span>Configurações</h5>
        <button class="btn btn-primary btn-sm rounded-pill mt-0 mb-0" data-theme-control="reset" style="font-size:12px">
          <span class="fas fa-redo-alt me-1" data-fa-transform="shrink-3"></span>Resetar</button>
      </div>
      <p class="mb-0 fs--1 text-white opacity-75"> Defina seu próprio estilo personalizado</p>
    </div>
    <button class="btn-close btn-close-white z-1 mt-0" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body scrollbar-overlay px-x1 h-100" id="themeController">
    <h5 class="fs-0">Esquema de Cores</h5>
    <p class="fs--1">Escolha o modo de cor perfeito para seu aplicativo.</p>
    <div class="btn-group d-block w-100 btn-group-navbar-style">
      <div class="row gx-2">
        <div class="col-6">
          <input class="btn-check" id="themeSwitcherLight" name="theme-color" type="radio" value="light" data-theme-control="theme" />
          <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherLight"> <span class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0" src="assets/img/generic/falcon-mode-default.jpg" alt=""/></span>
          <span class="label-text">Claro</span></label>
        </div>
        <div class="col-6">
          <input class="btn-check" id="themeSwitcherDark" name="theme-color" type="radio" value="dark" data-theme-control="theme" />
          <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherDark"> 
            <span class="hover-overlay mb-2 rounded d-block">
                <img class="img-fluid img-prototype mb-0" src="assets/img/generic/falcon-mode-dark.jpg" alt="" />
            </span>
            <span class="label-text">Escuro</span>
          </label>
        </div>
      </div>
    </div>
    <hr />
    <div class="d-flex justify-content-between">
      <div class="d-flex align-items-start"><img class="me-2" src="assets/img/icons/left-arrow-from-left.svg" width="20"
          alt="" />
        <div class="flex-1">
          <h5 class="fs-0">Modo RTL</h5>
          <p class="fs--1 mb-0">Mude a direção da escrita.</p>
          <a class="fs--1" href="documentation/customization/configuration.html">RTL - Documentação</a>
        </div>
      </div>
      <div class="form-check form-switch">
        <input class="form-check-input ms-0" id="mode-rtl" type="checkbox" data-theme-control="isRTL" />
      </div>
    </div>
    <hr />
    <div class="d-flex justify-content-between">
      <div class="d-flex align-items-start"><img class="me-2" src="assets/img/icons/arrows-h.svg" width="20" alt="" />
        <div class="flex-1">
          <h5 class="fs-0">Layout Fluido</h5>
          <p class="fs--1 mb-0">Alternar sistema de layout de contêiner </p><a class="fs--1" href="documentation/customization/configuration.html">Layout Fluid - Documentação</a>
        </div>
      </div>
      <div class="form-check form-switch">
        <input class="form-check-input ms-0" id="mode-fluid" type="checkbox" data-theme-control="isFluid" />
      </div>
    </div>
    <hr />
    <div class="d-flex align-items-start"><img class="me-2" src="assets/img/icons/paragraph.svg" width="20" alt="" />
      <div class="flex-1">
        <h5 class="fs-0 d-flex align-items-center">Posição de navegação</h5>
        <p class="fs--1 mb-2">Selecione um sistema de navegação adequado para sua aplicação web </p>
        <div>
          <select class="form-select form-select-sm" aria-label="Navbar position" data-theme-control="navbarPosition">
            <option value="vertical" data-page-url="modules/components/navs-and-tabs/vertical-navbar.html">Vertical</option>
            <option value="top" data-page-url="modules/components/navs-and-tabs/top-navbar.html">Top</option>
            <option value="combo" data-page-url="modules/components/navs-and-tabs/combo-navbar.html">Combo</option>
            <option value="double-top" data-page-url="modules/components/navs-and-tabs/double-top-navbar.html">Double Top</option>
          </select>
        </div>
      </div>
    </div>
    <hr />
    <h5 class="fs-0 d-flex align-items-center">Estilo de barra de navegação vertical</h5>
    <p class="fs--1 mb-0">Alternar entre estilos para a barra de navegação vertical </p>
    <p> <a class="fs--1" href="modules/components/navs-and-tabs/vertical-navbar.html#navbar-styles">Ver Documentação</a></p>
    <div class="btn-group d-block w-100 btn-group-navbar-style">
      <div class="row gx-2">
        <div class="col-6">
          <input class="btn-check" id="navbar-style-transparent" type="radio" name="navbarStyle" value="transparent" data-theme-control="navbarStyle" />
          <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-transparent"> 
            <img class="img-fluid img-prototype" src="assets/img/generic/default.png" alt="" />
            <span class="label-text">Transparente</span>
          </label>
        </div>
        <div class="col-6">
          <input class="btn-check" id="navbar-style-inverted" type="radio" name="navbarStyle" value="inverted" data-theme-control="navbarStyle" />
          <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-inverted"> 
            <img class="img-fluid img-prototype" src="assets/img/generic/inverted.png" alt="" />
            <span class="label-text">Invertido</span>
          </label>
        </div>
        <div class="col-6">
          <input class="btn-check" id="navbar-style-card" type="radio" name="navbarStyle" value="card" data-theme-control="navbarStyle" />
          <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-card"> 
            <img class="img-fluid img-prototype" src="assets/img/generic/card.png" alt="" />
            <span class="label-text">Cards</span>
          </label>
        </div>
        <div class="col-6">
          <input class="btn-check" id="navbar-style-vibrant" type="radio" name="navbarStyle" value="vibrant" data-theme-control="navbarStyle" />
          <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-vibrant"> 
            <img class="img-fluid img-prototype" src="assets/img/generic/vibrant.png" alt="" />
            <span class="label-text">Vibrante</span>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>