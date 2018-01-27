<nav class="navbar navbar-default navbar-custom navbar-static-top">
  <div class="container">
    <a class="navbar-brand" href="/">
      <img src="assets/icones/logo.png" width="130px">
    </a>
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
        aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li>
          <a href="/">Accueil</a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Catégories
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <?php echo $category->getNavCat(); ?>
          </ul>
        </li>
        <li>
          <a href="/contact-us.php">Contact</a>
        </li>
        <li class="search-nav">
          <div class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input id="search-input" type="text" class="form-control search-form" name="search-input" placeholder="Rechercher">
            </div>
          </div>
        </li>
      </ul>
      <?php if ($session->read('connected') != null) : ?>
      <ul class="nav navbar-nav navbar-right nav-custom">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="socicon-users custom-icon"></i>Mon compte
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">
              <?php $session->doubleGet('connected', 'username'); ?>
            </li>
            <li>
              <a href="">
                <i class="socicon-users"></i>Profil</a>
            </li>
            <li>
              <a href="">
                <i class="socicon-shopping-cart-black-shape"></i>Commandes</a>
            </li>
            <?php if (in_array($session->doubleRead('connected', 'status'), array('SUPER_ADMIN', 'ADMIN'))) : ?>
            <div class="divider"></div>
            <li>
              <a href="/dashboard/" class="item">
                <i class="socicon-dashboard"></i>Dashboard</a>
            </li>
            <?php endif; ?>
            <li role="separator" class="divider"></li>
            <li>
              <a href="/logout.php">
                <i class="socicon-logout"></i>Déconnexion</a>
            </li>
          </ul>
        </li>
        <li class="cart">
          <a href="#">
            <i class="socicon-shopping-cart-black-shape custom-icon"></i>Panier</a>
        </li>
      </ul>
    </div>
    <?php else : ?>
    <ul class="nav navbar-nav navbar-right nav-custom">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="socicon-users custom-icon"></i>Mon compte
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li>
            <a href="../signup.php" class="">
              <i class="socicon-add-square-button"></i> Inscription</a>
          </li>
          <li>
            <a href="../login.php" class="">
              <i class="socicon-login"></i> Connexion</a>
          </li>
        </ul>
      </li>
      <li class="cart">
        <a href="#">
          <i class="socicon-shopping-cart-black-shape custom-icon"></i>Panier</a>
      </li>
    </ul>

    <?php endif; ?>
  </div>
</nav>

<?php $util::get_alert('default'); ?>