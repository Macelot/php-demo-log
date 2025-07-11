<?php
require_once __DIR__ . '/../setup.php';

require_once __DIR__ . '/../vendor/autoload.php'; // Garante que o Google_Client exista

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$client = new Google_Client();
$client->setClientId(getenv('GOOGLE_CLIENT_ID'));
$client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
$client->setRedirectUri(getenv('GOOGLE_REDIRECT_URI'));
$client->addScope('email');
$client->addScope('profile');

$authUrl = $client->createAuthUrl();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Seguro com QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body class="p-5 bg-light">

    <div class="container text-center">
        <h1 class="mb-4">Acesse com Google</h1>

        <!-- QR Code de exemplo -->
        <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo urlencode($authUrl); ?>&amp;size=200x200" alt="Login com Google QRCode">

        <p class="mt-3">Escaneie com o celular para fazer login com sua conta Google.</p>

        <hr class="my-5">

       <h3 id="titulo-usuarios" style="display:none;">Usuários autenticados nos últimos 30 minutos</h3>
        <table class="table table-striped" id="users-table" style="display:none;">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Quando</th>
                </tr>
            </thead>
            <tbody>
                <!-- Preenchido via AJAX -->
            </tbody>
        </table>
    </div>

<script>
function atualizarUsuarios() {
    $.get('ajax_users.php', function(data) {
        if (data.trim() === '') {
            $('#titulo-usuarios').hide();
            $('#users-table').hide();
        } else {
            $('#titulo-usuarios').show();
            $('#users-table').show();
            $('#users-table tbody').html(data);
        }
    });
}

setInterval(atualizarUsuarios, 5000);
atualizarUsuarios();
</script>

</body>
</html>
