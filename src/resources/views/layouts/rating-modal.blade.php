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

            @if(!$isSeller)
                <input type="hidden" name="role" value="buyer">
            @else
                <input type="hidden" name="role" value="seller">
            @endif

            <button class="submit-btn">送信する</button>
        </form>
    </div>
</div>

<script>
    const modalBtn = document.getElementById('open-rating-modal');
    const modal = document.getElementById('rating-modal');
    if (modalBtn && modal) {
        modalBtn.addEventListener('click', () => {
            modal.classList.add('show');
        });
    }

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

    const form = document.getElementById('rating-form');
    if(form){
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            alert("評価送信: " + ratingInput.value);
            window.location.href = "/";
        });
    }
</script>
