<div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100 shadow-sm">
        @if($blog->image)
            <img src="{{ asset('storage/blogs/'.$blog->image) }}" class="card-img-top" style="height:180px; object-fit:cover;">
        @endif
        <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $blog->title }}</h5>
            <p class="card-text flex-grow-1">{{ Str::limit($blog->content, 100) }}</p>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="{{ route('frontend.show', $blog->id) }}" class="btn btn-primary btn-sm">اقرأ المزيد</a>

                @if($type === 'deleted')
                    <!-- زر استرجاع المقال -->
                    <form action="{{ route('frontend.restore', $blog->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-success btn-sm">استرجاع</button>
                    </form>
                @else
                    <!-- زر إضافة / إزالة المفضلة -->
                    <button class="btn btn-sm toggle-favorite
    @if(Auth::user() && Auth::user()->favorites->contains($blog->id))
        btn-outline-danger
    @else
        btn-outline-primary
    @endif
" data-id="{{ $blog->id }}">
    @if(Auth::user() && Auth::user()->favorites->contains($blog->id))
        إزالة من المفضلة
    @else
        إضافة للمفضلة
    @endif
</button>

                @endif
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('click', function (e) {
    // نتحقق إذا كبس على زر toggle-favorite
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
            if (data.status === 'added') {
                // تحديث الزر
                btn.textContent = 'إزالة من المفضلة';
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-outline-danger');
            } 
            else if (data.status === 'removed') {

                // إذا كنا في صفحة المفضلة، احذف البلوك
                const block = document.getElementById('blog-' + blogId);
                if (block) {
                    block.remove();
                    alert('تمت إزالة المقال من المفضلة');
                }

                // وإذا كنا في صفحة المقالات، رجّع الزر ليصير "إضافة للمفضلة"
                btn.textContent = 'إضافة للمفضلة';
                btn.classList.remove('btn-outline-danger');
                btn.classList.add('btn-outline-primary');
            }
        })
        .catch(err => console.error(err));
    }
});
</script>
