@props(['dataArray','placeholder' => 'Select', 'id', 'multiple' => false,'defer' => true])
<div
    wire:ignore
    x-data ="{count:0,
                initializeSelect2() {
                    console.log('Running initializeSelect2');
                    const select = $refs.{{ $id }}
                    if(this.count>0){
                        $(select).select2().empty();
                    }
                    $(select).select2({
                        placeholder: '{{ $placeholder }}',
                        allowClear: true,
                        data: @this.get('{{ $dataArray }}'),
                    });

                    $(select).val(@this.get( '{{ $attributes->whereStartsWith('wire:model')->first() }}') ).trigger('change');

                    if(this.count<1){
                        console.log('Adding event listeners to select 2');
                        $(select).on('select2:select', function (e) {
                            var id = e.params.data.id;
                           @this.set('{{ $attributes->whereStartsWith('wire:model')->first() }}',id,{{ $defer }});
                       });
                       $(select).on('select2:clear', function (e) {
                            @this.set('{{ $attributes->whereStartsWith('wire:model')->first() }}',null,{{ $defer }});
                        });
                        this.count=this.count+1;
                    }

                }
            }"
    x-init="
    initializeSelect2()
    "
    x-on:re-init-select-2-component.window="initializeSelect2()"
>
    <select {{ $attributes }} id="{{ $id }}" x-ref="{{ $id }}" @if($multiple) multiple="multiple" @endif data-placeholder="{{ $placeholder }}">
    </select>
</div>
