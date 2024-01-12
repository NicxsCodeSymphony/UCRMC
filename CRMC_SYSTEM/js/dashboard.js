let btn = document.querySelector('#btn')
let sidebar = document.querySelector('.sidebar')

btn.onclick = function () {
    sidebar.classList.toggle('active');
};

function updateCurrentTime() {
    const currentDate = new Date();
    const options = { weekday: 'long', day: 'numeric', month: 'long' };
    const formattedDate = new Intl.DateTimeFormat('en-US', options).format(currentDate);
    document.getElementById('current-time').textContent = formattedDate;
}

updateCurrentTime();