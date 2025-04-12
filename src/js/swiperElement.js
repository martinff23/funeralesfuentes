import Swiper from 'swiper';
import { Navigation, Pagination, Keyboard } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

document.addEventListener("DOMContentLoaded", () => {
  const modalTriggers = document.querySelectorAll(".swiper-slide[data-name]");

  const typesWithMap = ['branches', 'chapels', 'cemeteries', 'crematories'];

  modalTriggers.forEach((element) => {
    element.addEventListener("click", () => {
      const name = element.dataset.name;
      const address = element.dataset.address;
      const description = element.dataset.description;
      const imageType = element.dataset.imagetype;
      const images = element.dataset.image.split(",");
      const lat = parseFloat(element.dataset.lat);
      const lng = parseFloat(element.dataset.lng);

      const hasCoordinates = !isNaN(lat) && !isNaN(lng);
      const isMapType = typesWithMap.includes(imageType) && hasCoordinates;

      const mapId = `map-${Math.random().toString(36).substring(2, 9)}`;

      const imageSlides = images.map((img) => `
        <div class="swiper-slide">
          <img src="/public/build/img/${imageType}/${img.trim()}.png"
               style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;" 
               alt="Imagen de ${name}" />
        </div>
      `).join("");

      const mapLinks = hasCoordinates
        ? `
          <div style="display: flex; justify-content: center; gap: 1.5rem; margin-top: 1rem;">
            <a href="https://waze.com/ul?ll=${lat},${lng}&navigate=yes" target="_blank" style="color: #e6d36c; text-decoration: underline;">
              Ver en Waze
            </a>
            <a href="https://www.google.com/maps/search/?api=1&query=${lat},${lng}" target="_blank" style="color: #e6d36c; text-decoration: underline;">
              Ver en Google Maps
            </a>
          </div>
        `
        : '';

      const content = isMapType
        ? `
          <div style="color: #e6d36c; font-size: 16px; width: 100%;">
            <h2 style="text-align: center; margin: 0 0 1rem 0; font-size: 28px;">${name}</h2>
            <div id="modal-layout" style="
              display: flex;
              flex-wrap: wrap;
              gap: 2rem;
              justify-content: center;
              align-items: stretch;
              flex-direction: row;
            ">
              <div id="swiper-container" style="flex: 1; min-width: 300px; max-width: 600px;">
                <div class="swiper modal-swiper" style="height: 100%; width: 100%; border-radius: 8px; overflow: hidden;">
                  <div class="swiper-wrapper">
                    ${imageSlides}
                  </div>
                  <div class="swiper-button-next"></div>
                  <div class="swiper-button-prev"></div>
                  <div class="swiper-pagination"></div>
                </div>
              </div>
              <div id="map-wrapper" style="flex: 1; min-width: 300px; max-width: 600px;">
                <div id="${mapId}" style="width: 100%; height: 100%; border-radius: 8px;"></div>
              </div>
            </div>
            <p style="text-align: center; margin-top: 1.5rem; font-size: 16px;">${description}</p>
            ${mapLinks}
            <style>
              .map-label {
                background: white;
                color: #333;
                padding: 10px 12px;
                border-radius: 6px;
                font-size: 14px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.3);
                max-width: 240px;
                line-height: 1.4;
              }

              .map-label h4 {
                margin: 0 0 6px 0;
                font-size: 16px;
              }

              .map-label p {
                margin: 0;
              }

              @media (max-width: 900px) {
                #modal-layout {
                  flex-direction: column !important;
                }
                #swiper-container,
                #map-wrapper {
                  max-width: 100% !important;
                }
                .modal-swiper {
                  height: 300px !important;
                }
                #${mapId} {
                  height: 300px !important;
                }
              }
            </style>
          </div>
        `
        : `
          <div style="
            color: #e6d36c;
            font-size: 16px;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            text-align: center;
          ">
            <h2 style="margin: 0 0 1rem 0; font-size: 28px;">${name}</h2>
            <div style="flex: 1 1 auto; min-height: 0; display: flex; justify-content: center; align-items: center;">
              <div class="swiper modal-swiper" style="
                width: 100%;
                height: 100%;
                border-radius: 8px;
                overflow: hidden;
              ">
                <div class="swiper-wrapper">
                  ${imageSlides}
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
              </div>
            </div>
            <p style="margin-top: 1rem; font-size: 16px;">${description}</p>
            ${mapLinks}
            <style>
              @media (max-width: 768px) {
                .swal2-popup {
                  width: 95vw !important;
                  height: auto !important;
                }
                .modal-swiper {
                  height: 300px !important;
                  max-height: 300px !important;
                }
              }
              @media (max-width: 1024px) {
                .swal2-popup {
                  width: 90vw !important;
                }
              }
            </style>
          </div>
        `;

      Swal.fire({
        html: content,
        width: isMapType ? "80vw" : "60vw",
        heightAuto: false,
        customClass: {
          popup: "sweetalert-detail"
        },
        background: "#0A1433",
        showCloseButton: true,
        showConfirmButton: false,

        didRender: () => {
          const popup = document.querySelector('.sweetalert-detail');
          if (popup) {
            popup.style.height = '85vh';
            popup.style.maxHeight = '85vh';
            popup.style.overflowY = 'auto';
            popup.style.overflowX = 'hidden';
          }
        },

        didOpen: () => {
          setTimeout(() => {
            const swiper = new Swiper(".modal-swiper", {
              loop: true,
              keyboard: {
                enabled: true,
                onlyInViewport: false
              },
              navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
              },
              pagination: {
                el: ".swiper-pagination",
                clickable: true
              },
              modules: [Navigation, Pagination, Keyboard]
            });

            swiper.update();

            if (isMapType) {
              const swiperContainer = document.getElementById('swiper-container');
              const mapDiv = document.getElementById(mapId);
              if (swiperContainer && mapDiv) {
                mapDiv.style.height = `${swiperContainer.offsetHeight}px`;
              }
            }
          }, 100);

          if (isMapType && typeof L !== 'undefined') {
            const map = L.map(mapId).setView([lat, lng], 21);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
              attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map);

            const nameControl = L.control({ position: 'topright' });
            nameControl.onAdd = function () {
              const div = L.DomUtil.create('div', 'map-label');
              div.innerHTML = `
                <h4>${name}</h4>
                <p>${address}</p>
              `;
              return div;
            };
            nameControl.addTo(map);

            setTimeout(() => map.invalidateSize(), 300);
          }
        }
      });
    });
  });
});
