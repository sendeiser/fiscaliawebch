(function(){
  function log(text, ok){
    var el = document.createElement('div');
    el.className = 'list-group-item ' + (ok ? 'list-group-item-success' : 'list-group-item-danger');
    el.textContent = (ok ? 'OK: ' : 'ERROR: ') + text;
    document.getElementById('results').appendChild(el);
  }
  function clickSelector(sel){
    var b = document.querySelector(sel);
    if (b) b.click();
  }
  function delay(ms){ return new Promise(function(res){ setTimeout(res, ms); }); }
  async function testAccept(){
    var calls = 0;
    var originalFetch = window.fetch;
    window.fetch = function(){ calls++; return Promise.resolve({ json: function(){ return Promise.resolve({status:'success'}); } }); };
    window.redirectToLogin = function(){ document.body.setAttribute('data-redirect','1'); };
    LogoutDialog.show();
    await delay(100);
    clickSelector('.logout-confirm, .swal2-confirm');
    await delay(200);
    var ok = document.body.getAttribute('data-redirect') === '1' && calls > 0;
    log('Aceptar ejecuta logout y redirige', ok);
    window.fetch = originalFetch;
    document.body.removeAttribute('data-redirect');
  }
  async function testCancel(){
    var calls = 0;
    var originalFetch = window.fetch;
    window.fetch = function(){ calls++; return Promise.resolve({ json: function(){ return Promise.resolve({status:'success'}); } }); };
    LogoutDialog.show();
    await delay(100);
    clickSelector('.logout-cancel, .swal2-cancel');
    await delay(200);
    var ok = calls === 0 && !document.body.getAttribute('data-redirect');
    log('Cancelar cierra modal sin cambios', ok);
    window.fetch = originalFetch;
  }
  async function run(){
    document.getElementById('results').innerHTML='';
    await testAccept();
    await testCancel();
  }
  var btn = document.getElementById('run');
  if (btn) btn.addEventListener('click', function(){ run(); });
  if (document.readyState!=='loading'){ } else { document.addEventListener('DOMContentLoaded', function(){}); }
})();