<section class="d-flex align-items-center">
	<style>
		main {
			display: none;
		}

		nav {

			height: 73.2%;

		}
	</style>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow-lg border-0 rounded-lg mt-5">
					<div class="card-header">
						<h2 class="text-center font-weight-light my-4">Login</h2>
					</div>
					<div class="card-body">
						<form method="POST">
							<div class="form-group">
								<label for="login_email" class="small mb-1">Email</label>
								<input type="email" id="login_email" placeholder="Email:" name="login_email" class="form-control py-4" required>
							</div>

							<div class="form-group">
								<label for="login_senha" class="small mb-1">Senha</label>
								<input type="password" id="login_senha" placeholder="Senha" name="login_senha" class="form-control py-4" required>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block" name="login_botao">Entrar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	if (isset($_POST["login_botao"])) {
		validar_login($_POST["login_email"], $_POST["login_senha"]);
	}
	?>
	</div>
</section>