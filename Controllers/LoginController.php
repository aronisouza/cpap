<?php

class LoginController extends Controller
{
    public function index()
    {
        $this->render('Login/index');
    }

    public function store()
    {
        // Valida o token CSRF
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setErrorAndRedirect(
                "Requisição inválida. Token CSRF inválido.",
                "/login",
                "Erro de Segurança",
                "error"
            );
            return;
        }

        if (empty($_POST['password']) || empty($_POST['email'])) {
            $this->setErrorAndRedirect(
                "Todos os campos são obrigatórios.",
                "/login",
                "Erro de Validação",
                "warning"
            );
            return;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->setErrorAndRedirect(
                "Email inválido. Por favor, informe um email válido.",
                "/login",
                "Erro de Validação",
                "warning"
            );
            return;
        }

        // Remove o campo csrf_token dos dados
        unset($_POST['csrf_token']);

        try {
            $password = fldCrip($_POST['password'], 0);
            $email = $_POST['email'];

            $userModel = new UserModel();
            $result = $userModel->login($password, $email);

            if ($result) {
                $_SESSION['user'] = $result;
                $this->setSuccessAndRedirect(
                    "Agora você está logado.",
                    "/"
                );
            } else {
                $this->setErrorAndRedirect(
                    "Erro ao Logar. Por favor, tente novamente.",
                    "/login",
                    "Erro no Sistema",
                    "error"
                );
            }
        } catch (Exception $e) {
            $this->setErrorAndRedirect(
                "Erro ao processar sua solicitação.",
                "/login",
                "Alerta de Validação",
                "warning"
            );
            return;
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
