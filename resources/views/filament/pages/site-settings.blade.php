<x-filament-panels::page>

    <form wire:submit="save" class="space-y-6">

        {{ $this->form }}

        <div class="flex items-center justify-between pt-2">
            <p class="text-sm text-gray-400">
                Изменения применяются сразу после сохранения
            </p>
            <x-filament::button
                type="submit"
                size="lg"
                icon="heroicon-o-check"
                wire:loading.attr="disabled"
                wire:target="save"
            >
                <span wire:loading.remove wire:target="save">Сохранить настройки</span>
                <span wire:loading wire:target="save">Сохраняю…</span>
            </x-filament::button>
        </div>

    </form>

    <x-filament-actions::modals />

</x-filament-panels::page>
