<?php

class ProfileController extends Controller
{
    public function index()
    {
        // Verifica se o usuário está autenticado
        if (!isset($_SESSION["user"])) {
            header("Location: /login");
            exit;
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($_SESSION["user"]["email"]);

        // Busca os dados biométricos do usuário
        $read = new Read();
        $read->ExeRead('dados_usuarios', "WHERE usuario_id = :id", "id={$user['id']}");
        $dadosUsuario = $read->getResult() ? $read->getResult()[0] : null;

        $this->render('profile/index', [
            'user' => $user,
            'dadosUsuario' => $dadosUsuario
        ]);
    }

    public function update()
    {
        // Valida o token CSRF
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setErrorAndRedirect(
                "Requisição inválida. Token CSRF inválido.",
                "/profile",
                "Erro de Segurança",
                "error"
            );
            return;
        }

        // Valida os campos obrigatórios
        if (empty($_POST['name']) || empty($_POST['email'])) {
            $this->setErrorAndRedirect(
                "Nome e email são campos obrigatórios.",
                "/profile",
                "Erro de Validação",
                "warning"
            );
            return;
        }

        // Valida o email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->setErrorAndRedirect(
                "Email inválido. Por favor, informe um email válido.",
                "/profile",
                "Erro de Validação",
                "warning"
            );
            return;
        }

        // Remove o campo csrf_token dos dados
        unset($_POST['csrf_token']);

        // Obtém o ID do usuário atual
        $userModel = new UserModel();
        $user = $userModel->findByEmail($_SESSION["user"]["email"]);
        $userId = $user['id'];

        // Prepara os dados do usuário para atualização
        $userData = [
            'name' => $_POST['name'],
            'email' => $_POST['email']
        ];

        // Se a senha foi fornecida, atualiza a senha
        if (!empty($_POST['password']) && !empty($_POST['password_confirmation'])) {
            if ($_POST['password'] !== $_POST['password_confirmation']) {
                $this->setErrorAndRedirect(
                    "As senhas não coincidem.",
                    "/profile",
                    "Erro de Validação",
                    "warning"
                );
                return;
            }
            $userData['password'] = fldCrip($_POST['password'], 0);
        }

        // Remove os campos que não pertencem à tabela de usuários
        unset($_POST['name']);
        unset($_POST['email']);
        unset($_POST['password']);
        unset($_POST['password_confirmation']);

        // Atualiza os dados do usuário
        $result = $userModel->updateUser($userId, $userData);

        // Prepara os dados biométricos para atualização
        $dadosUsuarioData = [
            'peso' => $_POST['peso'] ?? null,
            'altura' => $_POST['altura'] ?? null,
            'data_nascimento' => $_POST['data_nascimento'] ?? null,
            'atividade_fisica' => $_POST['atividade_fisica'] ?? null,
            'objetivo' => $_POST['objetivo'] ?? null
        ];

        // Verifica se já existem dados biométricos para o usuário
        $read = new Read();
        $read->ExeRead('dados_usuarios', "WHERE usuario_id = :id", "id={$userId}");
        $dadosUsuarioExistente = $read->getResult();

        if ($dadosUsuarioExistente) {
            // Atualiza os dados biométricos existentes
            $update = new Update();
            $update->ExeUpdate('dados_usuarios', $dadosUsuarioData, 'WHERE usuario_id = :id', "id={$userId}");
            $resultDados = $update->getResult();
        } else {
            // Cria novos dados biométricos
            $dadosUsuarioData['usuario_id'] = $userId;
            $create = new Create();
            $create->ExeCreate('dados_usuarios', $dadosUsuarioData);
            $resultDados = $create->getResult();
        }

        // Atualiza os dados da sessão
        $_SESSION["user"]["name"] = $userData['name'];
        $_SESSION["user"]["email"] = $userData['email'];

        if ($result || $resultDados) {
            $this->setSuccessAndRedirect(
                "Perfil atualizado com sucesso!",
                "/profile"
            );
        } else {
            $this->setErrorAndRedirect(
                "Erro ao atualizar perfil. Por favor, tente novamente.",
                "/profile",
                "Erro no Sistema",
                "error"
            );
        }
    }
}