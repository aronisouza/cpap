<?php
isset($_SESSION["user"]) ? header("Location: /") : "";
?>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 min-vh-100 d-flex align-items-center justify-content-center w-100">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4">Login</h4>

                    <form action="/login" method="POST" id="loginForm">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken(); ?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><?= fldIco("mail") ?></span>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text"><?= fldIco("key") ?></span>
                                <input type="password" class="form-control" id="password" name="password" required>

                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>