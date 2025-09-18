const navBar = document.querySelector("nav");
const menuBtns = document.querySelectorAll(".menu-icon");
const overlay = document.querySelector(".overlay");

// Abrir/fechar clicando no ícone
menuBtns.forEach((menuBtn) => {
  menuBtn.addEventListener("click", () => {
    navBar.classList.toggle("open");
  });
});

// Fechar clicando no overlay
overlay.addEventListener("click", () => {
  navBar.classList.remove("open");
});
