<div class = "navbar navbar-default navbar-fixed-bottom">
	<div class = "container">
		<?php
				// Include and instantiate the class.
		require_once 'mobileDetect/Mobile_Detect.php';
		$detect = new Mobile_Detect;
		 
		// Any mobile device (phones or tablets).
		if ( $detect->isMobile() ) {
		 	echo '<a href = "src/templates/views/debtcreatormobile.php"  class = "navbar-btn btn-success btn pull-right">Create a new debt</a>';
		}
		else{
			echo '<a href = "#selectcontacts" class = "navbar-btn btn-success btn pull-right" data-toggle="modal">Create a new debt</a>';
		}
		?>
	</div>
</div>	
<div class = "modal fade" id ="selectcontacts">
	<div class = "modal-dialog">
		<div class = "modal-content">
			<div class = "modal-header">
				<h3>Create a debt...</h3>
			</div>
			<div class = "modal-body">
				<?php
					include "debtcreator.php";
				?>
			</div>
			<div class="modal-footer">
				<div class="buttons">
					<a href = "#selectcontacts" class = "navbar-btn btn-danger btn pull-left" data-toggle="modal">Cancel</a>
		    		<div id="debtnext" class = "navbar-btn btn-success btn pull-right">Next ></div>
		    		<div id="debtprevious" class = "navbar-btn btn-danger btn pull-right hidden">< Go Back</div>
		    	</div>
		    </div>
		    <script src = "src/assets/js/debtcreator.js"></script>
		</div>
	</div>
</div>
