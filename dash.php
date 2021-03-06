<div class="dashboard">
      <div class="dashhead" id="dashtop">
        Legislative Dash
      </div>
      <div id="search">
        <form>
          <input type="submit" value="Go">
          <div>
            <input type="search" name="search" placeholder="Search bills, legislators, etc...." autocomplete="on">
          </div>
        </form>
      </div>   

      <div class="dashhead" id="login">Login</div>

 	<?php if (isset($_SESSION["name"])) { ?>
 		 <div class="loginbox">
 		 <div class="dashitem">
 			<p>You are logged in as <?= $_SESSION["name"] ?>.</p>
 		</div>
 			<form id="logout" action="lib/logout.php" method="post">
 				<input type="submit" value="Log out" />
 				<input type="hidden" name="logout" value="true" />
 			</form>
 		</div>
    
    <?php } elseif (isset($_SESSION["flash"])) {   #temp message across page redirects
	?>
		<script src="js/happy.js"></script>
		<script src="js/loginval.js"></script>
		<div class="dashitem"><?= $_SESSION["flash"] ?> </div>
			<div class="loginbox">
        	<form id="loginform" action="lib/login.php" method="POST">
          		<div class="loginbox">
            		<input type="text" name="username" id="username" placeholder="Username" tabindex="1" />
          		</div>
          			<input type="submit" value="Go" tabindex="3">
          		<div>
            		<input type="password" name="password" id="password" placeholder="Password" tabindex="2">
            		<label for="rememberme">Remember me:</label> 
            		<input type="checkbox" name="rememberme" value="1">
          		</div>
        	</form>
        <p span id="newuser">or <a href="newaccount.php">create new account</a>
        </p>
        </span>
        </div>
	
	<?php
		unset($_SESSION["flash"]);
	}  else { ?>
        <div class="loginbox">
        	<form id="loginform" action="lib/login.php" method="POST">
          		<div class="loginbox">
            		<input type="text" name="username" id="username" placeholder="Username" tabindex="1" />
          		</div>
          			<input type="submit" value="Go" tabindex="3">
          		<div>
            		<input type="password" name="password" id="password" placeholder="Password" tabindex="2">
          		</div>
          		<label for="rememberme">Remember me:</label> 
            		<input type="checkbox" name="rememberme" value="1">
        	</form>
        <p span id="newuser">or <a href="newaccount.php">create new account</a>
        </p>
        </span>
        </div>
      <?php } ?>
      
      <div class="dashhead" id="bills">Bills</div>
      <div class="dashitem">LOGIN...to load your bills.</div>
      
      <div class="dashhead" id="testimony">Comments</div>
      <div class="dashitem">
        
        <?php $dao = new Dao();
              $commentlist = $dao->getUserComments($_SESSION["name"]);
              foreach ($commentlist as $comment) {
                echo $comment["comment"] . "<br />";
                echo "DATE:" . $comment["date"] . "<br />";
              } ?>
        
      </div>
      
      <div class="dashhead" id="lawmakers">Lawmakers</div>
      <div class="dashitem">...to load your legislators.</div>
      <div class="dashhead" id="topics">Topics</div>
      <div class="dashitem">...to load your topics.</div>

    </div>