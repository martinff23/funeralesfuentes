(() => {
    document.addEventListener("DOMContentLoaded", function () {
      const rows = document.querySelectorAll(".task_row");
  
      if (rows.length === 0) return;
  
      rows.forEach(row => {
        row.addEventListener("click", function (e) {
          if (e.target.closest('a')) return;
  
          const id = row.dataset.id;
  
          Swal.fire({
            title: 'Cargando...',
            text: 'Obteniendo información de la tarea',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });
  
          fetch('/api/gettaskinfo', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
          })
            .then(res => res.json())
            .then(data => {
              if (!data.success) {
                throw new Error(data.message || "Error desconocido");
              }
  
              const task = data.data;
  
              Swal.fire({
                title: `Detalle de la tarea`,
                html: `
                  <p><strong>Nombre:</strong> ${task.title}</p>
                  <p><strong>Notas:</strong> ${task.requirement}</p>
                  <p><strong>Asignado por:</strong> ${task.assigner}</p>
                  <p><strong>Estado:</strong> ${task.status}</p>
                `,
                icon: "info",
                confirmButtonText: "Cerrar",
                allowOutsideClick: true,
                allowEscapeKey: true,
                customClass: {
                  popup: "swal-local-popup"
                }
              });
            })
            .catch(err => {
              Swal.fire({
                title: "Error",
                text: err.message || "No se pudo cargar la información",
                icon: "error",
                allowOutsideClick: true,
                allowEscapeKey: true,
                customClass: {
                  popup: "swal-local-popup"
                }
              });
            });
        });
      });
    });
  })();

  (() => {
    document.addEventListener("DOMContentLoaded", function () {
      const completeButtons = document.querySelectorAll(".button_complete_task");
  
      if (completeButtons.length === 0) return;
  
      completeButtons.forEach(button => {
        button.addEventListener("click", function (e) {
          e.preventDefault();
  
          const id = Number(button.dataset.id);
          const underlyingId = Number(button.dataset.underlyingid);
  
          Swal.fire({
            title: "¿Estás seguro de querer completar la tarea?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, completar",
            cancelButtonText: "Cancelar",
            customClass: {
              popup: "swal-local-popup"
            },
            reverseButtons: true,
            allowEscapeKey: true,
            allowOutsideClick: true
          }).then(result => {
            if (result.isConfirmed) {
              fetch("/api/completetask", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json"
                },
                body: JSON.stringify({
                  id: id,
                  underlyingId: underlyingId
                })
              })
                .then(response => response.json())
                .then(data => {
                  if (data.success) {
                    Swal.fire({
                      title: "Tarea completada",
                      icon: "success",
                      timer: 1500,
                      showConfirmButton: false,
                      customClass: {
                        popup: "swal-local-popup"
                      },
                      allowEscapeKey: true,
                      allowOutsideClick: true
                    }).then(() => {
                      location.reload();
                    });
                  } else {
                    Swal.fire({
                      title: "Error",
                      text: data.message || "No se pudo completar la tarea",
                      icon: "error",
                      customClass: {
                        popup: "swal-local-popup"
                      },
                      allowEscapeKey: true,
                      allowOutsideClick: true
                    });
                  }
                })
                .catch(() => {
                  Swal.fire({
                    title: "Error",
                    text: "Hubo un problema al conectar con el servidor",
                    icon: "error",
                    customClass: {
                      popup: "swal-local-popup"
                    },
                    allowEscapeKey: true,
                    allowOutsideClick: true
                  });
                });
            }
          });
        });
      });
    });
  })();
  
  (() => {
    document.addEventListener("DOMContentLoaded", function () {
      const returnButtons = document.querySelectorAll(".button_return_contact");
  
      if (returnButtons.length === 0) return;
  
      returnButtons.forEach(button => {
        button.addEventListener("click", function (e) {
          e.preventDefault();
  
          const id = Number(button.dataset.id);
          const underlyingId = Number(button.dataset.underlyingid);
  
          Swal.fire({
            title: "¿Estás seguro de querer regresar la tarea?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, regresar",
            cancelButtonText: "Cancelar",
            customClass: {
              popup: "swal-local-popup"
            },
            reverseButtons: true,
            allowEscapeKey: true,
            allowOutsideClick: true
          }).then(result => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "Motivo del retorno",
                input: "textarea",
                inputPlaceholder: "Escribe aquí tu comentario...",
                inputAttributes: {
                  'aria-label': 'Motivo del retorno'
                },
                customClass: {
                  popup: "swal-local-popup"
                },
                showCancelButton: true,
                confirmButtonText: "Enviar",
                cancelButtonText: "Cancelar",
                footer: '<p style="font-size: 1.5rem; text-align: left; color: #555;">Es importante que expliques el motivo por el cual estás retornando esta tarea de contacto, pues será considerado en tu evaluación.</p>',
                preConfirm: (comment) => {
                  if (!comment || comment.trim().length < 5) {
                    Swal.showValidationMessage("Por favor explica el motivo con al menos 5 caracteres");
                    return false;
                  }
                  return comment.trim();
                }
              }).then(result2 => {
                if (result2.isConfirmed) {
                  console.log(result2.value);
                  fetch("/api/returntask", {
                    method: "POST",
                    headers: {
                      "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                      id: id,
                      underlyingId: underlyingId,
                      comment: result2.value
                    })
                  })
                    .then(response => response.json())
                    .then(data => {
                      if (data.success) {
                        Swal.fire({
                          title: "Tarea retornada",
                          icon: "success",
                          timer: 1500,
                          showConfirmButton: false,
                          customClass: {
                            popup: "swal-local-popup"
                          },
                          allowEscapeKey: true,
                          allowOutsideClick: true
                        }).then(() => {
                          location.reload();
                        });
                      } else {
                        Swal.fire({
                          title: "Error",
                          text: data.message || "No se pudo retornar la tarea",
                          icon: "error",
                          customClass: {
                            popup: "swal-local-popup"
                          },
                          allowEscapeKey: true,
                          allowOutsideClick: true
                        });
                      }
                    })
                    .catch(() => {
                      Swal.fire({
                        title: "Error",
                        text: "Hubo un problema al conectar con el servidor",
                        icon: "error",
                        customClass: {
                          popup: "swal-local-popup"
                        },
                        allowEscapeKey: true,
                        allowOutsideClick: true
                      });
                    });
                }
              });
            }
          });
        });
      });
    });
  })();  