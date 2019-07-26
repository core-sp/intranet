<div class="card">
    <div class="card-header">
        <h3 class="mb-0">{{ $title }}</h3>
    </div>
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
                />
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="col">
                <label for="is_admin">É admin?</label>
                <select name="is_admin" id="is_admin" class="form-control">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>
            <div class="col">
                <label for="profile">Selecione o perfil</label>
                <select name="profile_id" id="profile" class="form-control">
                    @foreach($profiles as $profile)
                        <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="is_coordinator">É coordenador da área?</label>
                <select name="is_coordinator" id="is_coordinator" class="form-control">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>
        </div>
        <div class="form-row mt-3">
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
    </div>
    <div class="card-footer text-right">
        <a href="/users" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</div>