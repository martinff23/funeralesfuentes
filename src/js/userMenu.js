document.addEventListener("DOMContentLoaded", () => {
  const deleteUserLink = document.querySelector("#delete-user-link");

  if (deleteUserLink) {
    deleteUserLink.addEventListener("click", async (e) => {
      e.preventDefault();

      const confirmed = await Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, borrar",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
        focusConfirm: false,
        background: "white",
        color: "#0A1433",
      });

      if (confirmed.isConfirmed) {
        try {
          const userId = deleteUserLink.dataset.userid;

          const response = await fetch("/api/deleteuser", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: userId })
          });

          const text = await response.text();
          const data = text ? JSON.parse(text) : {};

          if (!response.ok) throw new Error(data.message || "Error al eliminar el usuario.");

          // Si todo bien, mostrar SweetAlert y luego cerrar sesión por POST
          Swal.fire({
            title: "Usuario borrado correctamente",
            text: "Tu sesión se cerrará automáticamente...",
            icon: "success",
            timer: 3000,
            timerProgressBar: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            background: "white",
            color: "#0A1433",
            didClose: async () => {
              // Enviar POST a logout
              await fetch("/logout", {
                method: "POST"
              });

              // Redireccionar manualmente
              window.location.href = "/";
            }
          });
        } catch (error) {
          Swal.fire({
            title: "Error",
            text: error.message,
            icon: "error",
            background: "white",
            color: "#0A1433",
            confirmButtonText: "Entendido"
          });
        }
      }
    });
  }
});