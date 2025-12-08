function actualizar(){location.reload(true);} 

// Inject styles for Access Modal theme once (now using CSS variables per page)
(function injectAccessModalStyles(){
  if (document.getElementById('access-modal-styles')) return;
  const css = [
    ".swal2-popup.access-modal{background:linear-gradient(135deg,var(--modal-bg1,#4c9e88),var(--modal-bg2,#3b7f6f));color:var(--modal-text,#eaf7f3);border-radius:18px;box-shadow:0 12px 40px rgba(0,0,0,.25)}",
    ".swal2-popup.access-success{background:var(--modal-text,#eaf7f3);color:#225c4f;border-radius:16px}",
    ".access-title{font-family:'Poppins','Inter',sans-serif;font-weight:700;color:#00e883;margin-bottom:.25rem}",
    ".access-html{font-size:1rem;color:var(--modal-text,#eaf7f3);opacity:.9;margin-top:.25rem}",
    ".access-input{border-radius:12px;border:2px solid rgba(255,255,255,.25);background:rgba(255,255,255,.15);color:#103d33}",
    ".access-input::placeholder{color:#cfe9e2}",
    ".access-actions{gap:.75rem}",
    ".access-confirm{background:linear-gradient(135deg,var(--modal-confirm-bg1,#3cb371),var(--modal-confirm-bg2,#2e8b57))!important;color:#fff!important;border:none!important;border-radius:12px;padding:.6rem 1.2rem;font-weight:600}",
    ".access-confirm:hover{filter:brightness(1.05)}",
    ".access-cancel{background:linear-gradient(135deg,var(--modal-cancel-bg1,#2645b8),var(--modal-cancel-bg2,#1a35ac))!important;color:#fff!important;border:none!important;border-radius:12px;padding:.6rem 1.2rem;font-weight:600}",
    ".swal2-icon.access-icon{border-color:var(--modal-icon-border,#ffd000)!important}"
  ].join("\n");
  const style = document.createElement('style');
  style.id = 'access-modal-styles';
  style.textContent = css;
  document.head.appendChild(style);
})();

Swal.fire({
    title: 'Contraseña de Acceso',
    input: 'password',
    icon: 'warning',
    html:
      'Para poder ingresar necesita ser un empleado de fiscalía y pedir su contraseña en la misma.',
    inputPlaceholder: 'Ingrese la contraseña',
    iconColor: '#ffd000',
    allowOutsideClick: false,
    allowEnterKey: false,
    allowEscapeKey: false,
    showCancelButton: true,
    reverseButtons: true,
    cancelButtonText: 'Volver',
    confirmButtonText: 'Confirmar',
    customClass: {
      popup: 'access-modal',
      title: 'access-title',
      htmlContainer: 'access-html',
      input: 'access-input',
      actions: 'access-actions',
      confirmButton: 'access-confirm',
      cancelButton: 'access-cancel',
      icon: 'access-icon'
    },
    inputAttributes: {
      maxLength: 64,
      autocapitalize: 'off',
      autocorrect: 'off'
    },
    inputValidator: (value) => {
      return new Promise((resolve) => {
        var v = String(value || '').trim();
        if (!v) { resolve('Ingrese la contraseña'); return; }
        fetch('/phpserv/check_pwrandom.php?pwd=' + encodeURIComponent(v), { method: 'GET' })
          .then(function(r){ return r.json(); })
          .then(function(j){
            if (j && j.status === 'success' && j.exists === true) { resolve(); }
            else { resolve('Contraseña incorrecta, vuelva a intentarlo.'); }
          })
          .catch(function(){ resolve('Error de verificación, intente nuevamente.'); });
      })
    }
}).then(function(result){
  if (result.dismiss === Swal.DismissReason.cancel) {
    window.location.href = 'index.html';
    return;
  }
  if (result.isConfirmed) {
    var v = String(result.value || '').trim();
    try {
      window.accessPassword = v;
      var field = document.getElementById('contrasena');
      if (field) {
        field.value = v;
        var ev = new Event('input', { bubbles: true });
        field.dispatchEvent(ev);
        var ev2 = new Event('blur', { bubbles: true });
        field.dispatchEvent(ev2);
      }
    } catch(_){ }
  }
});