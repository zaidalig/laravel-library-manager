<div class="row g-3">
<div class="col-md-3"><label class="form-label">Member Code</label><input name="member_code" class="form-control" value="{{ old('member_code', $member->member_code ?? '') }}" required></div>
<div class="col-md-5"><label class="form-label">Full Name</label><input name="name" class="form-control" value="{{ old('name', $member->name ?? '') }}" required></div>
<div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $member->email ?? '') }}"></div>
<div class="col-md-4"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone', $member->phone ?? '') }}"></div>
<div class="col-md-4"><label class="form-label">Joined At</label><input type="date" name="joined_at" class="form-control" value="{{ old('joined_at', isset($member) ? $member->joined_at->format('Y-m-d') : date('Y-m-d')) }}" required></div>
<div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['active','inactive'] as $s)<option value="{{ $s }}" @selected(old('status', $member->status ?? 'active')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
<div class="col-12"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2">{{ old('address', $member->address ?? '') }}</textarea></div>
</div>
