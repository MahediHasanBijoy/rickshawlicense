@php
    use Rakibhstu\Banglanumber\NumberToBangla;
    $numto = new NumberToBangla();
@endphp
<x-filament-panels::page>
    {{-- Page content --}}
    {{ $this->form }}
     
     <div style="width:100%;display:flex;justify-content:flex-end;margin-top: -25px;">
        <span style="font-weight:bold;">
            মোট ফেরত: {{ $numto->bnCommaLakh(($this->getTableQuery()->sum('yearly_fee_refund'))
            + $this->getTableQuery()->sum('security_fee_refund')) }} /=
        </span>
     </div>
     <div style="width:100%;display:flex;justify-content:flex-end;margin-top: -25px;">
        <span style="font-weight:bold;">
            মোট আয়: {{ $numto->bnCommaLakh(($this->getTableQuery()->sum('total_paid'))) }}/=  
        </span>  
    </div>
     {{ $this->table }}
</x-filament-panels::page>
