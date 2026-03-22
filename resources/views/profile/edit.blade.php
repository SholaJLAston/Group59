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

        .btn-delete-account {
            background: #dc2626;
            border-radius: 6px;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            height: 52px;
            text-transform: uppercase;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            letter-spacing: 0.3px;
            margin-top: 8px;
            transition: background 0.2s ease;
        }

        .btn-delete-account:hover {
            background: #991b1b;
        }

        .delete-warning {
            background: #fef2f2;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 8px;
            color: #7f1d1d;
            font-size: 14px;
            margin-bottom: 16px;
        }

        .modal-delete {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-delete.show {
            display: flex;
        }

        .modal-delete-content {
            background: #fff;
            border-radius: 12px;
            padding: 32px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
        }

        .modal-delete-title {
            font-size: 18px;
            font-weight: 700;
            color: #dc2626;
            margin-bottom: 12px;
        }

        .modal-delete-text {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .modal-delete-footer {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .btn-modal-cancel {
            background: #e5e7eb;
            border: none;
            color: #374151;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-modal-google {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #111827;
            height: 42px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-modal-google:hover {
            background: #f9fafb;
        }

        .btn-modal-cancel:hover {
            background: #d1d5db;
        }

        .btn-modal-delete {
            background: #dc2626;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
        }

        .modal-delete-footer .btn-modal-cancel,
        .modal-delete-footer .btn-modal-delete {
            min-width: 185px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-modal-delete[disabled] {
            opacity: 0.55;
            cursor: not-allowed;
        }

        .btn-modal-delete:hover {
            background: #991b1b;
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
                grid-template-columns: 1fr !important;
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

            .modal-delete-footer .btn-modal-cancel,
            .modal-delete-footer .btn-modal-delete {
                width: 100%;
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

            <div class="settings-tabs" style="grid-template-columns: 1fr 1fr 1fr;">
                <button type="button" class="settings-tab-btn {{ $showSecurityByDefault ? '' : 'active' }}" data-tab="profile-panel">
                    <i class="far fa-user"></i>
                    Profile
                </button>
                <button type="button" class="settings-tab-btn {{ $showSecurityByDefault ? 'active' : '' }}" data-tab="security-panel">
                    <i class="fas fa-lock"></i>
                    Security
                </button>
                <button type="button" class="settings-tab-btn" data-tab="delete-panel">
                    <i class="fas fa-trash"></i>
                    Delete Account
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

                <div id="delete-panel" class="settings-panel">
                    <h2 class="panel-title">Delete Account</h2>

                    <div class="delete-warning">
                        <strong style="color: #991b1b;">Warning:</strong> Once your account is deleted, all of your data will be permanently deleted. This action cannot be undone. Please make sure you have downloaded any important information before proceeding.
                    </div>

                    <p style="color: #6b7280; font-size: 14px; margin-bottom: 20px;">
                        @if (($user->auth_provider ?? 'local') === 'google')
                            If you wish to delete your account permanently, click the button below. You will confirm with Google first, then complete deletion.
                        @else
                            If you wish to delete your account permanently, click the button below. You will be asked to confirm your password.
                        @endif
                    </p>

                    @if (session('status') === 'google-delete-reauth-confirmed')
                        <p class="status-ok">Google confirmation complete. Open delete and confirm to permanently remove your account.</p>
                    @endif

                    @if ($errors->userDeletion->has('google_reauth'))
                        <div class="error-line">{{ $errors->userDeletion->first('google_reauth') }}</div>
                    @endif

                    <button type="button" class="btn-delete-account" onclick="document.getElementById('deleteAccountModal').classList.add('show')">
                        <i class="fas fa-trash"></i>
                        Delete My Account
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Account Confirmation Modal -->
    <div id="deleteAccountModal" class="modal-delete">
        <div class="modal-delete-content">
            <h3 class="modal-delete-title">
                <i class="fas fa-exclamation-triangle"></i>
                Are you sure?
            </h3>
            
            <p class="modal-delete-text">
                <strong>This action is permanent and cannot be reversed.</strong> All your orders, messages, and personal information will be deleted from our system.
            </p>

            <p class="modal-delete-text">
                @if (($user->auth_provider ?? 'local') === 'google')
                    Confirm with Google first, then permanently delete your account.
                @else
                    Please enter your password to confirm you want to permanently delete your account.
                @endif
            </p>

            @if (($user->auth_provider ?? 'local') === 'google')
                @if (session('status') === 'google-delete-reauth-confirmed')
                    <p class="status-ok">Google confirmation complete. You can now delete your account.</p>
                @endif

                @if ($errors->userDeletion->has('google_reauth'))
                    <div class="error-line">{{ $errors->userDeletion->first('google_reauth') }}</div>
                @endif

                <form method="POST" action="{{ route('profile.delete.google.reauth') }}" style="margin-bottom:12px;">
                    @csrf
                    <button type="submit" class="btn-modal-google">
                        Continue with Google
                    </button>
                </form>
            @endif

            <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                @csrf
                @method('DELETE')

                @if (($user->auth_provider ?? 'local') !== 'google')
                    <div class="field">
                        <label class="field-label" for="delete-password">Your Password</label>
                        <input 
                            id="delete-password" 
                            name="password" 
                            type="password" 
                            placeholder="Enter your password"
                            required
                            autofocus
                        >
                        @if ($errors->userDeletion->has('password'))
                            <div class="error-line">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>
                @endif

                <div class="modal-delete-footer">
                    <button type="button" class="btn-modal-cancel" onclick="document.getElementById('deleteAccountModal').classList.remove('show')">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="btn-modal-delete"
                        @if (($user->auth_provider ?? 'local') === 'google' && !session()->has('google_delete_confirmed_at')) disabled @endif
                    >
                        Delete Account Permanently
                    </button>
                </div>

                @if (($user->auth_provider ?? 'local') === 'google' && !session()->has('google_delete_confirmed_at'))
                    <div class="field-note">Complete Google confirmation first to enable account deletion.</div>
                @endif
            </form>
        </div>
    </div>

    <script>
        // Close modal when clicking outside of it
        document.getElementById('deleteAccountModal').addEventListener('click', function(event) {
            if (event.target === this) {
                this.classList.remove('show');
            }
        });
    </script>
@endsection

@section('extra-js')
    <script>
        (function () {
            const tabButtons = document.querySelectorAll('.settings-tab-btn');
            const tabPanels = document.querySelectorAll('.settings-panel');
            const deleteModal = document.getElementById('deleteAccountModal');
            const deleteTabButton = document.querySelector('[data-tab="delete-panel"]');
            const shouldOpenDeleteFlow = @json(session('status') === 'google-delete-reauth-confirmed' || $errors->userDeletion->isNotEmpty());

            function activateTab(targetId) {
                tabButtons.forEach((btn) => btn.classList.remove('active'));
                tabPanels.forEach((panel) => panel.classList.remove('active'));

                const button = document.querySelector('[data-tab="' + targetId + '"]');
                const panel = document.getElementById(targetId);

                if (button) {
                    button.classList.add('active');
                }

                if (panel) {
                    panel.classList.add('active');
                }
            }

            tabButtons.forEach((button) => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-tab');
                    activateTab(targetId);
                });
            });

            if (shouldOpenDeleteFlow) {
                activateTab('delete-panel');

                if (deleteModal) {
                    deleteModal.classList.add('show');
                }
            }

            // Close modal on Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    if (deleteModal) {
                        deleteModal.classList.remove('show');
                    }
                }
            });
        })();
    </script>
@endsection
