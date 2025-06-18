document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star');
    let selectedRating = 0;

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            selectedRating = index + 1;
            updateStars();
            const inputNota = document.getElementById('nota');
            if (inputNota) inputNota.value = selectedRating;
        });

        star.addEventListener('mouseover', () => {
            updateStars(index + 1);
        });

        star.addEventListener('mouseout', () => {
            updateStars();
        });
    });

    function updateStars(hoverValue = 0) {
        stars.forEach((star, index) => {
            if (hoverValue > 0) {
                star.classList.toggle('hover', index < hoverValue);
            } else {
                star.classList.remove('hover');
            }

            star.classList.toggle('selected', index < selectedRating);
        });
    }
});
