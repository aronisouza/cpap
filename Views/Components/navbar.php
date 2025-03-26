<nav class="navbar navbar-expand-lg navbar-light bg-nav-bar">
  <div class="container-md">
    <a class="navbar-brand" href="#"><?= getenv("SITE_CIGLA"); ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/">Sobre</a>
        </li>
      </ul>

      <div class="d-flex">
        <div class="btn-group">
          <?php if (!isset($_SESSION["user"])): ?>
            <a href="/login" class="nav-link d-inline-flex align-items-center justify-content-center gap-2">
              <?= fldIco("person", 24, "text-dark"); ?> Entrar
            </a>
          <?php else: ?>
            <button type="button" class="nav-link dropdown-toggle d-inline-flex align-items-center justify-content-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
              <?= $_SESSION['user']['name']; ?>
            </button>
            <ul class="dropdown-menu" id="userDropdownGroup">
              <li><a href="/profile" class="dropdown-item">Perfil</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a href="/logout" class="dropdown-item">Sair</a></li>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</nav>