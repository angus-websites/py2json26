<?php

use Livewire\Component;

new class extends Component
{
    public string $pydict = '';

    public function convert(): void
    {
        // Form submission logic here
    }
}
?>

<div>
    <form wire:submit.prevent="convert">

        <!-- Content Field -->
        <flux:field class="mb-4">
            <flux:label>Your Python dictionary</flux:label>
            <flux:textarea
                wire:model="pydict"
                placeholder="{'key': 'value', 'number': 42}"
                rows="10"
            />
            <flux:error name="pydict"/>
        </flux:field>

        <!-- Submit Button -->
        <flux:button variant="primary" type="submit" class="mt-4 w-full justify-center">
            Convert
        </flux:button>
    </form>
</div>
