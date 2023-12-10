document.addEventListener("DOMContentLoaded", function () {
  fetch('navbar.html')
    .then(function(response) {
      if (!response.ok) {
        throw new Error('navbar no responde');
      }
      return response.text();
    })
    .then(function(data) {
      document.querySelector("header").innerHTML = data;
      const currentPath = window.location.pathname;
      const navItems = document.querySelectorAll("header a");
      navItems.forEach(function (item) {
        const href = item.getAttribute("href");
        if (currentPath.includes(href)) {
          item.classList.add("active");
        }
      });
    })
    .catch(function(error) {
      console.error('Error barrar navbar:', error);
    });
});
