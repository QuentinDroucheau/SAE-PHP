var swipers = document.querySelectorAll('.swiper-container');

swipers.forEach(function(swiper, index) {
  new Swiper(swiper, {
    slidesPerView: 5,
    slidesPerGroup: 3,
    spaceBetween: 30,
    navigation: {
      nextEl: swiper.parentNode.querySelector('.swiper-button-next'),
      prevEl: swiper.parentNode.querySelector('.swiper-button-prev'),
    },
  });
});