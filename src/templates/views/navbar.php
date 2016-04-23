<div class = "navbar navbar-inverse navbar-static-top">	
	<div class = "container">
		<div class="navbar-header">
			<a href = "#" class = "navbar-brand">
				<?php
				if(array_key_exists('uid',$_SESSION))
					echo "Hello ".$_SESSION['name'];
				else
					echo "Debt Tennis Tracker";
				?>
			</a>

			<button class="navbar-toggle" data-toggle="collapse" data-target="#navHeaderCollapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class = "collapse navbar-collapse" id="navHeaderCollapse">
			<?php
				echo '<ul class = "nav navbar-nav navbar-right">';
				if(array_key_exists('uid',$_SESSION)){
					if(strpos($_SERVER["PHP_SELF"],"profile.php") != FALSE)
						echo '	<li class = "active"><a href="../../app/models/profile.php">Home</a></li>
								<li><a href="../../app/models/contacts.php">Contacts</a></li>';
					else if(strpos($_SERVER["PHP_SELF"],"contacts.php") != FALSE)
						echo '	<li><a href="../../app/models/profile.php">Home</a></li>
								<li class = "active"><a href="../../app/models/contacts.php">Contacts</a></li>';
					else
						echo '	<li><a href="../../app/models/profile.php">Home</a></li>
								<li><a href="../../app/models/contacts.php">Contacts</a></li>';
					echo '<li><a href="../../app/models/logout.php">Logout</a></li></ul>';
				}
				else{
					echo '	<form class="navbar-form navbar-right" action="../../app/models/loginsubmit.php" method="POST">
								<div class="form-group">
									<input type="text" name="email" class="form-control" placeholder="Email">
									<input type="password" name="password" class="form-control" placeholder="Password">
								</div>
								<button type="submit" class="btn btn-default">Login</button>
							</form>';
				}
			?>
		</div>
	</div>
</div>