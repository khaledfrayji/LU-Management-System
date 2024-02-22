
    function updateDateTime() {
      const dateElement = document.getElementById('date');
      const timeElement = document.getElementById('time');

      const now = new Date();

      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      const dateString = now.toLocaleDateString('en-US', options);
      dateElement.textContent = dateString;

      const timeString = now.toLocaleTimeString('en-US');
      timeElement.textContent = timeString;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
