

  // Produtos de exemplo
  const mockProducts = 
  [
    { id: 1, title: "Camisa Escolar M", price: "R$ 25,00" },
    { id: 2, title: "Calça Uniforme P", price: "R$ 30,00" },
  ];

  let profile = { ...initialProfile };
  let draft = { ...initialProfile };

  // Pega as iniciais do nome
  function getInitials(name) 
  {
    return name.trim().split(/\s+/).slice(0, 2).map(n => (n[0] || "").toUpperCase()).join("");
  }

  // Renderiza avatar
  function renderAvatar(container, initialsEl, imgEl, data) 
  {
    if (data.avatarUrl) 
    {
      if (!imgEl) {
        container.innerHTML = `<img src="${data.avatarUrl}" alt="${data.name}" style="width:100%;height:100%;object-fit:cover">`;
      } else {
        imgEl.src = data.avatarUrl;
        if (initialsEl) initialsEl.style.display = "none";
        imgEl.style.display = "";
      }
    } else 
      {
      container.innerHTML = `<span class="${container.classList.contains('avatar-lg') ? 'avatar-lg-initials' : 'avatar-initials'}">${getInitials(data.name)}</span>`;
      }
  }


// Mostra os produtos
  function renderProducts() 
  {
    const grid = document.getElementById("productGrid");
    grid.innerHTML = mockProducts.map(p => `
      <div class="product-card">
        <div class="product-img">📦</div>
        <div class="product-body">
          <div class="product-title">${p.title}</div>
          <div class="product-price">${p.price}</div>
        </div>
      </div>
    `).join("");
  }
  
  // Atualiza informações do perfil  TEMPORAMENTE
  function renderProfile() 
  {
    document.getElementById("displayName").textContent = profile.name;
    //document.getElementById("displayBio").textContent = profile.bio;
    const avatarDisplay = document.getElementById("avatarDisplay");
    if (profile.avatarUrl) 
      {
      avatarDisplay.innerHTML = `<img src="${profile.avatarUrl}" alt="${profile.name}" style="width:100%;height:100%;object-fit:cover">`;
      } else 
        {
      avatarDisplay.innerHTML = `<span class="avatar-initials">${getInitials(profile.name)}</span>`;
        }
  }

  function renderDraftAvatar()
  {
    const el = document.getElementById("draftAvatarDisplay");
    if (draft.avatarUrl) 
      {
      el.innerHTML = `<img src="${draft.avatarUrl}" alt="Prévia" style="width:100%;height:100%;object-fit:cover">`;
      } 
      else 
      {
      el.innerHTML = `<span class="avatar-lg-initials">${getInitials(draft.name)}</span>`;
      }
  }

  // Abas
  function switchTab(name, btn) {
    document.querySelectorAll(".tab-content").forEach(el => el.classList.remove("active"));
    document.querySelectorAll(".tab-trigger").forEach(el => el.classList.remove("active"));
    document.getElementById("tab-" + name).classList.add("active");
    btn.classList.add("active");
  }

  //Abre a aba de editar perfil
  function openEditor() 
  {
    draft = { ...profile };
    document.getElementById("fieldName").value = draft.name;
    document.getElementById("fieldEmail").value = draft.email;
    document.getElementById("fieldPhone").value = draft.phone;
    //document.getElementById("fieldBio").value = draft.bio;
    renderDraftAvatar();
    document.getElementById("dialogOverlay").classList.add("open");
  }
   
  // Fecha
  function closeDialog() 
  {
    document.getElementById("dialogOverlay").classList.remove("open");
  }
  
  // Fecha modal ao clicar fora
  function handleOverlayClick(e) 
  {
    if (e.target === document.getElementById("dialogOverlay")) closeDialog();
  }

  function updateDraftName(val) 
  {
    draft.name = val;
    renderDraftAvatar();
  }

  function handlePhotoPick(e) 
  {
    const file = e.target.files?.[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (ev) => 
      {
      draft.avatarUrl = ev.target?.result ?? null;
      renderDraftAvatar();
      };
    reader.readAsDataURL(file);
  }

  function handleSave() 
  {
    profile = 
    {
      name: document.getElementById("fieldName").value,
      email: document.getElementById("fieldEmail").value,
      phone: document.getElementById("fieldPhone").value,
      //bio: document.getElementById("fieldBio").value,
      avatarUrl: draft.avatarUrl,
    };

    renderProfile();
    closeDialog();
    showToast();
  }

  // Toast
  function showToast() 
  {
    const toast = document.getElementById("toast");
    toast.classList.add("show");
    setTimeout(() => toast.classList.remove("show"), 3000);
  }

  function deletaPerfil() 
  {
  Swal.fire({
    title: "Tem certeza?",
    text: "Seu perfil será apagado permanentemente!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Apagar",
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (!result.isConfirmed) return;
 
    fetch("deletarperfil.php", {
      method: "POST"
    })
    .then(res => res.text())
    .then(data => {
      Swal.fire({
        title: "Feito!",
        icon: "success"
      }).then(() => {
        window.location.href = "index.html";
      });
    });
  });
}

function removefotoperfil() {
  fetch("removefoto.php", {
    method: "POST"
  })
  .then(res => res.text())
  .then(() => {
    location.reload();
  });
}

  renderProducts();
  renderProfile();
