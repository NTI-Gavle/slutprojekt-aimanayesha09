document.addEventListener('DOMContentLoaded', function() {
    initClock();
    initDeleteConfirmation();
});


function initClock() {
    const canvas = document.getElementById('clockCanvas');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    function drawClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeString = hours + ':' + minutes + ':' + seconds;
        
       
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        
        ctx.fillStyle = '#1e3a5f';
        ctx.beginPath();
        ctx.roundRect(0, 0, canvas.width, canvas.height, 12);
        ctx.fill();
        
        
        ctx.font = 'bold 36px monospace';
        ctx.fillStyle = '#ffffff';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(timeString, canvas.width / 2, canvas.height / 2 - 5);
        
        
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateString = now.toLocaleDateString('sv-SE', options);
        ctx.font = '14px sans-serif';
        ctx.fillStyle = '#a0c4e8';
        ctx.fillText(dateString, canvas.width / 2, canvas.height / 2 + 25);
    }
    
    drawClock();
    setInterval(drawClock, 1000);
}
function initDeleteConfirmation() {
    const deleteButtons = document.querySelectorAll('.delete-post-btn');
    
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Är du säker på att du vill radera detta inlägg?')) {
                e.preventDefault();
            }
        });
    });
}