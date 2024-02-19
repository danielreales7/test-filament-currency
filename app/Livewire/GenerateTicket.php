<?php

namespace App\Livewire;

use App\Enums\DrawerActionType;
use App\Models\CashDeskClosing;
use App\Models\Drawer;
use App\Models\Subcategory;
use App\Models\Tax;
use App\Models\Tip;
use Carbon\Carbon;
use Closure;
use App\Enums\PaymentType;
use App\Forms\Components\CheckElement;
use App\Helpers\Helper;
use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Sale;
use App\Models\SaleItem;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Actions\Action;

class GenerateTicket extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $dataAddForm = [];
    public bool $showBannerDanger = true;

    //protected $listeners = ['testEvent' => '$refresh'];

    protected function getForms(): array
    {
        return [
            'addToTicketForm',
        ];
    }

    public function mount(): void
    {
        $this->addToTicketForm->fill();
    }

    #[On('testEvent')]
    public function checkLastClosing(): void
    {
        dd('dentro');
        $this->showBannerDanger = false;
    }

    public function addToTicketForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Añadir Elemento')
                    ->schema([
                        TextInput::make('test')->hidden($this->showBannerDanger)
                    ]),
            ])->columns(12);
    }

    public function render(): View
    {
        return view('livewire.generate-ticket');
    }
}
