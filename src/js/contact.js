(() => {
    document.addEventListener("DOMContentLoaded", function () {
      const contactButtons = document.querySelectorAll(".button_take_contact");
      
      if (contactButtons.length === 0) return;
  
      contactButtons.forEach(button => {
        button.addEventListener("click", function (e) {
          e.preventDefault();
  
          const contactId = button.dataset.contactid;
          const taskType = button.dataset.tasktype;
          const userId = button.dataset.userid;
          const assignerId = button.dataset.assignerid;
  
          Swal.fire({
            title: "¿Estás seguro de querer tomar la tarea?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, tomar",
            cancelButtonText: "Cancelar",
            customClass: {
              popup: "swal-local-popup"
            },
            reverseButtons: true,
            allowEscapeKey: true,
            allowOutsideClick: true
          }).then(result => {
            if (result.isConfirmed) {
              fetch("/api/takecontact", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json"
                },
                body: JSON.stringify({
                  contactId: contactId,
                  taskType: taskType,
                  userId: userId,
                  assignerId: assignerId
                })
              })
                .then(response => response.json())
                .then(data => {
                  if (data.success) {
                    Swal.fire({
                      title: "Tarea tomada",
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
                      text: "No se pudo tomar la tarea",
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