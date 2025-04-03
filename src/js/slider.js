// import Swiper from 'swiper';
// import {Navigation} from 'swiper/modules';
// import 'swiper/css';
// import 'swiper/css/navigation';

// document.addEventListener('DOMContentLoaded', function(){
//     if(document.querySelector('.slider')){
//         const options = {
//             slidesPerView: 1,
//             spaceBetween: 15,
//             freeMode: true,
//             navigation: {
//                 nextEl: '.swiper-button-next',
//                 prevEl: '.swiper-button-prev'
//             },
//             breakpoints: {
//                 768: {
//                     slidesPerView: 2
//                 },
//                 1024: {
//                     slidesPerView: 3
//                 }
//             }
//         };

//         Swiper.use([Navigation]),
//         new Swiper('.slider', options);
//     }
// });

import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

document.addEventListener('DOMContentLoaded', function () {
  // Alliances logo slider (personalizado)
  const track = document.getElementById('alliancesTrack');
  if (track) {
    const logos = track.querySelector('.alliances-logos');
    const images = logos.querySelectorAll('img');

    const speed = 1.5;
    let position = 0;
    let paused = false;

    function animate() {
      if (!paused) {
        position -= speed;

        const firstLogo = logos.children[0];
        const firstLogoWidth = firstLogo.offsetWidth + 80;

        if (Math.abs(position) >= firstLogoWidth) {
          position += firstLogoWidth;
          logos.appendChild(firstLogo);
        }

        track.style.transform = `translateX(${position}px)`;
      }

      requestAnimationFrame(animate);
    }

    // Pausar en hover
    images.forEach(img => {
      img.addEventListener('mouseenter', () => paused = true);
      img.addEventListener('mouseleave', () => paused = false);
    });

    requestAnimationFrame(animate);
  }

  // Swiper sliders (productos, capillas, etc)
  // if (document.querySelector('.slider')) {
  //   Swiper.use([Navigation]);
  //   new Swiper('.slider', {
  //     slidesPerView: 1,
  //     spaceBetween: 15,
  //     freeMode: true,
  //     navigation: {
  //       nextEl: '.swiper-button-next',
  //       prevEl: '.swiper-button-prev'
  //     },
  //     breakpoints: {
  //       768: { slidesPerView: 2 },
  //       1024: { slidesPerView: 3 }
  //     }
  //   });
  // }

  Swiper.use([Navigation]);
  document.querySelectorAll('.slider').forEach(slider => {
    const next = slider.querySelector('.swiper-button-next');
    const prev = slider.querySelector('.swiper-button-prev');
  
    new Swiper(slider, {
      slidesPerView: 1,
      spaceBetween: 15,
      freeMode: false,
      navigation: {
        nextEl: next,
        prevEl: prev
      },
      breakpoints: {
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 }
      }
    });
  });
});