<?php 
    isset($_SESSION["user"]) ? header("Location: /") : "";
?>
<div class="container mt-5 ">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow position-absolute top-50 start-50 translate-middle">
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
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <?= fldIco("visibility") ?>
                                </button>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                            <a href="/users/create" class="btn btn-outline-secondary">Criar Conta</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
