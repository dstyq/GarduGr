<form method="POST" action="{{ route('tasks.store') }}">
    @csrf

    <div class="card-body">
        <div class="form-group">
            <label for="material">Previous Material</label>
            <input readonly type="text" class="form-control @error('material') is-invalid @enderror" id="material" name="material" value="{{ $material->material_name }}">
        </div>

        <div class="form-group">
            <label>New Material</label>
            <select class="form-control select2" style="width: 100%;" name="new_material" id="new_material">
                @foreach ($materials as $data)
                    @if ($data->id != $material->material_id)
                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endif
                @endforeach
            </select>
          </div>

        <div class="form-group">
            <label for="">Remarks</label>
            <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" id="remarks" cols="30" rows="3" placeholder="Enter remarks">{{old('remarks')}}</textarea>
        </div>
    </div>
</form>