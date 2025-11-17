/*
  GestorBeta Session Guard
  Propósito: Implementar cierre de sesión automático por inactividad exclusivo para el entorno GestorBeta.
  Alcance: Solo se ejecuta en páginas de GestorBeta; no afecta Login ni otras secciones.
  Características: Temporizador de 60s, aviso 10s antes, opción de extender sesión, cierre seguro y registro de auditoría en backend.
*/

(function(){
  if (window.GestorBetaSessionGuard) return;

  function isGestorBetaEnv(){
    try {
      var path = String(window.location.pathname || '').toLowerCase();
      if (path.indexOf('login') !== -1) return false;
      if (path.indexOf('gestorbeta') !== -1) return true;
      var body = document.body;
      if (body && body.classList && body.classList.contains('gestorbeta')) return true;
      var meta = document.querySelector('meta[name="app-env"]');
      if (meta && String(meta.getAttribute('content') || '').toLowerCase() === 'gestorbeta') return true;
      return false;
    } catch (e) {
      console.error('Detección de entorno GestorBeta falló:', e);
      return false;
    }
  }

  var guard = {
    limit: 60000,
    warning: 10000,
    inactivityTimer: null,
    warningTimer: null,
    warningShown: false,
    initialized: false,

    init: function(){
      if (this.initialized) return;
      if (!isGestorBetaEnv()) {
        console.info('GestorBeta no disponible o no detectado; SessionGuard inactivo.');
        return;
      }
      this.initialized = true;
      var events = ['mousemove','mousedown','keydown','scroll','touchstart'];
      var self = this;
      events.forEach(function(evt){ window.addEventListener(evt, function(){ self.reset(); }, { passive: true }); });
      this.start();
    },

    start: function(){
      clearTimeout(this.inactivityTimer);
      clearTimeout(this.warningTimer);
      this.warningShown = false;
      var self = this;
      this.warningTimer = setTimeout(function(){ self.showWarning(); }, this.limit - this.warning);
      this.inactivityTimer = setTimeout(function(){ self.autoLogout(); }, this.limit);
    },

    reset: function(){
      this.start();
      if (this.warningShown) {
        try { if (window.Swal && Swal.isVisible()) Swal.close(); } catch(_){}
        this.warningShown = false;
      }
    },

    showWarning: function(){
      this.warningShown = true;
      var self = this;
      if (window.Swal) {
        Swal.fire({
          icon: 'warning',
          title: 'Sesión a punto de finalizar',
          html: 'Por inactividad la sesión se cerrará en <b></b> segundos.',
          timer: this.warning,
          timerProgressBar: true,
          allowOutsideClick: false,
          allowEscapeKey: false,
          allowEnterKey: false,
          showCancelButton: true,
          showConfirmButton: true,
          focusConfirm: true,
          buttonsStyling: true,
          reverseButtons: true,
          cancelButtonText: 'Cerrar sesión ahora',
          confirmButtonText: 'Mantener sesión',
          didOpen: function(){
            var b = Swal.getHtmlContainer().querySelector('b');
            var i = setInterval(function(){
              if (!Swal.isVisible()) { clearInterval(i); return; }
              if (b) { var left = Math.ceil(Swal.getTimerLeft()/1000); b.textContent = left; }
            }, 200);
          }
        }).then(function(result){
          self.warningShown = false;
          if (result.dismiss === Swal.DismissReason.timer) {
            self.autoLogout();
          } else if (result.isConfirmed) {
            fetch('/phpserv/get_profile.php', { method: 'GET' }).catch(function(){});
            self.start();
          } else if (result.isDismissed) {
            self.autoLogout();
          }
        });
      } else {
        try {
          var keep = window.confirm('La sesión se cerrará por inactividad. ¿Desea mantenerla?');
          this.warningShown = false;
          if (keep) {
            fetch('/phpserv/get_profile.php', { method: 'GET' }).catch(function(){});
            this.start();
          } else {
            this.autoLogout();
          }
        } catch (e) {
          console.error('Advertencia de inactividad falló:', e);
          this.autoLogout();
        }
      }
    },

    autoLogout: function(){
      clearTimeout(this.inactivityTimer);
      clearTimeout(this.warningTimer);
      try {
        fetch('/phpserv/logout.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'reason=auto_inactivity'
        })
        .then(function(res){ return res.json(); })
        .then(function(){ window.location.href = 'Login.html'; })
        .catch(function(){ window.location.href = 'Login.html'; });
      } catch (e) {
        console.error('Cierre automático falló:', e);
        window.location.href = 'Login.html';
      }
    }
  };

  window.GestorBetaSessionGuard = guard;
  document.addEventListener('DOMContentLoaded', function(){ guard.init(); });
})();