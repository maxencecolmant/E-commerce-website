<nav class="navbar navbar-default navbar-custom navbar-static-top">   

  <div class="container">
    <a class="navbar-brand" href="index.php"><img src="assets/icones/logo.png" width="150px"></a> 
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
</div>
<div id="navbar" class="navbar-collapse collapse">
  <ul class="nav navbar-nav">
    <li><a href="/">Accueil</a></li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Catégories <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</li>
<li><a href="contact.php">Contact</a></li>
<li class="search-nav">
  <div class="navbar-form navbar-left" role="search">
    <div class="form-group">
      <input id="search-input" type="text" class="form-control search-form" name="search-input" placeholder="Rechercher">
  </div>
</div>
</li>
</ul>
<?php if ( $session->read( 'connected' ) != null) : ?>
  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Profil
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li class="dropdown-header"><?php $session->doubleGet( 'connected', 'pseudonym' ); ?>
                </li>
                <li>Me</li>
                <li>Orders</li>
                <?php if ( in_array( $session->doubleRead( 'connected', 'status' ), array('SUPER_ADMIN', 'ADMIN' ) ) ): ?>
                    <div class="divider"></div>
                    <a href="/panel-admin/" class="item">Panel Admin</a>
                <?php endif; ?>
                <li role="separator" class="divider"></li>
                <li><a href="/logout.php">Déconnexion</a></li>
            </ul>
        </li>
    </ul>
</div>
<?php else: ?>
 <ul class="nav navbar-nav navbar-right extra-links">
    <li><a href="/signup.php" class="btn-like-link">Inscription</a></li>
    <li><a href="/login.php" class="btn-like-link">Connexion</a></li>
</ul>
<?php endif; ?>
</nav>