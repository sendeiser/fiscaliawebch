document.addEventListener('DOMContentLoaded', function() {
  const userMenuToggle = document.getElementById('userMenuToggle');
  const userDropdown = document.getElementById('userDropdown');
  const userMenuName = document.getElementById('userMenuName');
  const ddUserName = document.getElementById('ddUserName');
  const ddUserRole = document.getElementById('ddUserRole');
  const btnEditProfile = document.getElementById('btnEditProfile');
  const btnLogout = document.getElementById('btnLogout');

  // Toggle del menú de usuario
  if (userMenuToggle && userDropdown) {
    userMenuToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      const isShown = userDropdown.classList.contains('show');
      userDropdown.classList.toggle('show');
      userMenuToggle.setAttribute('aria-expanded', String(!isShown));
      userDropdown.setAttribute('aria-hidden', String(isShown));
    });

    document.addEventListener('click', function(e) {
      if (!userDropdown.contains(e.target) && !userMenuToggle.contains(e.target)) {
        userDropdown.classList.remove('show');
        userMenuToggle.setAttribute('aria-expanded', 'false');
        userDropdown.setAttribute('aria-hidden', 'true');
      }
    });
  }

  // Cargar datos del perfil
  function loadProfile() {
    fetch('/phpserv/get_profile.php', { method: 'GET' })
      .then(res => res.json())
      .then(data => {
        if (data && data.status === 'success' && data.user) {
          const u = data.user;
          const nombreCompleto = [u.Nombre, u.Apellido].filter(Boolean).join(' ').trim() || (u.usuario || 'Usuario');
          userMenuName && (userMenuName.textContent = nombreCompleto);
          ddUserName && (ddUserName.textContent = nombreCompleto);
          ddUserRole && (ddUserRole.textContent = (u.rol || 'Usuario'));
          // Prellenar formulario si existe
          fillProfileForm(u);
          // Actualizar avatar en navbar y dropdown
          const avatarImg = document.getElementById('userAvatarImg');
          const avatarIcon = document.getElementById('userAvatarIcon');
          const ddAvatarImg = document.getElementById('ddUserAvatarImg');
          const ddAvatarIcon = document.getElementById('ddUserAvatarIcon');

          const hasPhoto = !!(u.foto && String(u.foto).trim());
          if (hasPhoto) {
            if (avatarImg) { avatarImg.src = u.foto; avatarImg.classList.remove('hidden'); }
            if (avatarIcon) { avatarIcon.classList.add('hidden'); }
            if (ddAvatarImg) { ddAvatarImg.src = u.foto; ddAvatarImg.classList.remove('hidden'); }
            if (ddAvatarIcon) { ddAvatarIcon.classList.add('hidden'); }
          } else {
            if (avatarImg) { avatarImg.classList.add('hidden'); }
            if (avatarIcon) { avatarIcon.classList.remove('hidden'); }
            if (ddAvatarImg) { ddAvatarImg.classList.add('hidden'); }
            if (ddAvatarIcon) { ddAvatarIcon.classList.remove('hidden'); }
          }
        }
      })
      .catch(err => console.error('Error al obtener el perfil:', err));
  }

  // Modal de edición de perfil
  const modalBackdrop = document.getElementById('profileModalBackdrop');
  const profileForm = document.getElementById('profileForm');
  const inputFoto = document.getElementById('perfilFoto');
  const previewImg = document.getElementById('perfilPreviewImg');

  function openProfileModal() {
    if (modalBackdrop) {
      modalBackdrop.classList.add('show');
    }
  }
  function closeProfileModal() {
    if (modalBackdrop) {
      modalBackdrop.classList.remove('show');
    }
  }

  function fillProfileForm(u) {
    const map = {
      usuario: 'perfilUsuario',
      Nombre: 'perfilNombre',
      Apellido: 'perfilApellido',
      Correo: 'perfilCorreo',
      Celular: 'perfilCelular'
    };
    Object.keys(map).forEach(key => {
      const el = document.getElementById(map[key]);
      if (el && typeof u[key] !== 'undefined') el.value = u[key] || '';
    });
    if (previewImg && u.foto) {
      previewImg.src = u.foto;
    }
  }

  if (btnEditProfile) {
    btnEditProfile.addEventListener('click', function() {
      openProfileModal();
    });
  }

  const btnCloseModal = document.getElementById('btnCloseProfile');
  const btnCancelModal = document.getElementById('btnCancelProfile');
  btnCloseModal && btnCloseModal.addEventListener('click', closeProfileModal);
  btnCancelModal && btnCancelModal.addEventListener('click', closeProfileModal);

  // Previsualización de foto
  if (inputFoto && previewImg) {
    inputFoto.addEventListener('change', function() {
      const file = this.files && this.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = function(e) { previewImg.src = e.target.result; };
      reader.readAsDataURL(file);
    });
  }

  // Envío del formulario de perfil
  if (profileForm) {
    profileForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const fd = new FormData(profileForm);

      const pass = fd.get('perfilContrasena');
      const pass2 = fd.get('perfilContrasenaConfirm');
      if (pass || pass2) {
        if (String(pass) !== String(pass2)) {
          return Swal.fire({ icon:'warning', title:'Validación', text:'Las contraseñas no coinciden.' });
        }
      }

      fetch('/phpserv/update_profile.php', { method:'POST', body: fd })
        .then(res => res.json())
        .then(data => {
          if (data && data.status === 'success') {
            Swal.fire({ icon:'success', title:'Perfil actualizado', text:'Los cambios han sido guardados.' });
            closeProfileModal();
            loadProfile(); // refresca nombre y avatar
          } else {
            Swal.fire({ icon:'error', title:'Error', text: (data && data.message) || 'No se pudo actualizar el perfil.' });
          }
        })
        .catch(err => {
          console.error('Error al actualizar perfil:', err);
          Swal.fire({ icon:'error', title:'Error', text:'Ocurrió un error al actualizar el perfil.' });
        });
    });
  }

  // Cerrar sesión
  if (btnLogout) {
    btnLogout.addEventListener('click', function() {
      fetch('/phpserv/logout.php', { method:'POST' })
        .then(res => res.json())
        .then(data => {
          if (data && data.status === 'success') {
            window.location.href = 'Login.html';
          } else {
            Swal.fire({ icon:'error', title:'Error', text:'No se pudo cerrar sesión.' });
          }
        })
        .catch(err => {
          console.error('Error al cerrar sesión:', err);
          Swal.fire({ icon:'error', title:'Error', text:'Ocurrió un error al cerrar sesión.' });
        });
    });
  }

  // Inicializar
  loadProfile();
});