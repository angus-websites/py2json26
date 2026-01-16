<?php

use App\Exceptions\InvalidDictException;
use App\Exceptions\JsonConversionException;
use App\Services\ConverterService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

new class extends Component {
    public string $pydict = '';
    public string $output = '';

    public function convert(ConverterService $converterService): void
    {
        try {
            $this->output = $converterService->convertPythonToJson($this->pydict);
        } catch (InvalidDictException) {
            $this->reset('output');
            session()->flash('error', 'The provided input is not a valid Python dictionary.');
            return;
        } catch (JsonConversionException) {
            $this->reset('output');
            session()->flash('error', 'This Python dictionary cannot be converted to JSON.');
            session()->flash('details', 'Some data types in Python dictionaries are not valid in JSON e.g tuples as keys or sets as values.');
            return;
        } catch (\Exception $e) {
            $this->reset('output');
            Log::error('Unexpected error during conversion: ' . $e->getMessage());
            session()->flash('error', 'An unexpected error occurred');
            return;
        }
    }
}
?>

<div>
    @if (session()->has('error'))
        <flux:callout class="mb-4" variant="danger" icon="x-circle" :heading="session('error')">
            @if (session()->has('details'))
                <flux:callout.text>
                    {{ session('details') }}
                </flux:callout.text>
            @endif
        </flux:callout>
    @endif
    <div class="space-y-8">
        <form wire:submit.prevent="convert" class="space-y-8">

            <!-- Content Field -->
            <flux:field>
                <flux:label>Your Python dictionary</flux:label>
                <flux:textarea
                    wire:model="pydict"
                    required
                    class="font-mono"
                    placeholder="{'key': 'value', 'number': 42}"
                    rows="6"
                />
                <flux:error name="pydict"/>
            </flux:field>

            <!-- Submit Button -->
            <flux:button variant="primary" type="submit" class="w-full justify-center">
                Convert
            </flux:button>
        </form>

        @if($output)
            <div class="space-y-8 flex justify-center flex-col">
                <flux:field>
                    <flux:label>Converted JSON</flux:label>
                    <flux:textarea
                        readonly
                        rows="6"
                    >{{ $output }}</flux:textarea>
                </flux:field>

                <!-- Copy Button -->
                <flux:button
                    x-data="{ copied: false }"
                    x-on:click="$clipboard($wire.entangle('output'));copied = true; setTimeout(() => copied = false, 2000);"
                >
                    <flux:icon.clipboard
                        variant="outline"
                        x-show="!copied"
                    />
                    <flux:icon.clipboard-document-check
                        variant="outline"
                        x-cloak
                        x-show="copied"
                    />
                    <span x-text="copied ? 'Copied' : 'Copy'"></span>
                </flux:button>
            </div>
        @endif
    </div>
</div>
