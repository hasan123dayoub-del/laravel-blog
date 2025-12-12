<script>
document.addEventListener('click', function (e) {

    if (e.target.classList.contains('toggle-favorite')) {

        const btn = e.target;
        const blogId = btn.dataset.id;

        fetch('/toggle-favorite/' + blogId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {

            // 1️⃣ أضيف إلى المفضلة (في صفحة المقالات فقط)
            if (data.status === 'added') {
                btn.textContent = 'إزالة من المفضلة';
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-outline-danger');
            }

            // 2️⃣ إزالة من المفضلة
            else if (data.status === 'removed') {

                const card = document.getElementById('blog-' + blogId);

                // إذا كنا داخل صفحة المفضلة — احذف البلوك
                if (card) {
                    card.remove();
                }

                // وإذا داخل صفحة المقالات — رجّع زر الإضافة
                btn.textContent = 'إضافة للمفضلة';
                btn.classList.remove('btn-outline-danger');
                btn.classList.add('btn-outline-primary');
            }
        });
    }
});
</script>
