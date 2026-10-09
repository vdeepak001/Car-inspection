<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $heading }}</h3>
    </div>
    <form method="POST" action="{{ $action }}">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name ?? '') }}" autocomplete="name" required class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone number</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone ?? '') }}" autocomplete="tel" required class="form-control @error('phone') is-invalid @enderror">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}" autocomplete="email" required class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input id="password" name="password" type="password" autocomplete="new-password" @if ($user === null) required @endif class="form-control @error('password') is-invalid @enderror">
                    <button type="button" class="btn btn-outline-secondary" data-toggle-password="password">Show</button>
                </div>
                @if ($user !== null)
                    <small class="form-hint">Leave blank to keep the current password. Saved passwords stay hidden.</small>
                @endif
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-0">
                <label for="password_confirmation" class="form-label">Confirm password</label>
                <div class="input-group">
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" @if ($user === null) required @endif class="form-control">
                    <button type="button" class="btn btn-outline-secondary" data-toggle-password="password_confirmation">Show</button>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="btn-list">
                <button type="submit" class="btn btn-primary">{{ $button }}</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-link">Cancel</a>
            </div>
        </div>
    </form>
</div>
@once
    <script>
        document.querySelectorAll('[data-toggle-password]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.togglePassword);
                const showing = input.type === 'text';

                input.type = showing ? 'password' : 'text';
                button.textContent = showing ? 'Show' : 'Hide';
            });
        });
    </script>
@endonce
