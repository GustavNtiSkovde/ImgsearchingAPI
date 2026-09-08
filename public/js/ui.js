//map
const extendBtn = document.getElementById("extendToggle");
const mapSection = document.getElementById("mapSection");

if (extendBtn && mapSection) {
  extendBtn.addEventListener("click", () => {
    mapSection.classList.toggle("extended");
  });
}

//click image to keep open
document.addEventListener("click", (e) => {
  const box = e.target.closest(".picture-box");
  if (box) {
    const card = box.closest(".card-item");
    card.classList.toggle("is-locked");
    return;
  }

  //unlock if click outside of card-item
  if (!e.target.closest(".card-item")) {
    document.querySelectorAll(".card-item.is-locked").forEach(c => c.classList.remove("is-locked"));
  }
});