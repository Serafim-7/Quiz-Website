const startingMinutes = 0.25;
let timeInSeconds = Math.floor(startingMinutes * 60);

const countdownEl = document.getElementById('examTimer');
const examForm = document.getElementById('examForm');
const examForm2 = document.getElementById('signupbutton');

// Start the countdown
const timer = setInterval(updateTime, 1000);

function updateTime() {
    if (timeInSeconds <= 0) {
        clearInterval(timer);
        countdownEl.textContent = "Time's up!";
        examForm.submit(); // Safely submit if form exists
        examForm2.submit();
        return;
    }

    const minutes = Math.floor(timeInSeconds / 60);
    const seconds = timeInSeconds % 60;

    countdownEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    timeInSeconds--;
}