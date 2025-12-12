<!-- Home Page: resources/views/front/home.blade.php -->
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>جميع المدونات</title>
</head>
<body>
    <h1>جميع المدونات</h1>

    <form method="GET" action="{{ route('front.home') }}">
        <label>تصفية حسب التصنيفات:</label>
        <select name="category" onchange="this.form.submit()">
            <option value="">الكل</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </form>

    <div>
        @foreach($blogs as $blog)
            <div style="border:1px solid #ccc; margin:10px; padding:10px;">
                <h3>{{ $blog->title }}</h3>
                <img src="{{ asset('storage/blogs/' . $blog->image) }}" width="150">
                <p>{{ Str::limit($blog->content, 150) }}</p>
                <a href="{{ route('front.blog.show', $blog->id) }}">عرض التفاصيل</a>
            </div>
        @endforeach
    </div>
</body>
</html>


<!-- Show Blog Page: resources/views/front/show.blade.php -->
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>{{ $blog->title }}</title>
</head>
<body>
    <h1>{{ $blog->title }}</h1>
    <img src="{{ asset('storage/blogs/' . $blog->image) }}" width="300">
    <p>{{ $blog->content }}</p>

    <p>التصنيفات:</p>
    @foreach($blog->categories as $cat)
        <span style="padding:5px; background:#eee;">{{ $cat->name }}</span>
    @endforeach

    <form method="POST" action="{{ route('front.blog.toggleFavorite', $blog->id) }}">
        @csrf
        <button type="submit">
            {{ auth()->user()->favorites->contains($blog->id) ? 'إزالة من المفضلة' : 'إضافة إلى المفضلة' }}
        </button>
    </form>
</body>
</html>


<!-- Favorites Page: resources/views/front/favorites.blade.php -->
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>المفضلة</title>
</head>
<body>
    <h1>مدوناتي المفضلة</h1>

    @foreach($favorites as $blog)
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <h3>{{ $blog->title }}</h3>
            <img src="{{ asset('storage/blogs/' . $blog->image) }}" width="150">
            <a href="{{ route('front.blog.show', $blog->id) }}">عرض التفاصيل</a>
        </div>
    @endforeach
</body>
</html>


---
## 🔗 ربط جميع الصفحات مع بعضها (Navigation + Routes)
### ما تم إضافته:
- روابط تنقل بين الصفحات داخل كل Blade.
- زر للرجوع من صفحة التفاصيل إلى الرئيسية.
- زر للانتقال إلى صفحة المفضلة.
- روابط لفتح صفحة تفاصيل كل Blog.
- جعل كل الصفحات متصلة ببعضها تمامًا.

### نموذج الروابط المستخدمة داخل كل Blade:
```html
<nav class="mb-4 flex gap-3">
    <a href="{{ route('frontend.home') }}" class="btn btn-primary">الصفحة الرئيسية</a>
    <a href="{{ route('frontend.favorites') }}" class="btn btn-warning">مفضلتي</a>
</nav>
```

### روابط فتح التفاصيل داخل صفحة الرئيسية:
```html
<a href="{{ route('frontend.blog.show', $blog->id) }}" class="btn btn-info">عرض التفاصيل</a>
```

### زر الرجوع في صفحة التفاصيل:
```html
<a href="{{ route('frontend.home') }}" class="btn btn-secondary mt-3">رجوع</a>
```

### زر الرجوع في صفحة المفضلة:
```html
<a href="{{ route('frontend.home') }}" class="btn btn-secondary mb-3">رجوع</a>
```

### ⚠️ ملاحظة مهمة
إذا بدك أضيف الآن **Routes كاملة + Controller كامل شغال** للفرونت بشكل احترافي (HomeController أو FrontController) خبرني مباشرة وبضيفهم فورًا مع كل شيء جاهز للعمل 100٪.