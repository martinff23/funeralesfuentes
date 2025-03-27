document.addEventListener("DOMContentLoaded", () => {
    initApp();
  });
  
  async function initApp() {
    const dateInfoEl = document.getElementById("date-info");
    const birthdaysTable = document.querySelector("#birthdays-table tbody");
    const spinner = createSpinner();
    let birthdays = [];
  
    if (!dateInfoEl || !birthdaysTable) return;
  
    showLoading(dateInfoEl, spinner);
    updateGreeting();
    initDateTimeAndWeather(dateInfoEl);
  
    try {
      const data = await fetchBirthdays();
      birthdays = formatBirthdays(data);
      renderBirthdays(birthdays, birthdaysTable);
    } catch (err) {
      console.error("Error fetching birthdays:", err);
    }
  }
  
  function createSpinner() {
    const spinner = document.createElement("div");
    spinner.classList.add("spinner");
    Object.assign(spinner.style, {
      width: "16px",
      height: "16px",
      border: "2px solid #ccc",
      borderTop: "2px solid #333",
      borderRadius: "50%",
      animation: "spin 1s linear infinite",
      display: "inline-block",
      marginRight: "10px"
    });
    return spinner;
  }
  
  function showLoading(container, spinner) {
    container.innerHTML = "";
    container.appendChild(spinner);
    container.appendChild(document.createTextNode("Cargando información..."));
  }
  
  async function fetchBirthdays() {
    const response = await fetch("/api/birthdays");
    return await response.json();
  }
  
  function formatBirthdays(data = []) {
    return data.map(item => ({
      id: item.id,
      date: item.birthday,
      name: `${item.name.trim()} ${item.f_name.trim()}`
    }));
  }
  
  function updateGreeting() {
    const greetingEl = document.getElementById("user-greeting");
    if (!greetingEl) return;
  
    const now = new Date();
    const hour = now.getHours();
    const greetings = [
      { range: [6, 12], text: String.fromCodePoint(0x1F305) + " Buen día" },
      { range: [12, 19], text: String.fromCodePoint(0x1F307) + " Buena tarde" },
      { range: [19, 24], text: String.fromCodePoint(0x1F319) + " Buena noche" },
      { range: [0, 6], text: String.fromCodePoint(0x1F319) + " Buena noche" }
    ];
  
    const greeting = greetings.find(g => hour >= g.range[0] && hour < g.range[1]).text;
    const name = greetingEl.textContent.split(",")[1] ? greetingEl.textContent.split(",")[1].trim() : "";
    greetingEl.textContent = `${greeting}, ${name}`;
  }
  
  function initDateTimeAndWeather(dateInfoEl) {
    let temperature = null;
    let city = "Ubicación desconocida";
    let dayName = "";
    let fullDate = "";
    let infoReady = false;
  
    function updateDateParts() {
      const now = new Date();
      dayName = now.toLocaleDateString("es-ES", { weekday: "long" });
      fullDate = now.toLocaleDateString("es-ES", { day: "numeric", month: "long", year: "numeric" });
    }
  
    function updateClock() {
      if (!infoReady) return;
  
      dateInfoEl.innerHTML = "";
      const now = new Date();
      const timeStr = now.toLocaleTimeString("es-ES", { hour12: false });
  
      const leftSpan = createSpan("intranet-menu__left-info", `Temperatura ${temperature}°C en ${city}`);
      const rightSpan = createSpan("intranet-menu__right-info", `Hoy es ${dayName}, ${fullDate}, ${timeStr}`);
  
      dateInfoEl.appendChild(rightSpan);
      dateInfoEl.appendChild(leftSpan);
    }
  
    async function fetchWeather() {
      if (!navigator.geolocation) {
        dateInfoEl.textContent = `${dayName}, ${fullDate} - Geolocalización no compatible`;
        return;
      }
  
      navigator.geolocation.getCurrentPosition(async pos => {
        const { latitude, longitude } = pos.coords;
  
        try {
          const weatherRes = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current_weather=true`);
          const weatherData = await weatherRes.json();
          temperature = weatherData.current_weather.temperature;
  
          const locationRes = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&accept-language=es&lat=${latitude}&lon=${longitude}`);
          const locationData = await locationRes.json();
          city = locationData.address.city || locationData.address.town || locationData.address.state || "Ubicación desconocida";
  
          infoReady = true;
          setTimeout(updateClock, 1000);
        } catch (err) {
          console.error("Weather fetch error:", err);
          dateInfoEl.textContent = `${dayName}, ${fullDate} - Error al obtener clima/ubicación`;
        }
      });
    }
  
    updateDateParts();
    fetchWeather();
    updateClock();
  
    setInterval(() => {
      updateDateParts();
      updateClock();
    }, 1000);
  
    setInterval(fetchWeather, 600000);
  }
  
  function createSpan(className, text) {
    const span = document.createElement("span");
    span.className = className;
    span.textContent = text;
    return span;
  }
  
  function renderBirthdays(birthdays, tableEl) {
    const today = new Date();
    const currentYear = today.getFullYear();
  
    // Calcular inicio y fin de la semana
    const dayOfWeek = today.getDay();
    const diffToMonday = (dayOfWeek === 0 ? -6 : 1) - dayOfWeek;
  
    const startOfWeek = new Date(today);
    startOfWeek.setDate(today.getDate() + diffToMonday);
    startOfWeek.setHours(0, 0, 0, 0);
  
    const endOfWeek = new Date(startOfWeek);
    endOfWeek.setDate(startOfWeek.getDate() + 6);
    endOfWeek.setHours(23, 59, 59, 999);
  
    // Mostrar rango de la semana en formato "Semana del x al y de marzo"
    const startDay = startOfWeek.getDate();
    const endDay = endOfWeek.getDate();
    const monthName = startOfWeek.toLocaleString("es-ES", { month: "long" });
    const headerRow = document.createElement("tr");
    const headerCell = document.createElement("td");
    headerCell.colSpan = 3;
    headerCell.style.fontWeight = "bold";
    headerCell.style.textAlign = "center";
    headerCell.style.padding = "10px 0";
    headerCell.textContent = `🎉 Cumpleaños de la semana: del ${startDay} al ${endDay} de ${monthName}`;
    headerRow.appendChild(headerCell);
  
    tableEl.innerHTML = "";
    tableEl.appendChild(headerRow);
  
    // Filtrar los cumpleaños dentro de la semana actual
    const filtered = birthdays
      .map(b => {
        const [_, month, day] = b.date.split("-").map(Number);
        const birthdayThisYear = new Date(currentYear, month - 1, day);
        return { ...b, birthdayDate: birthdayThisYear };
      })
      .filter(b => b.birthdayDate >= startOfWeek && b.birthdayDate <= endOfWeek)
      .sort((a, b) => a.birthdayDate - b.birthdayDate); // ordenar por fecha ascendente
  
    if (filtered.length === 0) {
      const row = document.createElement("tr");
      const cell = document.createElement("td");
      cell.colSpan = 3;
      cell.textContent = "No hay cumpleaños esta semana";
      cell.style.textAlign = "center";
      row.appendChild(cell);
      tableEl.appendChild(row);
      return;
    }
  
    filtered.forEach(b => {
      const day = b.birthdayDate.getDate().toString().padStart(2, "0");
      const month = b.birthdayDate.toLocaleString("es-ES", { month: "long" });
  
      const row = document.createElement("tr");
      const btnId = `felicitar-${b.name.replace(/\s/g, "-").toLowerCase()}`;
  
      row.innerHTML = `
        <td>${b.name}</td>
        <td>${day} de ${month}</td>
        <td class="btnCol">
          <button class="intranet-menu__btn" data-name="${b.name}" id="${btnId}">
            ${String.fromCodePoint(0x1F382)} Felicitar
          </button>
        </td>
      `;
  
      tableEl.appendChild(row);
  
      document.getElementById(btnId).addEventListener("click", () => {
        showBalloonCelebration(b.name);
      });
    });
  }  
  
  function showBalloonCelebration(name) {
    applyBalloonStyles();
    launchBalloons();
    Swal.fire({
      title: `${String.fromCodePoint(0x1F389)} ¡Felicidades, ${name}! ${String.fromCodePoint(0x1F389)}`,
      input: "textarea",
      inputLabel: "Escribe tu mensaje de felicitación:",
      inputPlaceholder: `Querido ${name}, te deseo un feliz cumpleaños. Con cariño, [Tu Nombre]`,
      showCancelButton: true,
      confirmButtonText: "Enviar Felicitación",
      cancelButtonText: "Cancelar",
      didClose: () => {
        const container = document.getElementById("balloon-container");
        if (container) container.remove();
      }
    }).then(result => {
      if (result.isConfirmed) {
        Swal.fire(`${String.fromCodePoint(0x1F388)} Felicitación enviada`, "Tu mensaje ha sido enviado con éxito.", "success");
      }
    });
  }
  
  function launchBalloons() {
    const container = document.createElement("div");
    container.id = "balloon-container";
    document.body.appendChild(container);
  
    const emojis = [0x1F389, 0x1F388, 0x1F382, 0x1F973, 0x1F496, 0x1F38A];
    const colors = ["#FF6B6B", "#FFD93D", "#6BCB77", "#4D96FF", "#FF6FB5", "#A66CFF"];
  
    for (let i = 0; i < 150; i++) {
      const balloon = document.createElement("div");
      balloon.classList.add("balloon");
  
      const color = colors[Math.floor(Math.random() * colors.length)];
      const emoji = String.fromCodePoint(emojis[Math.floor(Math.random() * emojis.length)]);
      const width = 25 + Math.random() * 10;
      const height = 35 + Math.random() * 15;
  
      Object.assign(balloon.style, {
        width: `${width}px`,
        height: `${height}px`,
        borderRadius: "50%",
        backgroundColor: color,
        left: `${Math.random() * 100}vw`,
        position: "absolute",
        bottom: "0",
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        fontSize: "1.2rem",
        fontWeight: "bold",
        color: "white",
        textShadow: "1px 1px 2px black",
        animation: `float-up ${4 + Math.random() * 2}s linear forwards`
      });
  
      balloon.textContent = emoji;
      container.appendChild(balloon);
    }
  }
  
  function applyBalloonStyles() {
    const existingStyle = document.getElementById("balloon-style");
    if (existingStyle) return; // avoid duplicates
  
    const style = document.createElement("style");
    style.id = "balloon-style";
    style.innerHTML = `
      @keyframes float-up {
        0% { transform: translateY(0); opacity: 1; }
        100% { transform: translateY(-150vh); opacity: 0; }
      }
      .balloon::after {
        content: '';
        width: 2px;
        height: 20px;
        background-color: gray;
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
      }
    `;
    document.head.appendChild(style);
  }
  
  function getRandomColor() {
    const colors = ["#FF4B91", "#FFD93D", "#6BCB77", "#4D96FF", "#F72585"];
    return colors[Math.floor(Math.random() * colors.length)];
  }
  
  const spinnerStyle = document.createElement("style");
  spinnerStyle.innerHTML = `
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  `;
  document.head.appendChild(spinnerStyle);