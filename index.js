// Ativa os ícones
lucide.createIcons();

    // Seleciona os os links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => 
      {
      anchor.addEventListener('click', function (e)
       {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView(
          {
          behavior: 'smooth'
          });
        });
      });


    // Cria um observador para detectar quando elementos aparecem na tela
    const observer = new IntersectionObserver((entries) => 
      {
      entries.forEach(entry => 
        {
        if (entry.isIntersecting) 
          {
           // Inicia a animação do elemento
          entry.target.style.animationPlayState = 'running';
          }
        });
       });

       
    // Seleciona todos os elementos com a classe animate-fade-in
    document.querySelectorAll('.animate-fade-in').forEach(el =>
     {
      el.style.animationPlayState = 'paused';
      observer.observe(el);
     });
