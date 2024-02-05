var swiper = new Swiper('.swiper-container', {
  slidesPerView: 4, // nombre de cards a faire apparaitre
  slidesPerGroup: 3, // le nombre qu'on veut faire apparaitre chaque action
  spaceBetween: 30, // espace entre les cards
  navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
  },
});