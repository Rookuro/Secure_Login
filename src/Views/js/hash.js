var formulaire = document.getElementById('form');

window.addEventListener('DOMContentLoaded', function () {
  // Récupérer le formulaire

  // Ajouter un écouteur d'événement pour l'événement de soumission
  formulaire.addEventListener('submit', async function (e) {
    e.preventDefault(); // Empêcher l'envoi du formulaire par défaut

    var submitValue = document.getElementsByName('sub')[0].value;

    if (submitValue === 'register') {
      console.log("register");
      register();
    } else if (submitValue === 'changePass') {
      console.log("changePass");
      changePass();
    } else {
      console.log("login");
      login();
    }
  });
});

function verifPass(pass, pass2) {
  // Check if passwords are same
  if (pass !== pass2) {
    return "Les mots de passe ne correspondent pas !";
  }
  // Check pass length
  if (pass.length < 8) {
    return "Le mot de passe doit contenir au moins 8 caractères";
  }
  // Check if password contains uppercase
  if (!/[A-Z]/.test(pass)) {
    return "Le mot de passe doit contenir au moins une majuscule !";
  }
  // Check if password contains lowercase
  if (!/[a-z]/.test(pass)) {
    return "Le mot de passe doit contenir au moins une minuscule !";
  }
  // Check if password contains number
  if (!/[0-9]/.test(pass)) {
    return "Le mot de passe doit contenir au moins un chiffre !";
  }
  // Check if password contains special character
  if (!/[^A-Za-z0-9]/.test(pass)) {
    return "Le mot de passe doit contenir au moins un caractère spécial !";
  }
  // If all is good
  return null;
}

async function hash(message) {
  // Convertir la chaîne de caractères en ArrayBuffer
  const encoder = new TextEncoder();
  const data = encoder.encode(message);

  // Calculer le hachage SHA-512
  const hashBuffer = await crypto.subtle.digest('SHA-512', data);

  // Convertir le résultat ArrayBuffer en chaîne hexadécimale
  const hashArray = Array.from(new Uint8Array(hashBuffer));
  const hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join('');

  return hashHex;
}

async function register() {
  const valuePass = document.getElementById('pass').value;
  const valuePass2 = document.getElementById('pass2').value;
  if (verifPass(valuePass, valuePass2) == null) {
    document.getElementById('pass').value = await hash(valuePass);
    document.getElementById('pass2').value = await hash(valuePass2);
    formulaire.submit();
  } else {
    document.getElementById('passError').innerHTML = verifPass(valuePass, valuePass2);
  }
}

async function changePass() {
  const valuePass = document.getElementById('pass').value;
  const valueNewPass = document.getElementById('newPass').value;
  const valueNewPass2 = document.getElementById('newPass2').value;
  if (verifPass(valueNewPass, valueNewPass2) == null) {
    document.getElementById('pass').value = await hash(valuePass);
    document.getElementById('newPass').value = await hash(valueNewPass);
    document.getElementById('newPass2').value = await hash(valueNewPass2);
    formulaire.submit();
  } else {
    document.getElementById('passError').innerHTML = verifPass(valueNewPass, valueNewPass2);
  }
}

async function login() {
  const valuePass = document.getElementById('pass').value;
  document.getElementById('pass').value = await hash(valuePass);
  formulaire.submit();
}