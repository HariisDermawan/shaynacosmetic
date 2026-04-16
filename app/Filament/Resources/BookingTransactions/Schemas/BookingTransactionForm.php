<?php

namespace App\Filament\Resources\BookingTransactions\Schemas;

use App\Models\Cosmetic;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class BookingTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Wizard::make([
                    Step::make('product and price')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('add your product items')
                        ->schema([

                            Repeater::make('transactionDetails')
                                ->relationship('transactionDetails')
                                ->live()
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    self::updateTotals($get, $set);
                                })
                                ->schema([
                                    Grid::make(2)
                                        ->schema([

                                            Select::make('cosmetic_id')
                                                ->relationship('cosmetic', 'name')
                                                ->searchable()
                                                ->preload()
                                                ->required()
                                                ->label('Select Product')
                                                ->live()
                                                ->afterStateUpdated(function ($state, callable $set) {
                                                    $cosmetic = Cosmetic::find($state);
                                                    $set('price', $cosmetic?->price ?? 0);
                                                }),

                                            TextInput::make('price')
                                                ->required()
                                                ->numeric()
                                                ->readOnly()
                                                ->label('Price'),

                                            TextInput::make('quantity')
                                                ->integer()
                                                ->default(1)
                                                ->required()
                                                ->live(debounce: 300),

                                        ])
                                ])
                                ->minItems(1)
                                ->columnSpanFull()
                                ->label('Choose Products'),

                            Grid::make(4)
                                ->schema([

                                    TextInput::make('total_quantity')
                                        ->integer()
                                        ->label('Total Quantity')
                                        ->readOnly(),

                                    TextInput::make('sub_total_amount')
                                        ->numeric()
                                        ->readOnly(),

                                    TextInput::make('total_amount')
                                        ->numeric()
                                        ->readOnly(),
                                    TextInput::make('total_tax_amount')
                                        ->numeric()
                                        ->label('Total Tax (11%)')
                                        ->readOnly(),



                                ])

                        ]),

                    Step::make('Customer Information')
                        ->schema([
                            Grid::make(2)->schema([
                                TextInput::make('name')->required(),
                                TextInput::make('phone')->required(),
                                TextInput::make('email')->required(),
                            ])
                        ]),

                    Step::make('Delivery Information')
                        ->schema([
                            Grid::make(2)->schema([
                                TextInput::make('city')->required(),
                                TextInput::make('post_code')->required(),
                                Textarea::make('address')->required(),
                            ]),
                        ]),

                    Step::make('Payment Information')
                        ->schema([
                            Grid::make(3)->schema([
                                TextInput::make('booking_trx_id')->required(),

                                ToggleButtons::make('is_paid')
                                    ->boolean()
                                    ->grouped()
                                    ->required(),

                                FileUpload::make('proof')
                                    ->image()
                                    ->required(),
                            ]),
                        ]),

                ])
                    ->columnSpanFull()
                    ->columns(1)
                    ->skippable()

            ]);
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        $selectedCosmetics = collect($get('transactionDetails'))
            ->filter(
                fn($item) =>
                !empty($item['cosmetic_id']) && !empty($item['quantity'])
            );

        $cosmetics = Cosmetic::whereIn('id', $selectedCosmetics->pluck('cosmetic_id'))
            ->get()
            ->keyBy('id');

        $subtotal = $selectedCosmetics->reduce(function ($subtotal, $item) use ($cosmetics) {

            $price = $cosmetics[$item['cosmetic_id']]->price ?? 0;
            $qty = (int) ($item['quantity'] ?? 0);

            return $subtotal + ($price * $qty);
        }, 0);

        $total_tax_amount = round($subtotal * 0.11);
        $total_amount = round($subtotal + $total_tax_amount);

        $total_quantity = $selectedCosmetics->sum(
            fn($item) =>
            (int) ($item['quantity'] ?? 0)
        );

        $set('total_quantity', $total_quantity);
        $set('sub_total_amount', $subtotal);
        $set('total_tax_amount', $total_tax_amount);
        $set('total_amount', $total_amount);
    }
}
