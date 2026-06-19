// Getting vars from blade
const seats = window.seats;
const showtime = window.showtime;

// Creating necessary vars
const selectedSeats = [];
const selectedSeatsLabel = [];
// Creating Konva Drawer
const stage = new Konva.Stage({
    container: 'seat-map',
    //width: window.innerWidth > 1024 ? 700 : 500,
    width: document.getElementById('seat-map').clientWidth,
    height: 400
});

const layer = new Konva.Layer();
stage.add(layer);

// Getting unique rows
const rowsLetters = [...new Set(seats.map(seat => String(seat.row)))].sort(); // Tupla of rows identifiers

// Selecting seats
function toggleSeat(seat, circle) {
    const index = selectedSeats.indexOf(seat.id);
    const labelIndex = selectedSeatsLabel.indexOf(seat.label)

    if (index !== -1) {
        // If it is selected, remove of there
        selectedSeats.splice(index, 1);
        selectedSeatsLabel.splice(labelIndex, 1);
        circle.fill('#4CAF50');
    } else {
        // If isn't selected, add it into selectedSeats
        selectedSeats.push(seat.id);
        selectedSeatsLabel.push(seat.label);
        circle.fill('#FD7B41');
    }

    updateDisplay();
    layer.draw(); // Re-draw layer
}

// Updating display
function updateDisplay() {
    const selectedCount = selectedSeats.length;
    const totalCost = selectedCount * showtime['basePrice'];

    // Updating selected seats
    if (selectedCount === 0) {
        document.getElementById('selectedSeatsDisplay').textContent = 'Ninguno';
    } else {
        document.getElementById('selectedSeatsDisplay').textContent = selectedSeatsLabel.join(', ');
    }

    // Updating total cost
    document.getElementById('totalPrice').textContent = '$' + totalCost.toFixed(2);

    // Updating all inside hidden input
    document.getElementById('seatsInput').value = JSON.stringify(selectedSeats);

    // Enabling/Disabling order button
    const submitBtn = document.getElementById('submitBtn');

    submitBtn.disabled = (selectedCount === 0);
    submitBtn.style.opacity = selectedCount === 0 ? '0.5' : '1';
    submitBtn.style.cursor = selectedCount === 0 ? 'not-allowed' : 'pointer';
}

// Seats Properties
const seatRadius = 15;
const seatSpacing = 40;
const rowSpacing = 40;
const startX = 0;
const startY = 75;

// Drawing seats
seats.forEach(seat => {
    const rowIndex = rowsLetters.indexOf(String(seat.row));
    const x = startX + seat.number * seatSpacing;
    const y = startY + rowIndex * rowSpacing;

    const drawnSeat = new Konva.Circle({
        x: x,
        y: y,
        radius: seatRadius,
        fill: seat.status === 0 ? '#4CAF50' : '#f44336',
        stroke: seat.status === 0 ? '#388E3C' : '#d32f2f',
        strokeWidth: 2,
        id: seat.id
    });

    // Adding event listener only to available seats
    if (seat.status === 0) {
        drawnSeat.on('click', () => {
            toggleSeat(seat, drawnSeat);
        });
        drawnSeat.on('mouseover', () => {
            drawnSeat.scale({ x: 1.2, y: 1.2 });
            layer.draw();
        });
        drawnSeat.on('mouseout', () => {
            drawnSeat.scale({ x: 1, y: 1 });
            layer.draw();
        });
        drawnSeat.cursor = 'pointer';
    }

    layer.add(drawnSeat);

    // Adding seat label
    const label = new Konva.Text({
        x: x - 12,
        y: y - 6,
        text: seat.label.toString(),
        fontSize: 10,
        fontFamily: 'Inter, sans-serif',
        fill: '#fff',
        width: 23,
        align: 'center',
        pointerEvents: 'none'
    });

    layer.add(label);
});

layer.draw();

// Resizing stage width by window size
window.addEventListener('resize', () => {
    const newWidth = window.innerWidth > 1024 ? 700 : 500;
    stage.width(newWidth);
});

updateDisplay();
