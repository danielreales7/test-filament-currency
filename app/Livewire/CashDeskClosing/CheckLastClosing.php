<?php

namespace App\Livewire\CashDeskClosing;

use App\Livewire\GenerateTicket;
use Closure;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class CheckLastClosing extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public bool $isOpen = true;
    public ?Carbon $dateClosing = null;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('date')
                            ->format('d/m/Y')
                            ->default(Carbon::now()->format('d/m/Y'))
                            ->disabled()
                            ->dehydrated()
                            ->label('Día de Cierre')
                            ->columnSpan(6)->columns(1)
                    ])->columns(12)
            ])
            ->statePath('data');
    }

    public function render()
    {
        return view('livewire.cash-desk-closing.check-last-closing');
    }

    public function checkLastClosing(): void
    {
        if(Filament::auth()->id()) {
            $lastSaleDate = Carbon::parse('2024-02-12');
            $today = Carbon::today();

            if ($lastSaleDate->toDateString() !== $today->toDateString()) {
                $this->dateClosing = $lastSaleDate;
                $this->form->fill();
                $this->dispatch('open-modal', id: 'check-last-closing');
            }
        }
    }

    public function create(): void
    {
        try {
            $this->dispatch('close-modal', id: 'check-last-closing');

            Notification::make()
                ->success()
                ->title('Caja Cerrada')
                ->body('La caja ha sido cerrada correctamente.')
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Error')
                ->body('Ocurrió un error al cerrar la caja.')
                ->send();
        }
    }
}
