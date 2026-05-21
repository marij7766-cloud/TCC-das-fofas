<?php
session_start();
include("conexao.php");


$email = $_SESSION['email'];

// busca usuário
$resultado = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");

if (!$resultado) {
    die("Erro na query: " . mysqli_error($con));
}

$usuario = mysqli_fetch_assoc($resultado);

if (!$usuario) {
    die("Usuário não encontrado no banco");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Perfil</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">



    <link href="perfil.css" rel="stylesheet">

</head>
<body>
 <header class="header">
    <div style="display: flex; align-items: center; gap: 0.5rem;">
      <a href="logado.html">
        <i class="fas fa-arrow-left" style="font-size: 1.25rem; color: #136BA9; cursor: pointer;"></i>
      </a>
      <h1>PasseAdiante</h1>
    </div>
  </header>

<main class="container">
  <div style="max-width:900px;margin:0 auto;">
    <div class="profile-header">
      <div class="avatar" id="avatarDisplay">
        <span class="avatar-initials" id="avatarInitials"></span>
      </div>
      <div class="profile-info">
        <div class="profile-top">
          <div class="profile-name-row">
            <h1 class="profile-name" id="displayName"></h1>
          </div>
          <button class="btn btn-outline btn-sm" onclick="openEditor()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Editar Perfil
          </button>
        </div>
        <div class="profile-meta">
         <!--  <span>
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span id="displayCity">São Paulo, SP</span>
          </span>
          <span> 
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Membro desde Jan 2024
          </span>-->
        </div>
        <p class="profile-bio" id="displayBio"></p>
      </div>
    </div>
    <div class="tabs">
      <div class="tabs-list">
        <button class="tab-trigger active" onclick="switchTab('anuncios', this)">Meus Anúncios</button>
        <button class="tab-trigger" onclick="switchTab('favoritos', this)">Favoritos</button>
      </div>

      <div class="tab-content active" id="tab-anuncios">
        <div class="product-grid" id="productGrid"></div>
      </div>
      <div class="tab-content" id="tab-favoritos">
        <p class="empty-state">Nenhum favorito ainda.</p>
      </div>
    </div>
  </div>
</main>

<div class="dialog-overlay" id="dialogOverlay" onclick="handleOverlayClick(event)">
  <div class="dialog">
    <div>
      <h2 class="dialog-title">Editar Perfil</h2>
      <p class="dialog-desc">Atualize sua foto e informações pessoais.</p>
    </div>

    <div class="avatar-editor">
      <div class="avatar-wrapper">
        <div class="avatar-lg" id="draftAvatarDisplay">
          <span class="avatar-lg-initials" id="draftAvatarInitials"></span>
        </div>
        <button class="camera-btn" onclick="fileInput.click()" aria-label="Trocar foto">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
        </button>
      </div>
      <button class="btn btn-outline btn-sm" onclick="fileInput.click()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        Enviar foto do dispositivo
      </button>
      <!-- muda esse dai tbm -->
      <button class="btn btn-danger" onclick="removefotoperfil()">Remover foto de perfil</button>
      <input type="file" id="fileInput" accept="image/*" class="hidden" style="display:none" onchange="handlePhotoPick(event)" />
    </div>

    <div class="form-grid">
      <div class="form-group">
        <label for="fieldName">Nome de Usuário</label>
        <input type="text" id="fieldName" oninput="updateDraftName(this.value)" />
      </div>
      <div class="form-group">
        <label for="fieldEmail">E-mail</label>
        <input type="email" id="fieldEmail" />
      </div>
      <div class="form-group">
        <label for="fieldPhone">Telefone</label>
        <input type="text" id="fieldPhone" />
      </div>
    <!--  <div class="form-group">
        <label for="fieldCity">Cidade / Estado</label>
        <input type="text" id="fieldCity" />
      </div> 

      <div class="form-group">
        <label for="fieldBio">Sobre você</label>
        <textarea id="fieldBio" rows="4"></textarea>
      </div>
    </div>-->

    <div class="dialog-footer">
      <button class="btn btn-outline" onclick="closeDialog()">Cancelar</button>
      <!-- coloca esse botao vermelho ae -->
      <button class="btn btn-danger" onclick="deletaPerfil()"> Apagar perfil </button>
      <button class="btn btn-petrol" onclick="handleSave()">Salvar alterações</button>
    </div>
  </div>
</div>
<div id="toast">
  <strong>Perfil atualizado</strong>
  Suas informações foram salvas.
</div>
<script>
  // Dados iniciais do perfil vindos do PHP
 const initialProfile = 
 {
    name: "<?php echo $usuario['nome']; ?>",
    email: "<?php echo $usuario['email']; ?>",
    phone: "<?php echo $usuario['telefone']; ?>",
    
    avatarUrl: null,
 };
</script>
  <script src="perfil.js">
  </script>
</body>
</html>