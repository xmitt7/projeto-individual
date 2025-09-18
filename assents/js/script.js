 const filtroData = document.getElementById("filtroData");

  // Detecta quando a data é selecionada
  filtroData.addEventListener("change", () => {
    // Salva no localStorage para persistir
    localStorage.setItem("filtroData", filtroData.value);
    console.log("Data selecionada:", filtroData.value);
  });

  // Carrega a data salva quando a página abre
  window.addEventListener("DOMContentLoaded", () => {
    const dataSalva = localStorage.getItem("filtroData");
    if (dataSalva) {
      filtroData.value = dataSalva;
    }
  });