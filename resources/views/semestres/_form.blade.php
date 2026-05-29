@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $semestre->nombre) }}" required>
        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Anio</label>
        <input type="number" name="anio" class="form-control @error('anio') is-invalid @enderror" value="{{ old('anio', $semestre->anio) }}" required>
        @error('anio') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <div class="form-check form-switch">
            <input type="hidden" name="activo" value="0">
            <input class="form-check-input" type="checkbox" name="activo" value="1" @checked(old('activo', $semestre->activo ?? true))>
            <label class="form-check-label">Activo</label>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label">Fecha inicio</label>
        <input type="date" name="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror" value="{{ old('fecha_inicio', optional($semestre->fecha_inicio)->format('Y-m-d')) }}">
        @error('fecha_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Fecha fin</label>
        <input type="date" name="fecha_fin" class="form-control @error('fecha_fin') is-invalid @enderror" value="{{ old('fecha_fin', optional($semestre->fecha_fin)->format('Y-m-d')) }}">
        @error('fecha_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-outline-secondary" href="{{ route('semestres.index') }}">Cancelar</a>
</div>
