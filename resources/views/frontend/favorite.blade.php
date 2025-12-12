@extends('layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">مفضلة</h2>
<a href="{{ route('admin.blogs.index') }}" class="btn btn-primary mb-3">الرجوع لكل المقالات</a>
    @if($blogs->count() > 0)
    <div class="row">
        @foreach($blogs as $blog)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                @if($blog->image)
                    <img src="{{ asset('storage/'.$blog->image) }}" class="card-img-top" style="height:180px; object-fit:cover;">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $blog->title }}</h5>
                    <p class="card-text flex-grow-1">{{ Str::limit($blog->content, 100) }}</p>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ route('frontend.show', $blog->id) }}" class="btn btn-primary btn-sm">اقرأ المزيد</a>

                        <!-- زر إزالة من المفضلة -->
                        <button class="btn btn-sm toggle-favorite btn-outline-danger" data-id="{{ $blog->id }}">
                            إزالة من المفضلة
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $blogs->links() }}
    </div>

    @else
        <p>لم يتم إضافة أي مقالات للمفضلة بعد.</p>
    @endif

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-favorite').forEach(button => {
        button.addEventListener('click', function() {
            const blogId = this.dataset.id;
            const btn = this;

            fetch("{{ url('/toggle-favorite') }}/" + blogId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'removed') {
                    alert('تمت إزالة المقال من المفضلة');
                    btn.textContent = 'أضف إلى المفضلة';
                    btn.classList.remove('btn-outline-danger');
                    btn.classList.add('btn-outline-primary');
                } else if(data.status === 'added') {
                    alert('تمت إضافة المقال للمفضلة');
                    btn.textContent = 'إزالة من المفضلة';
                    btn.classList.remove('btn-outline-primary');
                    btn.classList.add('btn-outline-danger');
                }
            })
            .catch(err => console.error(err));
        });
    });
});
</script>

