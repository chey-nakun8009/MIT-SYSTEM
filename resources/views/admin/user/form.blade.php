<h5 class="text-secondary border-bottom pb-2 mb-3">Personal Information</h5>
<div class="row mb-4">
    <x-input name="first_name" :value="old('first_name', $user->first_name ?? '')" label="First Name" class="col-md-6" />
    <x-input name="last_name" :value="old('last_name', $user->last_name ?? '')" label="Last Name" class="col-md-6" />
    <x-input name="email" type="email" :value="old('email', $user->email ?? '')" label="Email Address" class="col-md-6" />
    <x-input name="phone" :value="old('phone', $user->phone ?? '')" label="Phone Number" placeholder="+1234567890" class="col-md-6" />
</div>

<h5 class="text-secondary border-bottom pb-2 mb-3">Account & Campus Settings</h5>
<div class="row mb-4">
    <x-select name="campus_id" label="Assigned Campus" :options="$stores->pluck('name', 'id')->toArray()" :selected="old('campus_id', $user->campus_id ?? '')" class="col-md-4" />
    <x-select name="role" label="Role" :options="$roles" :selected="old('role', optional($user->roles->first())->name ?? 'customer')" class="col-md-4" />

    <x-select name="status" label="Status" :options="['active' => 'Active', 'inactive' => 'Inactive', 'suspended' => 'Suspended']" :selected="old('status', $user->status ?? 'active')" class="col-md-4" />
</div>

<h5 class="text-secondary border-bottom pb-2 mb-3">Preferences</h5>
<div class="row mb-4">
    <x-select name="preferred_currency" label="Preferred Currency" :options="['USD' => 'USD ($)', 'EUR' => 'EUR (€)', 'GBP' => 'GBP (£)', 'KHR' => 'KHR (៛)']" :selected="old('preferred_currency', $user->preferred_currency ?? 'USD')"
        class="col-md-4" />

    <x-select name="language" label="Language" :options="['en' => 'English', 'ch' => 'Chinese', 'km' => 'Khmer']" :selected="old('language', $user->language ?? 'en')" class="col-md-4" />

    <x-input name="locale" label="Locale" :value="old('locale', $user->locale ?? 'en')" maxlength="10" class="col-md-4" />
</div>

<h5 class="text-secondary border-bottom pb-2 mb-3">Security & Profile</h5>
<div class="row mb-4">
    <x-input name="password" type="password" label="Password" placeholder="Leave blank to keep current"
        class="col-md-6" />
    <x-input name="password_confirmation" type="password" label="Confirm Password" class="col-md-6" />

    <x-input name="profile" type="file" label="Profile Image" accept="image/*" class="col-12" />

    @if (!empty($user->profile))
        <div class="col-12 mb-3">
            <label class="form-label d-block text-muted small">Current Profile Image</label>
            <img src="{{ $user->showUserProfile() }}" alt="Profile" class="rounded border"
                style="width: 60px; height: 60px; object-fit: cover;">
        </div>
    @endif

    <x-textarea name="bio" label="Profile Bio / Notes" :rows="3" class="col-12" :value="old('bio', $user->bio ?? '')" />
</div>

<div class="d-flex justify-content-end gap-2 border-top pt-3">
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary rounded-0">Cancel</a>
    <button type="submit" class="btn btn-primary rounded-0">
        {{ isset($user->exists) && $user->exists ? 'Update User' : 'Create User' }}
    </button>
</div>
