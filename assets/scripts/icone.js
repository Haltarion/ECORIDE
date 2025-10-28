// Animation de l'input range
// Method 1
//-------------------------------------------------------------
const sliderProgress = document.querySelector(".slider-progress");
const slider = document.querySelector("input[type='range']");
// IIF to update on saved or loaded values
(function () {
    const progress = 100 - ((slider.value / slider.max) * 100).toPrecision(5);
    sliderProgress.style.left = `-${progress}%`;
})();

//Add listeners for range changes
slider.addEventListener("click", function () {
    const progress = 100 - ((this.value / this.max) * 100).toPrecision(5);
    sliderProgress.style.left = `-${progress}%`;
});
slider.addEventListener("mousemove", function () {
    const progress = 100 - ((this.value / this.max) * 100).toPrecision(5);
    sliderProgress.style.left = `-${progress}%`;
});
slider.addEventListener("change", function () {
    const progress = 100 - ((this.value / this.max) * 100).toPrecision(5);
    sliderProgress.style.left = `-${progress}%`;
});
//Programatic range change example --> press U to load to 80%
document.addEventListener("keypress", (e) => {
    if (e.key === "u") {
        slider.value = 80;
        // if updating the value programatically, dispatch an event
        slider.dispatchEvent(new CustomEvent("change"));
    }
});

// Animation du starRating
// ---- ---- Const ---- ---- //
const stars = document.querySelectorAll(".stars i");
const starsNone = document.querySelector(".rating-box");

// ---- ---- Stars ---- ---- //
stars.forEach((star, index1) => {
    star.addEventListener("click", () => {
        stars.forEach((star, index2) => {
            // ---- ---- Active Star ---- ---- //
            index1 >= index2
                ? star.classList.add("active")
                : star.classList.remove("active");
        });
    });
});
