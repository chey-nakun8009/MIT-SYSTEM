<h6 class="mb-3">
    Theme Settings
</h6>
<div class="row">
    <div class="col-6 col-md-2 mb-3">
        <label class="form-label">
            ពណ៍គោល
        </label>
        <input type="color" name="primary_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['primary_color']->value ?? '#008585' }}">
    </div>
    <div class="col-6 col-md-2 mb-3">
        <label class="form-label">
            ពណ៍បន្ទាប់
        </label>

        <input type="color" name="secondary_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['secondary_color']->value ?? '#6c757d' }}">
    </div>
    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">
            ពុម្ពអក្សរអង់គ្លេស
        </label>
        <select name="english_font" class="form-select rounded-0">

            <option value="Poppins"
                {{ ($settings['english_font']->value ?? 'Poppins') == 'Poppins' ? 'selected' : '' }}>
                Poppins
            </option>

            <option value="Inter" {{ ($settings['english_font']->value ?? '') == 'Inter' ? 'selected' : '' }}>
                Inter
            </option>

            <option value="Roboto" {{ ($settings['english_font']->value ?? '') == 'Roboto' ? 'selected' : '' }}>
                Roboto
            </option>

            <option value="Open Sans" {{ ($settings['english_font']->value ?? '') == 'Open Sans' ? 'selected' : '' }}>
                Open Sans
            </option>

            <option value="Lato" {{ ($settings['english_font']->value ?? '') == 'Lato' ? 'selected' : '' }}>
                Lato
            </option>

            <option value="Nunito" {{ ($settings['english_font']->value ?? '') == 'Nunito' ? 'selected' : '' }}>
                Nunito
            </option>

            <option value="Montserrat" {{ ($settings['english_font']->value ?? '') == 'Montserrat' ? 'selected' : '' }}>
                Montserrat
            </option>

            <option value="Ubuntu" {{ ($settings['english_font']->value ?? '') == 'Ubuntu' ? 'selected' : '' }}>
                Ubuntu
            </option>

        </select>
    </div>

    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">
            ពុម្ពអក្សរខ្មែរ
        </label>
        <select name="khmer_font" class="form-select rounded-0">
            <option value="Noto Sans Khmer"
                {{ ($settings['khmer_font']->value ?? 'Noto Sans Khmer') == 'Noto Sans Khmer' ? 'selected' : '' }}>
                Noto Sans Khmer
            </option>
            <option value="Battambang" {{ ($settings['khmer_font']->value ?? '') == 'Battambang' ? 'selected' : '' }}>
                Battambang
            </option>
            <option value="Kh Fasthand" {{ ($settings['khmer_font']->value ?? '') == 'Kh Fasthand' ? 'selected' : '' }}>
                Kh Fasthand
            </option>

            <option value="Kantumruy Pro"
                {{ ($settings['khmer_font']->value ?? '') == 'Kantumruy Pro' ? 'selected' : '' }}>
                Kantumruy Pro
            </option>

            <option value="Siemreap" {{ ($settings['khmer_font']->value ?? '') == 'Siemreap' ? 'selected' : '' }}>
                Siemreap
            </option>

            <option value="Moul" {{ ($settings['khmer_font']->value ?? '') == 'Moul' ? 'selected' : '' }}>
                Moul
            </option>

            <option value="Moulpali" {{ ($settings['khmer_font']->value ?? '') == 'Moulpali' ? 'selected' : '' }}>
                Moulpali
            </option>

            <option value="Dangrek" {{ ($settings['khmer_font']->value ?? '') == 'Dangrek' ? 'selected' : '' }}>
                Dangrek
            </option>

            <option value="Koulen" {{ ($settings['khmer_font']->value ?? '') == 'Koulen' ? 'selected' : '' }}>
                Koulen
            </option>

        </select>
    </div>

    <div class="col-4 col-md-4 mb-3">
        <label class="form-label">
            ភាសាគោល
        </label>

        <select name="default_language" class="form-select rounded-0">

            <option value="en" {{ ($settings['default_language']->value ?? 'en') == 'en' ? 'selected' : '' }}>
                English
            </option>

            <option value="km" {{ ($settings['default_language']->value ?? '') == 'km' ? 'selected' : '' }}>
                Khmer
            </option>

        </select>
    </div>
