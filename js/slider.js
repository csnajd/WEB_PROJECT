// js/slider.js
const slider = document.querySelector(".slider");

if (slider) {
  const images = JSON.parse(slider.dataset.images);
  let currentIndex = 0;
  const img = document.getElementById("sliderImage");

  window.nextImage = function () {
    currentIndex = (currentIndex + 1) % images.length;
    img.src = images[currentIndex];
  };

  window.prevImage = function () {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    img.src = images[currentIndex];
  };
}