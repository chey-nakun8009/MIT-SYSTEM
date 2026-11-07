<h5 class="text-secondary border-bottom pb-2 mb-3">Personal Information</h5>
<div class="row mb-4">
    <x-input name="first_name" :value="old('first_name', $user->first_name ?? '')" label="នាមត្រកូល" class="col-md-6" />
    <x-input name="last_name" :value="old('last_name', $user->last_name ?? '')" label="នាមខ្លួន(មិនដាក់ក៏បាន)" class="col-md-6" />
    <x-input name="email" type="email" :value="old('email', $user->email ?? '')" label="អុីមែល" class="col-md-6" />
    <x-input name="phone" :value="old('phone', $user->phone ?? '')" label="លេខទូរស័ព្ទ" placeholder="+1234567890" class="col-md-6" />
</div>

<h5 class="text-secondary border-bottom pb-2 mb-3">គណនីនិងការកំណត់អ្នកប្រើ</h5>
<div class="row mb-4">
    <x-select name="campus_id" label="ដាក់ឲ្យធ្វើនៅសាខា" :options="$stores->pluck('name', 'id')->toArray()" :selected="old('campus_id', $user->campus_id ?? '')" class="col-md-4" />
    <x-select name="role" label="តួនាទី" :options="$roles" :selected="old('role', optional($user->roles->first())->name ?? 'customer')" class="col-md-4" />

    <x-select name="status" label="ស្ថានភាព" :options="['active' => 'សកម្ម', 'inactive' => 'អសកម្ម', 'suspended' => 'ត្រូវបានផ្អាក']" :selected="old('status', $user->status ?? 'active')" class="col-md-4" />
</div>

<h5 class="text-secondary border-bottom pb-2 mb-3">ចំណង់ចំណូលចិត្ត</h5>
<div class="row mb-4">
    <x-select name="preferred_currency" label="Preferred Currency" :options="['USD' => 'USD ($)', 'EUR' => 'EUR (€)', 'GBP' => 'GBP (£)', 'KHR' => 'KHR (៛)']" :selected="old('preferred_currency', $user->preferred_currency ?? 'USD')"
        class="col-md-4" />

    <x-select name="language" label="ភាសា" :options="['en' => 'English', 'km' => 'Khmer']" :selected="old('language', $user->language ?? 'en')" class="col-md-4" />

    <x-input name="locale" label="តំបន់" :value="old('locale', $user->locale ?? 'en')" maxlength="10" class="col-md-4" />
</div>

<h5 class="text-secondary border-bottom pb-2 mb-3">សុវត្តិភាពអ្នកប្រើ</h5>
<div class="row mb-4">
    <x-input name="password" type="password" label="ពាក្យសម្ងាត់" placeholder="Leave blank to keep current"
        class="col-md-6" />
    <x-input name="password_confirmation" type="password" label="បញ្ជក់ពាក្យសម្ងាត់" class="col-md-6" />

    <x-input name="profile" type="file" label="Profile Image" accept="image/*" class="col-12" />

    @if (!empty($user->profile))
        <div class="col-12 mb-3">
            <label class="form-label d-block text-muted small">រូបភាពបច្ចុប្បន្ន</label>
            <img src="{{ $user->showUserProfile() }}" alt="Profile" class="rounded border"
                style="width: 60px; height: 60px; object-fit: cover;">
        </div>
    @endif

    <x-textarea name="bio" label="Bio/បរិយាយ" :rows="3" class="col-12" :value="old('bio', $user->bio ?? '')" />
</div>

<div class="d-flex justify-content-end gap-2 border-top pt-3">
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary rounded-0">បោះបង់</a>
    <button type="submit" class="btn btn-primary rounded-0">
        {{ isset($user->exists) && $user->exists ? 'រក្សាទុក' : 'បង្កើត' }}
    </button>
</div>
