@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Semestre</label>
        <select name="semestre_id" class="form-select @error('semestre_id') is-invalid @enderror" required>
            <option value="">Seleccione...</option>
            @foreach ($semestres as $semestre)
                <option value="{{ $semestre->id }}" @selected(old('semestre_id', $carpeta->semestre_id) == $semestre->id)>
                    {{ $semestre->nombre }} {{ $semestre->anio }}
                </option>
            @endforeach
        </select>
        @error('semestre_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Carpeta padre</label>
        <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
            <option value="">Sin carpeta padre</option>
            @foreach ($carpetasPadre as $padre)
                <option value="{{ $padre->id }}" @selected(old('parent_id', $carpeta->parent_id) == $padre->id)>
                    {{ $padre->nombre }} - {{ $padre->semestre->nombre }} {{ $padre->semestre->anio }}
                </option>
            @endforeach
        </select>
        @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-12">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $carpeta->nombre) }}" required>
        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-12">
        <label class="form-label">Descripcion</label>
        <textarea name="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $carpeta->descripcion) }}</textarea>
        @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('carpetas.index') }}">Cancelar</a>
</div>
