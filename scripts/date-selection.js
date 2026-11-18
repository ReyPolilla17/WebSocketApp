function updateDaysAviable() {
    const day = document.getElementById("day"); // El día seleccionado
    const month = document.getElementById("month"); // El mes seleccionao
    const year = document.getElementById("year"); // El año introducido

    const curYear = new Date().getFullYear(); // El año actual
    let maxDay = new Date(year.value, month.value, 0).getDate(); // Obtiene el último día del mes seleccionado

    const dayIndex = day.selectedIndex; // guarda el día seleccionado

    const daysAv = [`<option value="0" style="display: none;">Día</option>`]; // arreglo con los días disponibles

    if(isNaN(year.value) || year.value === '') { // si se introduce un valor inválido de año, considera el año actual
        maxDay = new Date(curYear, month.value, 0).getDate();
    }
    
    for(i = 1; i <= maxDay; i++) { // agrega cada día que puede tener el mes
        daysAv.push(`<option value="${i}">${i}</option>`);
    }

    day.innerHTML = daysAv.join("\n"); // coloca todos los días al menú de selección

    // si el día seleccionado es mayor al máximo disponible, lo recorre, de lo contrario, lo conserva
    if(dayIndex > maxDay) {
        day.selectedIndex = maxDay;
    } else {
        day.selectedIndex = dayIndex;
    }
}