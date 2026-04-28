// this script is for the image slider functionality used in the details page
const slider = document.querySelector(".slider");

if (slider) { // if slider exists (i.e. there's more than 1 extra image)
    const images = JSON.parse(slider.dataset.images); // reads the js array passed via data-images
    let currentIndex = 0;
    const img = document.getElementById("sliderImage");

    function nextImage() { // window is the global object (browser page). without this, the page can't access these functions and the buttons won't work
        currentIndex = (currentIndex + 1) % images.length;
        img.src = images[currentIndex]; // change the src attribute of the <img> element to display the current image
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        img.src = images[currentIndex];
    }
}