</div>

<h6 class=" mb-3 mt-4">
    Logo & Brand Settings
</h6>
<div class="row">
    <div class="col-6 col-md-2 mb-3">
        <label class="form-label">Logo Width (px)</label>
        <input type="text" name="logo_width" class="form-control rounded-0" placeholder="40px"
            value="{{ $settings['logo_width']->value ?? '40px' }}">
    </div>
    <div class="col-6 col-md-2 mb-3">
        <label class="form-label">Logo Height (px)</label>
        <input type="text" name="logo_height" class="form-control rounded-0" placeholder="40px"
            value="{{ $settings['logo_height']->value ?? '40px' }}">
    </div>
    <div class="col-4 col-md-3 mb-3">
        <label class="form-label">Border Radius</label>
        <input type="text" name="logo_border_radius" class="form-control rounded-0" placeholder="0.375rem"
            value="{{ $settings['logo_border_radius']->value ?? '0.375rem' }}">
    </div>
    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">Font Size</label>
        <input type="text" name="brand_font_size" class="form-control rounded-0" placeholder="1.25rem"
            value="{{ $settings['brand_font_size']->value ?? '1.25rem' }}">
    </div>
    <div class="col-4 col-md-3 mb-3">
        <label class="form-label">Text Color</label>
        <input type="color" name="brand_text_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['brand_text_color']->value ?? '#212529' }}">
    </div>

</div>

<h6 class=" mb-3 mt-4">
    ការកំណត់តារាង(Table setting)
</h6>
<div class="row">
    <div class="col-6 col-md-4 mb-3">
        <label class="form-label">
            ក្បាលតារាង
        </label>
        <input type="color" name="table_header_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['table_header_color']->value ?? '#008585' }}">
    </div>
    <div class="col-6 col-md-4 mb-3">
        <label class="form-label">
           ពណ៍អក្សរក្បាលតារាង
        </label>
        <input type="color" name="table_header_text_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['table_header_text_color']->value ?? '#ffffff' }}">
    </div>
    <div class="col-4 col-md-3 mb-3">
        <label class="form-label">
            បន្ទាត់ក្បាលតារាង
        </label>
        <select name="table_header_alignment" class="form-select rounded-0">
            <option value="left"
                {{ ($settings['table_header_alignment']->value ?? 'center') == 'left' ? 'selected' : '' }}>
                ឆ្វេង
            </option>

            <option value="center"
                {{ ($settings['table_header_alignment']->value ?? 'center') == 'center' ? 'selected' : '' }}>
                កណ្ដាល
            </option>

            <option value="right"
                {{ ($settings['table_header_alignment']->value ?? '') == 'right' ? 'selected' : '' }}>
                ស្ដាំ
            </option>

        </select>
    </div>
    <div class="col-4 col-md-3 mb-3">
        <label class="form-label">
            បន្ទាត់ក្នុងតារាង
        </label>
        <select name="table_body_alignment" class="form-select rounded-0">
            <option value="left"
                {{ ($settings['table_body_alignment']->value ?? 'left') == 'left' ? 'selected' : '' }}>
                ឆ្វេង
            </option>

            <option value="center"
                {{ ($settings['table_body_alignment']->value ?? '') == 'center' ? 'selected' : '' }}>
                កណ្ដាល
            </option>

            <option value="right"
                {{ ($settings['table_body_alignment']->value ?? '') == 'right' ? 'selected' : '' }}>
                ស្ដាំ
            </option>

        </select>
    </div>
    <div class="col-4 col-md-3 mb-3">
        <label class="form-label">
            H-Padding
        </label>
        <input type="text" name="table_th_padding" class="form-control rounded-0" placeholder="12px"
            value="{{ $settings['table_th_padding']->value ?? '12px' }}">
    </div>
    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">
            B-Padding
        </label>
        <input type="text" name="table_td_padding" class="form-control rounded-0" placeholder="10px"
            value="{{ $settings['table_td_padding']->value ?? '10px' }}">
    </div>
    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">
            H-Font Size
        </label>
        <input type="text" name="table_th_font_size" class="form-control" placeholder="12px"
            value="{{ $settings['table_th_font_size']->value ?? '12px' }}">
    </div>
    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">
            B-Font Size
        </label>
        <input type="text" name="table_td_font_size" class="form-control rounded-0" placeholder="10px"
            value="{{ $settings['table_td_font_size']->value ?? '10px' }}">
    </div>
