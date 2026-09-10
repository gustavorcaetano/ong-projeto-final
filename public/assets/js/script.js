fetch('/api/familias')
  .then(response => response.json())
  .then(data => {
      console.log("Familias via AJAX:", data);
      // Suas animações GSAP rodam aqui sem interferência
  });