const sections = Array.from(document.querySelectorAll("section[id]"));
const navButtons = Array.from(document.querySelectorAll(".nav_standard"));

const setActive = (id) => {
  navButtons.forEach(btn => {
    btn.classList.toggle("active", btn.dataset.target === id);
  });
};

const observer = new IntersectionObserver(
  (entries) => {
    // pega só as que estão visíveis
    const visible = entries.filter(e => e.isIntersecting);

    if (!visible.length) return;

    // escolhe a mais "forte" (maior interseção)
    visible.sort((a, b) => b.intersectionRatio - a.intersectionRatio);
    setActive(visible[0].target.id);
  },
  {
    // ajusta o "ponto" de decisão:
    // aqui considera a section em foco quando ocupa uma boa parte do viewport
    threshold: [0.25, 0.5, 0.75],
    rootMargin: "0px 0px -40% 0px" 
  }
);

sections.forEach(sec => observer.observe(sec));

// opcional: ao carregar a página já ativa o que estiver mais perto do topo
window.addEventListener("load", () => {
  const current = sections
    .map(s => ({ id: s.id, top: Math.abs(s.getBoundingClientRect().top) }))
    .sort((a,b) => a.top - b.top)[0];
  if (current) setActive(current.id);
});
