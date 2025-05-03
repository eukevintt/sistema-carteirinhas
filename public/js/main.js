function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', function() {
            const act = this.dataset.act;
            const name = this.dataset.name;
            const url = this.dataset.urlBase;

            document.getElementById(`modal-name-${act}`).textContent = name;
            document.getElementById(`modal-form-${act}`).action = url;
        });
    });

    // Tootltip
    const tooltip = document.getElementById('tooltip-dynamic');
    const tooltipText = document.getElementById('tooltip-dynamic-text');
    const tooltipArrow = document.getElementById('tooltip-dynamic-arrow');

    document.querySelectorAll('.tooltip-trigger').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            const text = btn.dataset.tooltip || '';
            const position = btn.dataset.tooltipPosition || 'top';
            const rect = btn.getBoundingClientRect();

            tooltipText.textContent = text;

            tooltip.classList.remove('invisible', 'opacity-0');

            const tooltipRect = tooltip.getBoundingClientRect();

            const left = rect.left + rect.width / 2 - tooltipRect.width / 2;
            let top = rect.top + window.scrollY - tooltipRect.height - 8;

            tooltip.style.left = `${left}px`;
            tooltip.style.top = `${top}px`;

            tooltipArrow.style.top = '100%';
            tooltipArrow.style.left = '50%';
            tooltipArrow.style.transform = 'translateX(-50%)';

            console.log('Texto:', tooltipText.textContent, 'Largura:', tooltip.getBoundingClientRect().width);

        });

        btn.addEventListener('mouseleave', () => {
            tooltip.classList.add('invisible', 'opacity-0');
        });
    });


});


