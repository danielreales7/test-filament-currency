<x-filament::modal
    id="check-last-closing"
    wire:init="checkLastClosing"
    icon="heroicon-o-exclamation-triangle"
    icon-color="danger"
    width="max-w-4xl">
    <form wire:submit.prevent="create">
        <x-slot name="heading">
            Cierre de caja no realizado
        </x-slot>
        <x-slot name="description">
            Puedes realizar el cierre directamente desde aquí
        </x-slot>

        {{ $this->form }}

        <x-slot name="footer">
            <div class="flex justify-end items-center">
                <x-filament::button class="fi-btn-label" color="danger" wire:click="create">Cerrar Caja</x-filament::button>
            </div>
        </x-slot>
    </form>
</x-filament::modal>
