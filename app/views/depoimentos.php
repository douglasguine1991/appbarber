<!-- depoimento.php -->
<!DOCTYPE html>
<html lang="pt-br">

<?php 
require_once('template/head.php');
?>

<body>
<form method="POST" action="<?= BASE_URL ?>index.php?url=depoimento/enviarDepoimento">
        <h2>DEIXE SEU DEPOIMENTO</h2>
        <div class="depoimento-container">

            <h6>SEU DEPOIMENTO</h6>
            <textarea name="descricao" id="descricao" required></textarea>

            <h6>NOTA:</h6>
            <div class="stars" id="star-rating">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>

            <input type="hidden" id="nota" name="nota" value="0">

            <button type="submit" class="btn">ENVIAR DEPOIMENTO</button>
        </div>
    </form>

    <script>
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('nota');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const rating = star.getAttribute('data-value');
                ratingInput.value = rating;

                // Estilizar visualmente as estrelas selecionadas
                stars.forEach(s => {
                    s.classList.remove('selected');
                    if (s.getAttribute('data-value') <= rating) {
                        s.classList.add('selected');
                    }
                });
            });
        });
    </script>
</body>
</html>
