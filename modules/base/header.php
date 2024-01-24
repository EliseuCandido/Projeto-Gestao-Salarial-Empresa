<header class="mb-1">
	<div class="row">
		<div class="col-md-6">
			<div class="logo">Processamento</div>
		</div>
		<div class="col-md-6 d-flex align-items-center justify-content-end">
			<ul style="display: flex;">

					<?php 
					if(@$_SESSION["user_type"] != ''){
						echo '<li><a style="color: red;" href="sair.php">Sair</a></li>';
					}
					?>
				</li>

			</ul>
		</div>
	</div>
</header>
