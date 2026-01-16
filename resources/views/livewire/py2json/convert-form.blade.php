<?php

use App\Services\ConverterService;
use Livewire\Component;

new class extends Component {
    public string $pydict = '';
    public string $output = '';

    public function convert(ConverterService $converterService): void
    {
        $this->output = $converterService->convertPythonToJson($this->pydict);
        session()->flash('error', 'Failed to create message. Please try again.' . $this->output);
    }
}
?>

<div>
    @if (session()->has('error'))
        <flux:callout class="mb-4" variant="danger" icon="x-circle" :heading="session('error')"/>
    @endif
    <form wire:submit.prevent="convert">

        <!-- Content Field -->
        <flux:field class="mb-4">
            <flux:label>Your Python dictionary</flux:label>
            <flux:textarea
                wire:model="pydict"
                class="font-mono"
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

    @if($output)
        <div class="mt-6">
            <flux:label>Converted JSON</flux:label>
            <flux:textarea
                readonly
                rows="10"
            >{{ $output }}</flux:textarea>
        </div>
    @endif
</div>
