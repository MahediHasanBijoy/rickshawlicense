@php
    use Rakibhstu\Banglanumber\NumberToBangla;
    $numto = new NumberToBangla();
@endphp
<x-filament-panels::page>
    {{-- Page content --}}
    {{ $this->form }}
    <div style="width:100%;display:flex;justify-content:flex-end;margin-top: -25px;">
        <span style="font-weight:bold;">
            মোট আবেদন: {{ $numto->bnCommaLakh(($this->getTableQuery()->get()->sum('total_count'))) }} 
        </span>
    </div>
    {{ $this->table }}
</x-filament-panels::page>
