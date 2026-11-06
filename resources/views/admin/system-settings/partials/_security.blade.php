<h6 class="fw-bold mb-3">
    Security Settings
</h6>
<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label fw-semibold">Minimum Password Length</label>
        <input type="number" name="password_length" class="form-control"
            value="{{ $settings['password_length']->value ?? 8 }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label fw-semibold">Login Attempt Limit</label>
        <input type="number" name="login_attempts" class="form-control"
            value="{{ $settings['login_attempts']->value ?? 5 }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label fw-semibold">Session Timeout (Minutes)</label>
        <input type="number" name="session_timeout" class="form-control"
            value="{{ $settings['session_timeout']->value ?? 120 }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label fw-semibold">Lockout Wait Time (Minutes)</label>
        <input type="number" name="lockout_time" class="form-control"
            value="{{ $settings['lockout_time']->value ?? 1 }}">
    </div>
</div>
<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" name="two_factor" value="1"
        {{ $settings['two_factor']->value ?? false ? 'checked' : '' }}>
    <label class="form-check-label fw-semibold">
        Enable Two Factor Authentication
    </label>
</div>
