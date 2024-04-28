"use strict";

export function clock() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const day = now.toLocaleDateString('pt-BR', { day: 'numeric' }).toString().padStart(2, '0');
    const month = now.toLocaleDateString('pt-BR', { month: 'long' });
    const weekday = now.toLocaleDateString('pt-BR', { weekday: 'long' });

    document.querySelector('.da-widget-clock__hours').innerHTML = `
        <p class="da-widget-clock__label">Agora são:</p>
        <div class="da-widget-clock__hour-display">
            <span class="da-widget-clock__hour">${hours}</span>
            <span class="da-widget-clock__dot">:</span>
            <span class="da-widget-clock__minute">${minutes}</span>
            <span class="da-widget-clock__dot">:</span>
            <span class="da-widget-clock__second">${seconds}</span>
        </div>
    `;

    document.querySelector('.da-widget-clock__date').innerHTML = `
        <span class="da-widget-clock__month text-capitalize">${month}</span>
        <span class="da-widget-clock__day">${day}</span>
        <span class="da-widget-clock__day-name">${weekday}</span>
    `;
}