</div>
<h6 class=" mb-3 mt-4">
    Toast Settings
</h6>
<div class="row">
    <div class="col-6 col-md-2 mb-3">
        <label class="form-label">Success Background</label>
        <input type="color" name="toast_bg_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['toast_bg_color']->value ?? '#198754' }}">
    </div>
    <div class="col-6 col-md-2 mb-3">
        <label class="form-label">Success Text</label>
        <input type="color" name="toast_text_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['toast_text_color']->value ?? '#ffffff' }}">
    </div>
    <div class="col-6 col-md-2 mb-3">
        <label class="form-label">Error Background</label>
        <input type="color" name="toast_error_bg_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['toast_error_bg_color']->value ?? '#dc3545' }}">
    </div>
    <div class="col-3 col-md-2 mb-3">
        <label class="form-label">Error Text</label>
        <input type="color" name="toast_error_text_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['toast_error_text_color']->value ?? '#ffffff' }}">
    </div>
    <div class="col-3 col-md-2 mb-3">
        <label class="form-label">Border Radius</label>
        <input type="text" name="toast_border_radius" class="form-control rounded-0" placeholder="0px"
            value="{{ $settings['toast_border_radius']->value ?? '0px' }}">
    </div>
</div>
<h6 class=" mb-3 mt-4">
    Button Color Settings
</h6>
<div class="row">
    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">Button BG</label>
        <input type="color" name="button_bg_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['button_bg_color']->value ?? '#008585' }}">
    </div>
    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">Button Text</label>
        <input type="color" name="button_text_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['button_text_color']->value ?? '#ffffff' }}">
    </div>
    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">Button Hover</label>
        <input type="color" name="button_hover_bg" class="form-control form-control-color rounded-0"
            value="{{ $settings['button_hover_bg']->value ?? '#006666' }}">
    </div>
    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">Sec. Button BG</label>
        <input type="color" name="btn_secondary_bg" class="form-control form-control-color rounded-0"
            value="{{ $settings['btn_secondary_bg']->value ?? '#6c757d' }}">
    </div>
    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">Sec. Text</label>
        <input type="color" name="btn_secondary_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['btn_secondary_color']->value ?? '#ffffff' }}">
    </div>
    <div class="col-4 col-md-2 mb-3">
        <label class="form-label">Sec. Hover</label>
        <input type="color" name="btn_secondary_hover_bg" class="form-control form-control-color rounded-0"
            value="{{ $settings['btn_secondary_hover_bg']->value ?? '#5c636a' }}">
    </div>
</div>

<h6 class=" mb-3 mt-4">
    Sidebar Navigation Settings
</h6>
<div class="row">
    <div class="col-4 col-md-3 mb-3">
        <label class="form-label">Active Link BG Color</label>
        <input type="color" name="sidebar_active_bg" class="form-control form-control-color rounded-0"
            value="{{ $settings['sidebar_active_bg']->value ?? '#b1401b' }}">
    </div>
    <div class="col-4 col-md-3 mb-3">
        <label class="form-label">Active Link Text Color</label>
        <input type="color" name="sidebar_active_color" class="form-control form-control-color rounded-0"
            value="{{ $settings['sidebar_active_color']->value ?? '#ffffff' }}">
    </div>
    <div class="col-4 col-md-3 mb-3">
        <label class="form-label">Link Hover BG Color</label>
        <input type="color" name="sidebar_hover_bg" class="form-control form-control-color rounded-0"
            value="{{ $settings['sidebar_hover_bg']->value ?? '#f8f9fa' }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Link Font Size</label>
        <input type="text" name="sidebar_font_size" class="form-control rounded-0" placeholder="0.95rem"
            value="{{ $settings['sidebar_font_size']->value ?? '0.95rem' }}">
    </div>

</div>
