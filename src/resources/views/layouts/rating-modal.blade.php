<div class="modal-overlay">
    <div class="modal-content">
        <h2>取引が完了しました。</h2>
        <p>今回の取引相手はどうでしたか？</p>

        <div class="stars">
            @for ($i = 1; $i <= 5; $i++)
                <span class="star" data-value="{{ $i }}">★</span>
            @endfor
        </div>

        <form action="{{ route('rating.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="transaction_id" value="{{ $transaction->id ?? ''  }}">
            <input type="hidden" name="rating" id="rating_value">
            <button class="submit-btn">送信する</button>
        </form>
    </div>
</div>

<script>
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating_value');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.dataset.value;
            ratingInput.value = rating;

            stars.forEach(s => s.classList.remove('selected'));
            for (let i = 0; i < rating; i++) {
                stars[i].classList.add('selected');
            }
        });
    });
</script>