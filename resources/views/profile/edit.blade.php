<x-app-layout>
    <style>
        .profile-edit-page {
            min-height: calc(100vh - 4rem);
            background: linear-gradient(180deg, #edf4fb 0%, #f6f8fb 100%);
            color: #0f2747;
            padding: 28px 20px;
        }

        .profile-edit-shell {
            max-width: 1180px;
            margin: 0 auto;
        }

        .profile-edit-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 18px;
        }

        .profile-edit-kicker {
            color: #8a3b12;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .profile-edit-title {
            margin: 4px 0 0;
            color: #071d36;
            font-size: 26px;
            font-weight: 900;
            line-height: 1.1;
        }

        .profile-edit-subtitle {
            margin-top: 5px;
            color: #5b708c;
            font-size: 14px;
            font-weight: 600;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
        }

        .profile-panel {
            overflow: hidden;
            border: 1px solid #d5dfeb;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 16px 36px rgba(15, 39, 71, .08);
        }

        .profile-panel-header {
            border-bottom: 1px solid #dce5ef;
            background: linear-gradient(135deg, #ffffff 0%, #f6f9fd 100%);
            padding: 24px;
        }

        .profile-panel-title {
            margin: 0;
            color: #071d36;
            font-size: 20px;
            font-weight: 900;
        }

        .profile-panel-copy {
            margin: 8px 0 0;
            color: #536b88;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.55;
        }

        .profile-panel-body {
            padding: 24px;
        }

        .profile-form {
            display: grid;
            gap: 18px;
        }

        .profile-photo-box {
            display: grid;
            grid-template-columns: 76px minmax(0, 1fr);
            gap: 18px;
            align-items: center;
            border: 1px solid #dbe4ef;
            border-radius: 10px;
            background: #f8fbff;
            padding: 16px;
        }

        .profile-avatar {
            width: 68px;
            height: 68px;
            border: 3px solid #ffffff;
            border-radius: 999px;
            object-fit: cover;
            object-position: top;
            box-shadow: 0 10px 18px rgba(15, 39, 71, .16);
        }

        .profile-label {
            display: block;
            margin-bottom: 8px;
            color: #102a4b;
            font-size: 14px;
            font-weight: 800;
        }

        .profile-file-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }

        .profile-file-button,
        .profile-primary-button {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 8px;
            background: #0e0e0e;
            color: #ffffff;
            padding: 0 18px;
            font-size: 14px;
            font-weight: 900;
            text-decoration: none;
            box-shadow: 0 10px 18px rgba(138, 59, 18, .18);
            cursor: pointer;
        }

        .profile-file-button:hover,
        .profile-primary-button:hover {
            background: #71300f;
        }

        .profile-secondary-button {
            display: inline-flex;
            min-height: 40px;
            align-items: center;
            justify-content: center;
            border: 1px solid #c9d6e5;
            border-radius: 8px;
            background: #ffffff;
            color: #173d67;
            padding: 0 16px;
            font-size: 13px;
            font-weight: 900;
            text-decoration: none;
        }

        .profile-file-name,
        .profile-help {
            color: #536b88;
            font-size: 13px;
            font-weight: 600;
        }

        .profile-help {
            margin-top: 7px;
        }

        .profile-input {
            display: block;
            width: 100%;
            min-height: 48px;
            border: 1px solid #c9d6e5;
            border-radius: 8px;
            background: #ffffff;
            color: #0f2747;
            padding: 0 14px;
            font-size: 15px;
            font-weight: 800;
            outline: none;
            box-shadow: 0 1px 2px rgba(15, 39, 71, .04);
        }

        .profile-input:focus {
            border-color: #8a3b12;
            box-shadow: 0 0 0 3px rgba(138, 59, 18, .12);
        }

        .profile-input[readonly] {
            background: #fbfdff;
        }

        .profile-password-wrap {
            position: relative;
        }

        .profile-password-input {
            padding-right: 48px;
        }

        .profile-eye-button {
            position: absolute;
            right: 12px;
            bottom: 12px;
            display: grid;
            width: 26px;
            height: 26px;
            place-items: center;
            border: 0;
            background: transparent;
            color: #63758b;
            cursor: pointer;
        }

        .profile-eye-button:hover {
            color: #173d67;
        }

        .profile-eye-button svg {
            width: 20px;
            height: 20px;
        }

        .profile-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            border-top: 1px solid #dce5ef;
            padding-top: 18px;
        }

        @media (max-width: 960px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-edit-head,
            .profile-actions {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 560px) {
            .profile-edit-page {
                padding: 16px 12px;
            }

            .profile-photo-box {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="profile-edit-page">
        <div class="profile-edit-shell">
            <div class="profile-edit-head">
                <div>
                    <div class="profile-edit-kicker">Mi cuenta</div>
                    <h1 class="profile-edit-title">Editar perfil</h1>
                    <div class="profile-edit-subtitle">Administra tu foto y la seguridad de acceso.</div>
                </div>

                <a href="{{ route(auth()->user()->homeRouteName()) }}" class="profile-secondary-button">Volver</a>
            </div>

            <div class="profile-grid">
                <section class="profile-panel">
                    <header class="profile-panel-header">
                        <h2 class="profile-panel-title">Informacion del perfil</h2>
                        <p class="profile-panel-copy">Actualiza tu foto de perfil. Nombre y correo son datos administrados por el sistema.</p>
                    </header>

                    <div class="profile-panel-body">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-form">
                            @csrf
                            @method('patch')

                            <div x-data="{ fileName: 'Ningun archivo seleccionado' }" class="profile-photo-box">
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="profile-avatar">

                                <div>
                                    <label for="profile_photo" class="profile-label">Foto de perfil</label>
                                    <div class="profile-file-row">
                                        <label for="profile_photo" class="profile-file-button">Seleccionar archivo</label>
                                        <span x-text="fileName" class="profile-file-name"></span>
                                    </div>
                                    <input
                                        id="profile_photo"
                                        name="profile_photo"
                                        type="file"
                                        accept="image/png,image/jpeg,image/webp"
                                        class="sr-only"
                                        x-on:change="fileName = $event.target.files.length ? $event.target.files[0].name : 'Ningun archivo seleccionado'"
                                    >
                                    <div class="profile-help">JPG, PNG o WEBP. Maximo 2 MB.</div>
                                    <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                                </div>
                            </div>

                            <div>
                                <label for="name" class="profile-label">Nombre</label>
                                <input id="name" value="{{ $user->name }}" readonly class="profile-input">
                            </div>

                            <div>
                                <label for="email" class="profile-label">Correo electronico</label>
                                <input id="email" value="{{ $user->email }}" readonly class="profile-input">
                            </div>

                            <div class="profile-actions">
                                <span class="profile-help">Solo se guardara la foto seleccionada.</span>
                                <button type="submit" class="profile-primary-button">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </section>

                <section class="profile-panel">
                    <header class="profile-panel-header">
                        <h2 class="profile-panel-title">Actualizar contrasena</h2>
                        <p class="profile-panel-copy">Usa una contrasena larga y segura para proteger la cuenta.</p>
                    </header>

                    <div class="profile-panel-body">
                        <form method="POST" action="{{ route('password.update') }}" class="profile-form">
                            @csrf
                            @method('put')

                            <div x-data="{ show: false }" class="profile-password-wrap">
                                <label for="current_password" class="profile-label">Contrasena actual</label>
                                <input id="current_password" name="current_password" :type="show ? 'text' : 'password'" autocomplete="current-password" class="profile-input profile-password-input" required>
                                <button type="button" x-on:click="show = !show" class="profile-eye-button" aria-label="Mostrar u ocultar contrasena">
                                    <svg x-show="!show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z" /><circle cx="12" cy="12" r="3" /></svg>
                                    <svg x-show="show" x-cloak viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l18 18" /><path d="M10.6 10.6A2 2 0 0 0 12 14a2 2 0 0 0 1.4-.6" /><path d="M9.9 5.2A9.3 9.3 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-3.1 4.1" /><path d="M6.6 6.7A17.7 17.7 0 0 0 2 12s3.5 7 10 7a9.7 9.7 0 0 0 4.1-.9" /></svg>
                                </button>
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div x-data="{ show: false }" class="profile-password-wrap">
                                <label for="password" class="profile-label">Nueva contrasena</label>
                                <input id="password" name="password" :type="show ? 'text' : 'password'" autocomplete="new-password" class="profile-input profile-password-input" required>
                                <button type="button" x-on:click="show = !show" class="profile-eye-button" aria-label="Mostrar u ocultar contrasena">
                                    <svg x-show="!show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z" /><circle cx="12" cy="12" r="3" /></svg>
                                    <svg x-show="show" x-cloak viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l18 18" /><path d="M10.6 10.6A2 2 0 0 0 12 14a2 2 0 0 0 1.4-.6" /><path d="M9.9 5.2A9.3 9.3 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-3.1 4.1" /><path d="M6.6 6.7A17.7 17.7 0 0 0 2 12s3.5 7 10 7a9.7 9.7 0 0 0 4.1-.9" /></svg>
                                </button>
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div x-data="{ show: false }" class="profile-password-wrap">
                                <label for="password_confirmation" class="profile-label">Confirmar contrasena</label>
                                <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" autocomplete="new-password" class="profile-input profile-password-input" required>
                                <button type="button" x-on:click="show = !show" class="profile-eye-button" aria-label="Mostrar u ocultar contrasena">
                                    <svg x-show="!show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z" /><circle cx="12" cy="12" r="3" /></svg>
                                    <svg x-show="show" x-cloak viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l18 18" /><path d="M10.6 10.6A2 2 0 0 0 12 14a2 2 0 0 0 1.4-.6" /><path d="M9.9 5.2A9.3 9.3 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-3.1 4.1" /><path d="M6.6 6.7A17.7 17.7 0 0 0 2 12s3.5 7 10 7a9.7 9.7 0 0 0 4.1-.9" /></svg>
                                </button>
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="profile-actions">
                                <span class="profile-help">La contrasena se actualizara al confirmar los datos.</span>
                                <button type="submit" class="profile-primary-button">Actualizar contrasena</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
