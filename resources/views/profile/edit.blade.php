@extends('layouts.app')

@section('title', 'Account Settings')

@section('extra-css')
    <style>
        .settings-page {
            background: #f4f4f4;
            min-height: calc(100vh - 200px);
            padding: 36px 16px 60px;
        }

        .settings-shell {
            max-width: 760px;
            margin: 0 auto;
        }

        .settings-title {
            font-size: 20px;
            font-weight: 800;
            line-height: 1.1;
            margin: 6px 0 22px;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            color: #111827;
        }

        .settings-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 18px;
        }

        .settings-tab-btn {
            border: 1px solid #d8d8d8;
            background: #f2f2f2;
            color: #6b7280;
            font-size: 15px;
            font-weight: 300;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .settings-tab-btn.active {
            color: #111827;
            background: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        }

        .settings-tab-btn i {
            font-size: 18px;
        }

        .settings-card {
            border: 1px solid #d8d8d8;
            background: rgba(255, 255, 255, 0.88);
            padding: 28px 26px;
        }

        .settings-panel {
            display: none;
        }

        .settings-panel.active {
            display: block;
        }

        .panel-title {
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
            margin: 0 0 18px;
            line-height: 1.2;
            color: #111827;
        }

        .field-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #111827;
        }

        .field-note {
            color: #6b7280;
            margin-top: 5px;
            font-size: 13px;
        }

        .field {
            margin-bottom: 14px;
        }

        .field input {
            width: 100%;
            border: 1px solid #d8d8d8;
            background: #fff;
            color: #111827;
            font-size: 15px;
            height: 48px;
            padding: 0 14px;
        }

        .field input:focus {
            outline: 2px solid rgba(212, 124, 23, 0.25);
            border-color: #d47c17;
        }

        .field-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .btn-primary-settings {
            width: 100%;
            margin-top: 8px;
            background: #d47c17;
            border: none;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            height: 52px;
            text-transform: uppercase;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            letter-spacing: 0.3px;
        }

        .btn-primary-settings:hover {
            background: #bc6f14;
        }

        .error-line {
            color: #b91c1c;
            font-size: 12px;
            margin-top: 4px;
        }

        .status-ok {
            color: #065f46;
            font-size: 13px;
            margin: 0 0 14px;
        }

        @media (max-width: 900px) {
            .settings-title {
                font-size: 24px;
            }

            .settings-tab-btn {
                font-size: 14px;
                padding: 10px;
            }

            .settings-tab-btn i {
                font-size: 14px;
            }

            .panel-title {
                font-size: 16px;
                margin-bottom: 14px;
            }

            .field-label {
                font-size: 14px;
            }

            .field input,
            .btn-primary-settings {
                height: 46px;
                font-size: 14px;
            }

            .field-note,
            .error-line,
            .status-ok {
                font-size: 12px;
            }
        }

        @media (max-width: 640px) {
            .settings-card {
                padding: 22px 16px;
            }

            .settings-tabs {
                gap: 10px;
                grid-template-columns: 1fr;
            }

            .settings-title {
                font-size: 21px;
            }

            .field-grid-2 {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .settings-tab-btn {
                font-size: 14px;
            }
        }

        @media (max-width: 390px) {
            .settings-page {
                padding: 28px 10px 46px;
            }

            .settings-title {
                font-size: 19px;
                margin-bottom: 14px;
            }

            .settings-card {
                padding: 16px 12px;
            }

            .settings-tab-btn {
                font-size: 13px;
            }
        }

        @media (max-width: 360px) {
            .btn-primary-settings {
                font-size: 13px;
                letter-spacing: 0;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .settings-shell {
                max-width: 700px;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $isAdminSettings = $isAdminSettings ?? false;
        $profileRoute = $isAdminSettings ? 'admin.settings.update' : 'profile.update';
        $showSecurityByDefault = $errors->updatePassword->isNotEmpty() || session('status') === 'password-updated';
        $phoneValue = old('phone_number', $isAdminSettings ? '' : $user->phone_number);
    @endphp

    <section class="settings-page">
        <div class="settings-shell">
            <h1 class="settings-title">Account Settings</h1>

            <div class="settings-tabs">
                <button type="button" class="settings-tab-btn {{ $showSecurityByDefault ? '' : 'active' }}" data-tab="profile-panel">
                    <i class="far fa-user"></i>
                    Profile
                </button>
                <button type="button" class="settings-tab-btn {{ $showSecurityByDefault ? 'active' : '' }}" data-tab="security-panel">
                    <i class="fas fa-lock"></i>
                    Security
                </button>
            </div>

            <div class="settings-card">
                <div id="profile-panel" class="settings-panel {{ $showSecurityByDefault ? '' : 'active' }}">
                    <h2 class="panel-title">Personal Information</h2>

                    @if (session('status') === 'profile-updated')
                        <p class="status-ok">Profile updated successfully.</p>
                    @endif

                    <form method="POST" action="{{ route($profileRoute) }}">
                        @csrf
                        @method('PATCH')

                        <div class="field">
                            <label class="field-label" for="settings-email">Email Address</label>
                            <input
                                id="settings-email"
                                name="email"
                                type="email"
                                value="{{ old('email', $user->email) }}"
                                {{ $isAdminSettings ? 'readonly' : '' }}
                                required
                            >
                            @if ($isAdminSettings)
                                <div class="field-note">Email cannot be changed</div>
                            @endif
                            @error('email')
                                <div class="error-line">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-grid-2">
                            <div class="field">
                                <label class="field-label" for="settings-first-name">First Name</label>
                                <input id="settings-first-name" name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}" required>
                                @error('first_name')
                                    <div class="error-line">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="field">
                                <label class="field-label" for="settings-last-name">Last Name</label>
                                <input id="settings-last-name" name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}" required>
                                @error('last_name')
                                    <div class="error-line">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="field">
                            <label class="field-label" for="settings-phone">Phone Number</label>
                            <input id="settings-phone" name="phone_number" type="text" value="{{ $phoneValue }}">
                            @error('phone_number')
                                <div class="error-line">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="field-label" for="settings-street-address">Street Address</label>
                            <input id="settings-street-address" name="street_address" type="text" value="{{ old('street_address', $user->street_address) }}">
                            @error('street_address')
                                <div class="error-line">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-grid-2">
                            <div class="field">
                                <label class="field-label" for="settings-city">City</label>
                                <input id="settings-city" name="city" type="text" value="{{ old('city', $user->city) }}">
                                @error('city')
                                    <div class="error-line">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="field">
                                <label class="field-label" for="settings-postal-code">Postal Code</label>
                                <input id="settings-postal-code" name="postal_code" type="text" value="{{ old('postal_code', $user->postal_code) }}">
                                @error('postal_code')
                                    <div class="error-line">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn-primary-settings">
                            <i class="far fa-floppy-disk"></i>
                            Save Changes
                        </button>
                    </form>
                </div>

                <div id="security-panel" class="settings-panel {{ $showSecurityByDefault ? 'active' : '' }}">
                    <h2 class="panel-title">Change Password</h2>

                    @if (session('status') === 'password-updated')
                        <p class="status-ok">Password changed successfully.</p>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="field">
                            <label class="field-label" for="settings-current-password">Current Password</label>
                            <input id="settings-current-password" name="current_password" type="password" autocomplete="current-password">
                            @if ($errors->updatePassword->has('current_password'))
                                <div class="error-line">{{ $errors->updatePassword->first('current_password') }}</div>
                            @endif
                        </div>

                        <div class="field">
                            <label class="field-label" for="settings-new-password">New Password</label>
                            <input id="settings-new-password" name="password" type="password" autocomplete="new-password">
                            @if ($errors->updatePassword->has('password'))
                                <div class="error-line">{{ $errors->updatePassword->first('password') }}</div>
                            @endif
                        </div>

                        <div class="field">
                            <label class="field-label" for="settings-confirm-password">Confirm New Password</label>
                            <input id="settings-confirm-password" name="password_confirmation" type="password" autocomplete="new-password">
                            @if ($errors->updatePassword->has('password_confirmation'))
                                <div class="error-line">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                            @endif
                        </div>

                        <button type="submit" class="btn-primary-settings">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('extra-js')
    <script>
        (function () {
            const tabButtons = document.querySelectorAll('.settings-tab-btn');
            const tabPanels = document.querySelectorAll('.settings-panel');

            tabButtons.forEach((button) => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-tab');

                    tabButtons.forEach((btn) => btn.classList.remove('active'));
                    tabPanels.forEach((panel) => panel.classList.remove('active'));

                    this.classList.add('active');
                    const panel = document.getElementById(targetId);

                    if (panel) {
                        panel.classList.add('active');
                    }
                });
            });
        })();
    </script>
@endsection
