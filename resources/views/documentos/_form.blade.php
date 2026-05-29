@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Semestre</label>
        <select name="semestre_id" class="form-select @error('semestre_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach ($semestres as $semestre)
                <option value="{{ $semestre->id }}" @selected(old('semestre_id', $documento->semestre_id) == $semestre->id)>
                    {{ $semestre->nombre }} {{ $semestre->anio }}
                </option>
            @endforeach
        </select>
        @error('semestre_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Carpeta</label>
        <select name="carpeta_id" class="form-select @error('carpeta_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach ($carpetas as $carpeta)
                <option value="{{ $carpeta->id }}" @selected(old('carpeta_id', $documento->carpeta_id) == $carpeta->id)>
                    {{ $carpeta->nombre }} - {{ $carpeta->semestre->nombre }} {{ $carpeta->semestre->anio }}
                </option>
            @endforeach
        </select>
        @error('carpeta_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-12">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $documento->nombre) }}" required>
        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-12">
        <label class="form-label">Descripcion</label>
        <textarea name="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $documento->descripcion) }}</textarea>
        @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-12">
        <label class="form-label">Archivo</label>
        <input type="file" name="archivo" class="form-control @error('archivo') is-invalid @enderror" {{ $documento->exists ? '' : 'required' }}>
        <div class="form-text">PDF, Office, imagenes o comprimidos. Maximo 20 MB.</div>
        @error('archivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('documentos.index') }}">Cancelar</a>
</div>
