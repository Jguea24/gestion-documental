@csrf

@php
    $selectedRoles = old('roles', $user->roles->pluck('name')->all());
    $selectedPermissions = old('permissions', $user->permissions->pluck('name')->all());
    $selectedFolderPermissions = collect(old('folder_permissions', $user->permittedFolders->pluck('id')->all()))
        ->map(fn ($id) => (int) $id)
        ->all();
    $autoGenerateEmail = ! $user->exists;
    $roleDescriptions = [
        'Administrador' => 'Acceso completo a usuarios, documentos y configuracion.',
        'Docente' => 'Gestiona carpetas y documentos propios.',
        'Estudiante' => 'Consulta, previsualiza y descarga documentos.',
    ];
@endphp

<style>
    .user-form-shell {
        overflow: hidden;
        border: 1px solid #cbd8e8;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 14px 30px rgba(15, 39, 71, 0.08);
    }

    .user-form-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        border-top: 5px solid #2563eb;
        border-bottom: 1px solid #d9e2ef;
        background: linear-gradient(135deg, #eff6ff 0%, #ffffff 65%);
        padding: 20px 24px;
    }

    .user-form-kicker {
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .user-form-title {
        margin-top: 4px;
        color: #0f172a;
        font-size: 22px;
        font-weight: 800;
        line-height: 1.2;
    }

    .user-form-subtitle {
        margin-top: 5px;
        color: #55708f;
        font-size: 13px;
        font-weight: 600;
    }

    .user-role-pills {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 8px;
    }

    .user-role-pill {
        border-radius: 999px;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 7px 11px;
        font-size: 12px;
        font-weight: 800;
    }

    .user-role-pill-empty {
        background: #e2e8f0;
        color: #64748b;
    }

    .user-form-grid {
        display: grid;
        grid-template-columns: 0.82fr 1.18fr;
        min-height: 610px;
    }

    .user-form-panel {
        padding: 24px;
    }

    .user-form-panel-left {
        border-right: 1px solid #d9e2ef;
        background: #f8fbff;
    }

    .user-section-head {
        margin-bottom: 18px;
    }

    .user-section-title {
        color: #0f172a;
        font-size: 17px;
        font-weight: 800;
    }

    .user-section-copy {
        margin-top: 4px;
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    .user-field-stack {
        display: grid;
        gap: 18px;
    }

    .user-field-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .user-label {
        display: block;
        margin-bottom: 7px;
        color: #1e293b;
        font-size: 13px;
        font-weight: 800;
    }

    .user-input {
        display: block;
        width: 100%;
        height: 44px;
        border: 1px solid #b8c7da;
        border-radius: 10px;
        background: #ffffff;
        color: #0f172a;
        padding: 0 13px;
        font-size: 14px;
        outline: none;
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .user-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .14);
    }

    .user-help {
        margin-top: 6px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.45;
    }

    .user-roles {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .user-role-card {
        position: relative;
        display: grid;
        grid-template-columns: auto minmax(0, 1fr);
        gap: 11px;
        min-height: 108px;
        border: 1px solid #cbd8e8;
        border-radius: 12px;
        background: #ffffff;
        padding: 14px;
        cursor: pointer;
        transition: border-color .15s ease, background .15s ease, transform .15s ease;
    }

    .user-role-card:hover {
        border-color: #60a5fa;
        transform: translateY(-1px);
    }

    .user-role-card-selected {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .user-checkbox {
        width: 16px;
        height: 16px;
        margin-top: 3px;
        accent-color: #2563eb;
    }

    .user-role-name {
        color: #0f172a;
        font-size: 14px;
        font-weight: 800;
    }

    .user-role-desc {
        margin-top: 5px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.45;
    }

    .user-block-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .user-block-title {
        color: #475569;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .user-count {
        border-radius: 999px;
        background: #e0f2fe;
        color: #0369a1;
        padding: 4px 9px;
        font-size: 12px;
        font-weight: 800;
    }

    .user-permissions-box {
        max-height: 450px;
        overflow-y: auto;
        border: 1px solid #d9e2ef;
        border-radius: 12px;
        background: #f8fbff;
        padding: 12px;
    }

    .user-folder-access-box {
        max-height: 240px;
        overflow-y: auto;
        border: 1px solid #d9e2ef;
        border-radius: 12px;
        background: #f8fbff;
        padding: 12px;
    }

    .user-folder-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .user-folder-item {
        display: flex;
        align-items: center;
        gap: 9px;
        min-height: 38px;
        border: 1px solid #d9e2ef;
        border-radius: 10px;
        background: #ffffff;
        color: #334155;
        padding: 8px 10px;
        font-size: 13px;
        font-weight: 700;
    }

    .user-folder-item:hover {
        border-color: #60a5fa;
        background: #eff6ff;
    }

    .user-permission-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .user-permission-group {
        border: 1px solid #d9e2ef;
        border-radius: 12px;
        background: #ffffff;
        padding: 14px;
    }

    .user-permission-group-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
    }

    .user-permission-group-title {
        color: #0f172a;
        font-size: 14px;
        font-weight: 800;
    }

    .user-permission-total {
        border-radius: 999px;
        background: #f1f5f9;
        color: #64748b;
        padding: 3px 8px;
        font-size: 11px;
        font-weight: 800;
    }

    .user-permission-list {
        display: grid;
        gap: 6px;
    }

    .user-permission-item {
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 31px;
        border-radius: 8px;
        color: #475569;
        padding: 5px 7px;
        font-size: 13px;
        font-weight: 600;
    }

    .user-permission-item:hover {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .user-permission-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .user-form-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-top: 1px solid #d9e2ef;
        background: #f8fbff;
        padding: 16px 24px;
    }

    .user-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        border-radius: 10px;
        padding: 0 18px;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
    }

    .user-btn-secondary {
        border: 1px solid #b8c7da;
        background: #ffffff;
        color: #334155;
    }

    .user-btn-secondary:hover {
        background: #f1f5f9;
    }

    .user-btn-primary {
        border: 1px solid #1d4ed8;
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 8px 16px rgba(37, 99, 235, .2);
    }

    .user-btn-primary:hover {
        background: #1d4ed8;
    }

    @media (max-width: 1180px) {
        .user-form-grid,
        .user-permission-grid {
            grid-template-columns: 1fr;
        }

        .user-form-panel-left {
            border-right: 0;
            border-bottom: 1px solid #d9e2ef;
        }
    }

    @media (max-width: 720px) {
        .user-form-top,
        .user-form-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .user-role-pills {
            justify-content: flex-start;
        }

        .user-field-grid,
        .user-roles,
        .user-folder-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="user-form-shell">
    <div class="user-form-top">
        <div>
            <div class="user-form-kicker">Cuenta de acceso</div>
            <div class="user-form-title">{{ $user->exists ? $user->name : 'Nuevo usuario' }}</div>
            <div class="user-form-subtitle">Gestiona datos, roles y permisos directos desde un solo panel.</div>
        </div>

        <div class="user-role-pills">
            @forelse ($selectedRoles as $roleName)
                <span class="user-role-pill">{{ $roleName }}</span>
            @empty
                <span class="user-role-pill user-role-pill-empty">Sin rol</span>
            @endforelse
        </div>
    </div>

    <div class="user-form-grid">
        <section class="user-form-panel user-form-panel-left">
            <div class="user-section-head">
                <div class="user-section-title">Datos del usuario</div>
                <div class="user-section-copy">Define credenciales claras y manten actualizada la informacion principal.</div>
            </div>

            <div class="user-field-stack">
                <div>
                    <label for="name" class="user-label">Nombre</label>
                    <input id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" class="user-input">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <label for="email" class="user-label">Correo</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" class="user-input">
                    @if ($autoGenerateEmail)
                        <div class="user-help">Se genera automaticamente desde el nombre con el formato nombre.wini@gmail.com.</div>
                    @endif
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="user-field-grid">
                    <div>
                        <label for="password" class="user-label">Contrasena</label>
                        <input id="password" type="password" name="password" {{ $user->exists ? '' : 'required' }} autocomplete="new-password" placeholder="{{ $user->exists ? 'Mantener actual' : '' }}" class="user-input">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="user-label">Confirmar</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" {{ $user->exists ? '' : 'required' }} autocomplete="new-password" class="user-input">
                    </div>
                </div>
            </div>
        </section>

        <section class="user-form-panel">
            <div class="user-section-head">
                <div class="user-section-title">Roles y permisos</div>
                <div class="user-section-copy">Usa roles como acceso base y permisos directos solo para excepciones puntuales.</div>
            </div>

            <div class="user-block-header">
                <div class="user-block-title">Roles</div>
                <div class="user-count">{{ count($selectedRoles) }} seleccionado(s)</div>
            </div>

            <div class="user-roles">
                @foreach ($roles as $role)
                    <label class="user-role-card {{ in_array($role->name, $selectedRoles, true) ? 'user-role-card-selected' : '' }}">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" @checked(in_array($role->name, $selectedRoles, true)) class="user-checkbox">
                        <span>
                            <span class="user-role-name">{{ $role->name }}</span>
                            <span class="user-role-desc">{{ $roleDescriptions[$role->name] ?? 'Permisos definidos por el administrador.' }}</span>
                        </span>
                    </label>
                @endforeach
            </div>
            <x-input-error :messages="$errors->get('roles')" class="mt-2" />

            <div style="height: 22px"></div>

            <div class="user-block-header">
                <div class="user-block-title">Carpetas permitidas</div>
                <div class="user-count">{{ count($selectedFolderPermissions) }} asignada(s)</div>
            </div>

            <div class="user-section-copy" style="margin-bottom: 10px">
                Para estudiantes, solo estas carpetas y sus subcarpetas apareceran en el explorador.
            </div>

            <div class="user-folder-access-box">
                <div class="user-folder-grid">
                    @forelse ($folders as $folder)
                        <label class="user-folder-item">
                            <input type="checkbox" name="folder_permissions[]" value="{{ $folder->id }}" @checked(in_array($folder->id, $selectedFolderPermissions, true)) class="user-checkbox">
                            <span class="user-permission-text">{{ $folder->name }}</span>
                        </label>
                    @empty
                        <p style="color:#64748b;font-size:13px;font-weight:700">No hay carpetas creadas.</p>
                    @endforelse
                </div>
            </div>
            <x-input-error :messages="$errors->get('folder_permissions')" class="mt-2" />

            <div style="height: 22px"></div>

            <div class="user-block-header">
                <div class="user-block-title">Permisos directos</div>
                <div class="user-count">{{ count($selectedPermissions) }} seleccionado(s)</div>
            </div>

            <div class="user-permissions-box">
                <div class="user-permission-grid">
                    @foreach ($permissionsByGroup as $group => $permissions)
                        <div class="user-permission-group">
                            <div class="user-permission-group-head">
                                <div class="user-permission-group-title">{{ ucfirst($group) }}</div>
                                <div class="user-permission-total">{{ $permissions->count() }}</div>
                            </div>

                            <div class="user-permission-list">
                                @foreach ($permissions as $permission)
                                    <label class="user-permission-item">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" @checked(in_array($permission->name, $selectedPermissions, true)) class="user-checkbox">
                                        <span class="user-permission-text">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
        </section>
    </div>

    <div class="user-form-actions">
        <a href="{{ route('users.index') }}" class="user-btn user-btn-secondary">Cancelar</a>
        <button class="user-btn user-btn-primary">Guardar usuario</button>
    </div>
</div>

@if ($autoGenerateEmail)
    <script>
        (() => {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');

            if (!nameInput || !emailInput) return;

            let lastGeneratedEmail = emailInput.value || '';

            function userSlug(value) {
                return value
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '.')
                    .replace(/^\.+|\.+$/g, '');
            }

            function generatedEmail() {
                const slug = userSlug(nameInput.value);
                return slug ? `${slug}.wini@gmail.com` : '';
            }

            function syncEmail() {
                const nextEmail = generatedEmail();
                const canReplace = emailInput.value === '' || emailInput.value === lastGeneratedEmail;

                if (canReplace) {
                    emailInput.value = nextEmail;
                    lastGeneratedEmail = nextEmail;
                }
            }

            nameInput.addEventListener('input', syncEmail);
            emailInput.addEventListener('input', () => {
                if (emailInput.value !== lastGeneratedEmail) {
                    lastGeneratedEmail = '';
                }
            });

            syncEmail();
        })();
    </script>
@endif
