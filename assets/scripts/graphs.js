/* graphique pour le nombre de covoiturage par jour */
const graph1 = document.getElementById("nbCovParJour");

new Chart(graph1, {
  type: "bar",
  data: {
    labels: [
      "Lundi",
      "Mardi",
      "mercredi",
      "Jeudi",
      "Vendredi",
      "Samedi",
      "Dimanche",
    ],
    datasets: [
      {
        label: "# de covoiturage / jour",
        data: [52, 48, 32, 27, 126, 84, 20],
        borderWidth: 1,
      },
    ],
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});

/* graphique pour les gains */
const graph2 = document.getElementById("gains");

new Chart(graph2, {
  type: "line",
  data: {
    labels: [
      "Lundi",
      "Mardi",
      "mercredi",
      "Jeudi",
      "Vendredi",
      "Samedi",
      "Dimanche",
    ],
    datasets: [
      {
        label: "gain de crédits / jour",
        data: [104, 96, 64, 54, 252, 168, 40],
        borderWidth: 1,
      },
    ],
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});
