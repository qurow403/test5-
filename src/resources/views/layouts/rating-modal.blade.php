<h2>取引が完了しました。</h2>
<p>今回の取引相手はどうでしたか？</p>

<div class="stars" data-transaction-id="{{ $transaction->id }}">
    @for ($i = 1; $i <= 5; $i++)
        <span class="star" data-value="{{ $i }}">★</span>
    @endfor
</div>

<form action="{{ route('rating.submit') }}" method="POST" class="rating-form" data-transaction-id="{{ $transaction->id }}">
    @csrf
    <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
    <input type="hidden" name="rating" class="rating-value">
    <input type="hidden" name="role" value="{{ $isSeller ? 'seller' : 'buyer' }}">
    <button type="submit" class="submit-btn">送信する</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.rating-form').forEach(form => {
        const starsContainer = form.closest('.modal-content').querySelector('.stars');
        const stars = starsContainer.querySelectorAll('.star');
        const ratingInput = form.querySelector('.rating-value');

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                const rating = star.dataset.value;
                ratingInput.value = rating;

                stars.forEach(s => s.classList.remove('selected'));
                for (let i = 0; i < rating; i++) stars[i].classList.add('selected');
            });
        });

        form.addEventListener('submit', e => {
            e.preventDefault();
            if (!ratingInput.value) {
                alert("評価を選択してください");
                return;
            }

            const formData = new FormData(form);

            fetch("{{ route('rating.submit') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name=_token]').value
                },
                body: formData
            })
            .then(res => res.ok ? res.json() : Promise.reject(res))
            .then(data => {
                alert('評価を送信しました');
                window.location.href = "{{ route('items.index') }}";
            })
            .catch(err => {
                console.error(err);
                alert('送信に失敗しました');
            });
        });
    });
});
</script>
