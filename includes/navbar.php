<div class="ui large top fixed hidden menu">
    <div class="ui container">
        <a class="active item">Home</a><a class="item">Work</a><a class="item">Company</a><a class="item">Careers</a>
        <div class="right menu">
			<?php if ( $session->read( 'connected' ) != null) : ?>
                <div class="ui inverted right dropdown item">
                    Profil
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <div class="header"><?php $session->doubleGet( 'connected', 'pseudonym' ); ?></div>
                        <div class="item">Me</div>
                        <div class="item">Orders</div>
	                    <?php if ( in_array( $session->doubleRead( 'connected', 'status' ), array('SUPER_ADMIN', 'ADMIN' ) ) ): ?>
                            <div class="divider"></div>
                            <a href="/panel-admin/" class="item">Panel Admin</a>
	                    <?php endif; ?>
                        <div class="divider"></div>
                        <a class="item" href="/logout.php">Log Out</a>
                    </div>
                </div>
			<?php else: ?>
                <div class="item">
                    <a class="ui button" href="/login.php">Log in</a>
                </div>
                <div class="item">
                    <a class="ui blue button" href="/signup.php">Sign Up</a>
                </div>
			<?php endif; ?>
        </div>
    </div>
</div>
<!--Sidebar Menu-->
<div class="ui vertical inverted sidebar menu">
    <a class="active item">Home</a><a class="item">Work</a><a class="item">Company</a><a class="item">Careers</a><a
            class="item">Login</a><a class="item">Signup</a>
</div>
