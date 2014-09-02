<nav style="background-color:#073D63" class="top-bar" data-topbar>
      <ul class="title-area">
        
        <li class="name">
          <h1>
            <a href="index.php">
	   	<img height="32" width="155" src="logo/logo.png" alt="runiso-logo"/>
            </a>

          </h1>
        </li>
        <li class="toggle-topbar menu-icon">
          <a href="#">
            <span>
             menu
            </span>
          </a>
        </li>
      </ul>      
      <section class="top-bar-section">
        <ul class="right">
<?php if(isset($_SESSION['admin'])){
?>

          <li>
            <a href="index.php">
              Saisie des identifiants
            </a>
          </li>
	<li>
	<a href="index.php?clean">
		Purge complete des mots de passes.
	</a>
	</li>
	<li>
	<a href="index.php?deconnexion">
		Deconnexion
	</a>


	</li>
<?php
}
?>
        </ul>
        
      </section>
    </nav>
    
    
    
