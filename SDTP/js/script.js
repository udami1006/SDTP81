document.addEventListener("DOMContentLoaded", function () {
    let map = L.map("map").setView([6.927079, 79.861244], 12);
  
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "&copy; OpenStreetMap contributors",
    }).addTo(map);
  
    fetch("./components/get_aqi_data.php")
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        if (data.error) {
          throw new Error(data.error);
        }
  
        data.forEach((location) => {
          let { sensor_id, name, lat, lng, aqi_value } = location;
  
          if (sensor_id === undefined || lat === undefined || lng === undefined) {
            console.error("Invalid data:", location);
            return;
          }
  
          let color =
            aqi_value <= 50
              ? "green"
              : aqi_value <= 100
              ? "yellow"
              : aqi_value <= 150
              ? "orange"
              : aqi_value <= 200
              ? "red"
              : "purple";
  
          let Legend =
            aqi_value <= 50
              ? "Good"
              : aqi_value <= 100
              ? "Moderate"
              : aqi_value <= 150
              ? "Unhealthy"
              : aqi_value <= 200
              ? "Very Unhealthy"
              : "Unknown";
  
          let marker = L.circleMarker([lat, lng], {
            radius: 10,
            color: color,
            fillOpacity: 0.6,
          })
            .addTo(map)
            .bindPopup(
              `<h3>${name}</h3><br>
              <b style="padding: 5px; margin: 5px; background-color: ${color}">${Legend}</b>
              <b>AQI Level:</b> ${aqi_value}
              <sub style="color: red; padding: 0 5px;">latest 7 hours</sub>
              <br><br>
              <canvas width="400px" height="300px" id="chart-${sensor_id}"></canvas>`
            );
  
          marker.on("click", function (e) {
            let offsetLat = 0.03;
  
            let adjustedLat = e.latlng.lat + offsetLat;
            let adjustedLng = e.latlng.lng;
  
            map.setView([adjustedLat, adjustedLng], 13, { animate: true });
            // console.log(lng);
            // console.log(lat);
            // console.log(adjustedLat);
  
            fetchHistoricalData(sensor_id, `chart-${sensor_id}`);
            console.log("Sensor ID:", sensor_id);
          });
        });
      })
      .catch((error) => {
        console.error("Error fetching air quality data:", error);
        alert("Failed to fetch air quality data. Please try again later.");
      });
  });
  
  function fetchHistoricalData(sensorId, canvasId) {
    fetch(`./components/historical_data.php?sensorId=${sensorId}`)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        console.log("Current AQI Data:", data);
  
        if (data.length === 0) {
          alert("No historical data found for this sensor.");
          return;
        }
  
        const ctx = document.getElementById(canvasId).getContext("2d");
  
        const now = new Date();
        const sHoursAgo = new Date(now.getTime() - 7 * 60 * 60 * 1000);
  
        const filteredData = data.filter((entry) => {
          const entryDate = new Date(entry.date);
          return entryDate >= sHoursAgo && entryDate <= now;
        });
  
        const labels = filteredData.map((entry) => {
          const dateObj = new Date(entry.date);
          const time = dateObj.toTimeString().split(" ")[0];
          return `${time}`;
        });
  
        const aqiValues = filteredData.map((entry) => entry.aqi);
  
        new Chart(ctx, {
          type: "line",
          data: {
            labels: labels,
            datasets: [
              {
                label: "AQI Over Time",
                data: aqiValues,
                fill: "blue",
              },
            ],
          },
          options: {
            responsive: true,
            scales: {
              x: {
                title: {
                  display: true,
                  text: "Date",
                },
                ticks: {
                  autoSkip: false,
                  maxRotation: 90,
                  minRotation: 90,
                },
              },
              y: {
                title: {
                  display: true,
                  text: "AQI",
                },
              },
            },
          },
        });
      })
      .catch((error) => {
        console.error("Error fetching historical data:", error);
        alert("Failed to fetch historical data. Please try again later.");
      });
  }
  