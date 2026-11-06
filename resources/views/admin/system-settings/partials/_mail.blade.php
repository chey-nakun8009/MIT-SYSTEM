<h6 class="fw-bold mb-3">
    Mail Configuration
</h6>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">
            Mail Driver
        </label>
        <input type="text" name="mail_driver" class="form-control"
            value="{{ $settings['mail_driver']->value ?? 'smtp' }}">

    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">
            Mail Host
        </label>
        <input type="text" name="mail_host" class="form-control" value="{{ $settings['mail_host']->value ?? '' }}">

    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-semibold">
            Mail Port
        </label>
        <input type="number" name="mail_port" class="form-control" value="{{ $settings['mail_port']->value ?? 587 }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-semibold">
            Mail Encryption
        </label>
        <select name="mail_encryption" class="form-select">
            <option value="tls" {{ ($settings['mail_encryption']->value ?? '') == 'tls' ? 'selected' : '' }}>
                TLS
            </option>
            <option value="ssl" {{ ($settings['mail_encryption']->value ?? '') == 'ssl' ? 'selected' : '' }}>
                SSL
            </option>
            <option value="" {{ empty($settings['mail_encryption']->value ?? '') ? 'selected' : '' }}>
                None
            </option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label fw-semibold">
            Mail From Name
        </label>
        <input type="text" name="mail_from_name" class="form-control"
            value="{{ $settings['mail_from_name']->value ?? '' }}">

    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">
            Mail Username
        </label>
        <input type="text" name="mail_username" class="form-control"
            value="{{ $settings['mail_username']->value ?? '' }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">
            Mail Password
        </label>
        <input type="password" name="mail_password" class="form-control"
            value="{{ $settings['mail_password']->value ?? '' }}">
    </div>
</div>
