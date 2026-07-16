<div class="row g-3">
<div class="col-md-3"><label class="form-label">ISBN</label><input name="isbn" class="form-control" value="{{ old('isbn', $book->isbn ?? '') }}" required></div>
<div class="col-md-5"><label class="form-label">Title</label><input name="title" class="form-control" value="{{ old('title', $book->title ?? '') }}" required></div>
<div class="col-md-4"><label class="form-label">Author</label><input name="author" class="form-control" value="{{ old('author', $book->author ?? '') }}" required></div>
<div class="col-md-4"><label class="form-label">Genre</label><select name="genre_id" class="form-select"><option value="">None</option>@foreach($genres as $g)<option value="{{ $g->id }}" @selected(old('genre_id', $book->genre_id ?? '')==$g->id)>{{ $g->name }}</option>@endforeach</select></div>
<div class="col-md-2"><label class="form-label">Published Year</label><input type="number" name="published_year" class="form-control" value="{{ old('published_year', $book->published_year ?? '') }}"></div>
<div class="col-md-2"><label class="form-label">Total Copies</label><input type="number" name="total_copies" class="form-control" min="1" value="{{ old('total_copies', $book->total_copies ?? 1) }}" required></div>
<div class="col-md-2"><label class="form-label">Available Copies</label><input type="number" name="available_copies" class="form-control" min="0" value="{{ old('available_copies', $book->available_copies ?? 1) }}" required></div>
<div class="col-md-2"><label class="form-label">Shelf</label><input name="shelf_location" class="form-control" value="{{ old('shelf_location', $book->shelf_location ?? '') }}"></div>
<div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['active','inactive'] as $s)<option value="{{ $s }}" @selected(old('status', $book->status ?? 'active')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Cover Image</label><input type="file" name="cover" class="form-control" accept="image/*">@if(!empty($book?->cover_path))<div class="mt-2"><img src="{{ $book->coverUrl() }}" alt="Current cover" class="book-cover-thumb rounded border"></div>@endif</div>
</div>
