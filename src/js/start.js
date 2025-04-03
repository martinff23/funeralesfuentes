class ContactFormHandler {
    constructor(formSelector) {
      this.form = document.querySelector(formSelector);
      if (!this.form) return;
  
      this.form.addEventListener('submit', this.handleSubmit.bind(this));
    }
  
    async handleSubmit(event) {
      event.preventDefault(); // Prevent page reload
  
      const formData = new FormData(this.form);
      const data = Object.fromEntries(formData.entries());
  
      try {
        const response = await fetch('/api/contact', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });
  
        const result = await response.json();
  
        if (response.ok) {
          Swal.fire({
            icon: 'success',
            title: '¡Gracias!',
            text: 'Recibimos tu solicitud de contacto, en breve recibirás noticias nuestras.',
            timer: 5000,
            timerProgressBar: true,
            showConfirmButton: false,
            showCloseButton: true,
            toast: false
          });
  
          this.form.reset(); // Clear form
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: result.message || 'Hubo un error al enviar tu solicitud. Inténtalo más tarde.'
          });
        }
  
      } catch (error) {
        console.error('Error submitting contact form:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error de red',
          text: 'No se pudo contactar con el servidor. Verifica tu conexión.'
        });
      }
    }
  }
  
document.addEventListener('DOMContentLoaded', () => {
    new ContactFormHandler('#form_contact');
});