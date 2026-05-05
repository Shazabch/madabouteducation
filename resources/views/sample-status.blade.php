'article.status' => 'nullable',

$this->article->status = $this->article->status ? true : false;

<div class="form-group col-md-12">
    <label class="text-capitalize">Status</label>
    <select wire:model.defer="article.status" type="text" class="form-control @error('article.status') border border-danger @enderror form-select">
        <option value="1">Active</option>
        <option value="0">Archived</option>
    </select>
    @error('article.status')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>




<th>Status</th>
<td>
    @if($article->status)
    <span class="badge badge-success">active</span>
    @else
    <span class="badge badge-danger">archived</span>
    @endif
</td>
