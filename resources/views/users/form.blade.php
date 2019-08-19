@csrf
<div class="card">
    <h5 class="card-header">
        {{ $title }}
    </h5>
    <div class="card-body">
        <div class="form-row">
            <div class="col">
                <label for="name">Nome</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    placeholder="Nome"
                    value="{{ $user->name }}"
                />
            </div>
            <div class="col">
                <label for="username">Nome de usuário</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control"
                    placeholder="Nome de usuário"
                    value="{{ $user->username }}"
                />
            </div>
            <div class="col">
                <label for="email">Email</label>
                <input
                    type="text"
                    name="email"
                    id="email"
                    class="form-control"
                    placeholder="Email"
                    value="{{ $user->email }}"
                />
            </div>
        </div>
        @if(auth()->user()->isAdmin())
            <div class="form-row mt-3 mb-3">
                <div class="col">
                    <label for="is_admin">É admin?</label>
                    <select name="is_admin" id="is_admin" class="form-control">
                        <option value="0" {{ $user->is_admin === false ? 'selected' : '' }}>Não</option>
                        <option value="1" {{ $user->is_admin === true ? 'selected' : '' }}>Sim</option>
                    </select>
                </div>
                <div class="col">
                    <label for="profile">Selecione o perfil</label>
                    <select name="profile_id" id="profile" class="form-control">
                        @foreach($profiles as $profile)
                            <option value="{{ $profile->id }}" {{ $user->profile_id === $profile->id ? 'selected' : '' }}>{{ $profile->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="is_coordinator">É coordenador da área?</label>
                    <select name="is_coordinator" id="is_coordinator" class="form-control">
                        <option value="0" {{ $user->is_admin === false ? 'selected' : '' }}>Não</option>
                        <option value="1" {{ $user->is_admin === true ? 'selected' : '' }}>Sim</option>
                    </select>
                </div>
            </div>
        @endif
        @if($password)
            <div class="form-row">
                <div class="col">
                    <label for="password">Senha</label>
                    <input
                        id="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        required
                        autocomplete="new-password"
                    />
                </div>
                <div class="col">
                    <label for="password-confirm">Confirme a senha</label>
                    <input
                        id="password-confirm"
                        type="password"
                        class="form-control"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                </div>
            </div>
        @endif
    </div>
    <div class="card-footer text-right">
        <a href="/users" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary any-submit-button"><i class="spinner fa fa-spinner fa-spin"></i> Salvar</button>
    </div>
</div>