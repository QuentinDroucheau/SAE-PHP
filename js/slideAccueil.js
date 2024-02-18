var swipers = document.querySelectorAll('.swiper-container');

swipers.forEach(function(swiper, index) {
  new Swiper(swiper, {
    slidesPerView: 4,
    slidesPerGroup: 3,
    spaceBetween: 30,
    navigation: {
      nextEl: swiper.parentNode.querySelector('.swiper-button-next'),
      prevEl: swiper.parentNode.querySelector('.swiper-button-prev'),
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 30
      },
      1280: {
        slidesPerView: 4,
        spaceBetween: 40
      },
    }
  });
});