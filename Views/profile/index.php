<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="/profile/update" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <h5>Informações Pessoais</h5>
                            <hr>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <h5>Dados Biométricos</h5>
                            <hr>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="peso" class="form-label">Peso (kg)</label>
                            <input type="number" step="0.01" class="form-control" id="peso" name="peso" value="<?= htmlspecialchars($dadosUsuario['peso'] ?? '') ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="altura" class="form-label">Altura (m)</label>
                            <input type="number" step="0.01" class="form-control" id="altura" name="altura" value="<?= htmlspecialchars($dadosUsuario['altura'] ?? '') ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?= htmlspecialchars($dadosUsuario['data_nascimento'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="atividade_fisica" class="form-label">Nível de Atividade Física</label>
                            <select class="form-select" id="atividade_fisica" name="atividade_fisica">
                                <option value="">Selecione...</option>
                                <option value="sedentario" <?= ($dadosUsuario['atividade_fisica'] ?? '') == 'sedentario' ? 'selected' : '' ?>>Sedentário</option>
                                <option value="leve" <?= ($dadosUsuario['atividade_fisica'] ?? '') == 'leve' ? 'selected' : '' ?>>Leve</option>
                                <option value="moderado" <?= ($dadosUsuario['atividade_fisica'] ?? '') == 'moderado' ? 'selected' : '' ?>>Moderado</option>
                                <option value="ativo" <?= ($dadosUsuario['atividade_fisica'] ?? '') == 'ativo' ? 'selected' : '' ?>>Ativo</option>
                                <option value="muito_ativo" <?= ($dadosUsuario['atividade_fisica'] ?? '') == 'muito_ativo' ? 'selected' : '' ?>>Muito Ativo</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="objetivo" class="form-label">Objetivo</label>
                            <select class="form-select" id="objetivo" name="objetivo">
                                <option value="">Selecione...</option>
                                <option value="emagrecimento" <?= ($dadosUsuario['objetivo'] ?? '') == 'emagrecimento' ? 'selected' : '' ?>>Emagrecimento</option>
                                <option value="ganho_massa" <?= ($dadosUsuario['objetivo'] ?? '') == 'ganho_massa' ? 'selected' : '' ?>>Ganho de Massa</option>
                                <option value="manutencao" <?= ($dadosUsuario['objetivo'] ?? '') == 'manutencao' ? 'selected' : '' ?>>Manutenção</option>
                            </select>
                        </div>
                    </div>

                    <?php if (isset($dadosUsuario['peso']) && isset($dadosUsuario['altura']) && $dadosUsuario['peso'] > 0 && $dadosUsuario['altura'] > 0): ?>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <h5>Informações Calculadas</h5>
                            <hr>
                        </div>
                        <?php 
                            // Cálculo do IMC
                            $imc = $dadosUsuario['peso'] / ($dadosUsuario['altura'] * $dadosUsuario['altura']);
                            
                            // Classificação do IMC
                            $classificacaoIMC = '';
                            $corIMC = '';
                            
                            if ($imc < 18.5) {
                                $classificacaoIMC = 'Abaixo do peso';
                                $corIMC = 'text-warning';
                            } elseif ($imc >= 18.5 && $imc < 25) {
                                $classificacaoIMC = 'Peso normal';
                                $corIMC = 'text-success';
                            } elseif ($imc >= 25 && $imc < 30) {
                                $classificacaoIMC = 'Sobrepeso';
                                $corIMC = 'text-warning';
                            } elseif ($imc >= 30 && $imc < 35) {
                                $classificacaoIMC = 'Obesidade Grau I';
                                $corIMC = 'text-danger';
                            } elseif ($imc >= 35 && $imc < 40) {
                                $classificacaoIMC = 'Obesidade Grau II';
                                $corIMC = 'text-danger';
                            } else {
                                $classificacaoIMC = 'Obesidade Grau III';
                                $corIMC = 'text-danger';
                            }
                            
                            // Cálculo da idade
                            $idade = null;
                            if (isset($dadosUsuario['data_nascimento'])) {
                                $dataNascimento = new DateTime($dadosUsuario['data_nascimento']);
                                $hoje = new DateTime();
                                $idade = $dataNascimento->diff($hoje)->y;
                            }
                            
                            // Cálculo da TMB (Taxa Metabólica Basal) usando a fórmula de Harris-Benedict
                            $tmb = null;
                            if ($idade !== null) {
                                // Supondo que o usuário é homem (simplificação)
                                $tmb = 88.362 + (13.397 * $dadosUsuario['peso']) + (4.799 * $dadosUsuario['altura'] * 100) - (5.677 * $idade);
                                
                                // Fator de atividade
                                $fatorAtividade = 1.2; // Sedentário (padrão)
                                switch ($dadosUsuario['atividade_fisica']) {
                                    case 'sedentario':
                                        $fatorAtividade = 1.2;
                                        break;
                                    case 'leve':
                                        $fatorAtividade = 1.375;
                                        break;
                                    case 'moderado':
                                        $fatorAtividade = 1.55;
                                        break;
                                    case 'ativo':
                                        $fatorAtividade = 1.725;
                                        break;
                                    case 'muito_ativo':
                                        $fatorAtividade = 1.9;
                                        break;
                                }
                                
                                // Gasto calórico diário
                                $gastoCaloricoTotal = $tmb * $fatorAtividade;
                            }
                        ?>
                        
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Índice de Massa Corporal (IMC)</h6>
                                    <p class="card-text fs-4"><?= number_format($imc, 2, ',', '.') ?> kg/m²</p>
                                    <p class="card-text <?= $corIMC ?> fw-bold"><?= $classificacaoIMC ?></p>
                                    <p class="card-text small text-muted">O IMC é uma medida que relaciona peso e altura para avaliar se uma pessoa está com peso adequado.</p>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($idade !== null && $tmb !== null): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Metabolismo Basal</h6>
                                    <p class="card-text fs-4"><?= number_format($tmb, 0, ',', '.') ?> kcal</p>
                                    <p class="card-text">Gasto diário: <span class="fw-bold"><?= number_format($gastoCaloricoTotal, 0, ',', '.') ?> kcal</span></p>
                                    <p class="card-text small text-muted">A Taxa Metabólica Basal (TMB) é a quantidade mínima de energia que seu corpo precisa para funcionar em repouso.</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary d-inline-flex align-items-center justify-content-center gap-2">
                            <?= fldIco("save", 24, "text-white"); ?> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script nonce="<?= $_SESSION['csp_nonce']; ?>">
    // Validação de senha
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmation = this.value;
        
        if (password !== confirmation) {
            this.setCustomValidity('As senhas não coincidem');
        } else {
            this.setCustomValidity('');
        }
    });
    
    document.getElementById('password').addEventListener('input', function() {
        const confirmation = document.getElementById('password_confirmation').value;
        
        if (confirmation && this.value !== confirmation) {
            document.getElementById('password_confirmation').setCustomValidity('As senhas não coincidem');
        } else if (confirmation) {
            document.getElementById('password_confirmation').setCustomValidity('');
        }
    });
</script>