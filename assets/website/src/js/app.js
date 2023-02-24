import "../scss/app.scss";

/* Your JS Code goes here */

/* Alpine */
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

import Swiper, { Navigation, Pagination, EffectCoverflow } from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

const feather = require("feather-icons");

new Swiper(".cmp-carousel__go", {
  modules: [Navigation, Pagination, EffectCoverflow],
  slidesPerView: "auto",
  speed: 3000,
  spaceBetween: 0,
  slidesPerGroup: 1,
  rewind: true,
  centeredSlides: true,
  navigation: {
    nextEl: ".cmp-carousel__nav-next",
    prevEl: ".cmp-carousel__nav-prev",
  },
});

new Swiper(".cmp-project__go", {
    modules: [Navigation, Pagination, EffectCoverflow],
    slidesPerView: "auto",
    spaceBetween: 40,
    slidesPerGroup: 1,
    loop: true,
    loopFillGroupWithBlank: true,
    centeredSlides: true,
    breakpoints: {
      1280: {
        slidesPerGroup: 3,
      },
    },
    navigation: {
      nextEl: ".cmp-project__nav-next",
      prevEl: ".cmp-project__nav-prev",
    },
});

new Swiper(".cmp-bcr__go", {
    modules: [Navigation, Pagination, EffectCoverflow],
    slidesPerView: "auto",
    spaceBetween: 40,
    slidesPerGroup: 1,
    loop: true,
    loopFillGroupWithBlank: true,
    centeredSlides: true,
    breakpoints: {
      1280: {
        slidesPerGroup: 3,
      },
    },
    navigation: {
      nextEl: ".cmp-bcr__nav-next",
      prevEl: ".cmp-bcr__nav-prev",
    },
});


feather.replace();