// main.js
document.addEventListener('DOMContentLoaded', function () {
  const pills = document.querySelectorAll('.feature-pill');

  pills.forEach(pill => {
      pill.addEventListener('click', () => {
          pills.forEach(p => p.classList.remove('active'));
          pill.classList.add('active');
      });
  });
});