<div class="card">
    <div class="card-header">
        <h3 class="mb-0">{{ $title }}</h3>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="col">
                <label for="title">Título</label>
                <input 
                    type="text"
                    id="title"
                    name="title"
                    class="form-control"
                    placeholder="Título"
                />
            </div>
            <div class="col">
                <label for="profile">Selecione a área de atendimento</label>
                <select name="profile_id" id="profile" class="form-control">
                    @foreach($profiles as $profile)
                        <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="priority">Prioridade</label>
                <select name="priority" id="priority" class="form-control">
                    @foreach(ticketsPriorities() as $priority)
                        <option value="{{ $priority }}">{{ $priority }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="col">
                <label for="content">Conteúdo</label>
                <textarea
                    name="content"
                    id="content"
                    rows="10"
                    placeholder="Conteúdo do chamado"
                    class="form-control"
                ></textarea>
            </div>
        </div>  
    </div>
    <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary any-submit-button"><i class="spinner fa fa-spinner fa-spin"></i> Salvar</button>
    </div>
</div>